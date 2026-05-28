// Generic AJAX Modal Handler
class AjaxModal {
    constructor(options = {}) {
        this.modalId = options.modalId || 'ajaxModal';
        this.containerSelector = options.containerSelector || '#ajaxModalBody';
        this.modalTitleSelector = options.modalTitleSelector || '#ajaxModalLabel';
        this.syncStorageKey = options.syncStorageKey || 'ajax-modal:last-change';
        this.syncPollInterval = options.syncPollInterval || 1;
        this.syncTabId = `${Date.now()}-${Math.random().toString(36).slice(2, 10)}`;
        this.csrfToken = $('meta[name="csrf-token"]').attr('content');
        this.isRefreshingTable = false;
        this.canUseLocalStorage = this.checkLocalStorageSupport();
        this.lastSyncPayload = null;
        this.init();
    }

    init() {
        this.createModal();
        this.setupEventHandlers();
        this.setupSyncHandlers();
    }

    checkLocalStorageSupport() {
        try {
            const testKey = '__ajax_modal_sync_test__';
            localStorage.setItem(testKey, '1');
            localStorage.removeItem(testKey);
            return true;
        } catch (error) {
            return false;
        }
    }

    setupSyncHandlers() {
        if (this.canUseLocalStorage) {
            this.syncListener = (event) => {
                if (event.key === this.syncStorageKey && event.newValue) {
                    this.handleSyncSignal(event.newValue);
                }
            };

            window.addEventListener('storage', this.syncListener);
        }

        this.syncPollTimer = window.setInterval(() => {
            if (this.hasSyncableTable()) {
                this.refreshTable();
            }
        }, this.syncPollInterval);
    }

    handleSyncSignal(payload) {
        if (!payload || payload === this.lastSyncPayload) {
            return;
        }

        this.lastSyncPayload = payload;
        this.refreshTable();
    }

    broadcastTableChange() {
        if (!this.canUseLocalStorage) {
            return;
        }

        const payload = JSON.stringify({
            changedAt: Date.now(),
            source: this.syncTabId,
        });

        try {
            localStorage.setItem(this.syncStorageKey, payload);
        } catch (error) {
            // Ignore storage write failures and rely on polling.
        }
    }

    hasSyncableTable() {
        return this.getTableWrappers().some((tableConfig) => $(tableConfig.selector).length);
    }

    getTableWrappers() {
        return [
            { selector: '.students-table-wrap' },
            { selector: '.subjects-table-wrap' },
            { selector: '.degrees-table-wrap' },
            { selector: '.teachers-table-wrap' }
        ];
    }

    createModal() {
        const existingModal = $(`#${this.modalId}`);

        if (existingModal.length && existingModal.find(this.containerSelector).length && existingModal.find(this.modalTitleSelector).length) {
            return;
        }

        if (existingModal.length) {
            existingModal.find('.modal-body').attr('id', this.containerSelector.slice(1));
            existingModal.find('.modal-title').attr('id', this.modalTitleSelector.slice(1));
            return;
        }

        const modalHtml = `
            <div class="modal fade" id="${this.modalId}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="${this.modalTitleSelector.slice(1)}">Loading...</h5>
                        </div>
                        <div class="modal-body" id="${this.containerSelector.slice(1)}">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;
        $('body').append(modalHtml);
    }

    setupEventHandlers() {
        $(document).on('click', '[data-ajax-modal]', (e) => {
            e.preventDefault();
            const url = $(e.currentTarget).attr('href') || $(e.currentTarget).data('url');
            const title = $(e.currentTarget).data('title') || 'Details';
            this.loadContent(url, title);
        });

        $(document).on('click', '[data-ajax-submit]', (e) => {
            e.preventDefault();
            $(e.currentTarget).closest('form').trigger('submit');
        });

        $(document).on('click', '#ajaxModalSubmit', (e) => {
            e.preventDefault();
            const form = $(`#${this.modalId} ${this.containerSelector} form`);
            if (form.length) {
                form.submit();
            }
        });

        $(document).on('click', '[data-ajax-delete]', (e) => {
            e.preventDefault();
            if (confirm('Are you sure you want to delete this record?')) {
                const url = $(e.currentTarget).data('url');
                this.deleteRecord(url);
            }
        });

        $(document).on('submit', `${this.containerSelector} form`, (e) => {
            e.preventDefault();
            const form = $(e.currentTarget);
            this.submitForm(form);
        });
    }

    loadContent(url, title = 'Details') {
        $.ajax({
            url: url,
            type: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json,text/html,*/*',
            },
            success: (html) => {
                $(`#${this.modalId} ${this.modalTitleSelector}`).text(title);
                $(`#${this.modalId} ${this.containerSelector}`).html(html);
                new bootstrap.Modal(document.getElementById(this.modalId)).show();
            },
            error: (xhr) => {
                this.showError('Unable to load content. Please try again.');
            }
        });
    }

    submitForm(form) {
        // Clear previous errors
        form.find('.is-invalid').removeClass('is-invalid');
        form.find('.invalid-feedback').remove();

        const url = form.attr('action');
        const method = (form.find('input[name="_method"]').val() || form.attr('method') || 'POST').toUpperCase();
        const formData = new FormData(form[0]);

        $.ajax({
            url: url,
            type: method,
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': this.csrfToken,
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            },
            success: (response) => {
                this.showSuccess(response.message || 'Operation successful!');
                const modalElement = document.getElementById(this.modalId);
                const modalInstance = bootstrap.Modal.getInstance(modalElement);
                if (modalInstance) {
                    modalInstance.hide();
                }
                this.broadcastTableChange();
                // Refresh table without full page reload
                this.refreshTable();
            },
            error: (xhr) => {
                const errors = xhr.responseJSON?.errors;
                if (errors) {
                    // Display errors inline in form fields
                    this.displayFormErrors(form, errors);
                } else {
                    this.showError(xhr.responseJSON?.message || 'An error occurred.');
                }
            }
        });
    }

    deleteRecord(url) {
        $.ajax({
            url: url,
            type: 'POST',
            data: { _method: 'DELETE' },
            headers: {
                'X-CSRF-TOKEN': this.csrfToken,
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            },
            success: (response) => {
                this.showSuccess(response.message || 'Record deleted successfully!');
                this.broadcastTableChange();
                // Refresh table without full page reload
                this.refreshTable();
            },
            error: (xhr) => {
                this.showError(xhr.responseJSON?.message || 'Unable to delete record.');
            }
        });
    }

    // Dynamically refresh table without full page reload
    refreshTable() {
        if (this.isRefreshingTable) {
            return;
        }

        // Detect table type from current page URL or DOM
        const tableWrappers = this.getTableWrappers().map((tableConfig) => ({
            ...tableConfig,
            url: this.getCurrentPageUrl(),
        }));

        // Find which table is on current page
        for (let tableConfig of tableWrappers) {
            const tableWrapper = $(tableConfig.selector);
            if (tableWrapper.length) {
                this.isRefreshingTable = true;
                // Fetch current page and extract table
                $.ajax({
                    url: tableConfig.url,
                    type: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    success: (html) => {
                        // Extract the table from the new HTML
                        const newTable = $(html).find(tableConfig.selector).first();
                        if (newTable.length && newTable.prop('outerHTML') !== tableWrapper.prop('outerHTML')) {
                            // Replace old table with new one
                            tableWrapper.fadeOut(200, () => {
                                tableWrapper.replaceWith(newTable);
                                newTable.fadeIn(200);
                            });
                        }
                    },
                    error: () => {
                        // Fallback to full reload on error
                        location.reload();
                    },
                    complete: () => {
                        this.isRefreshingTable = false;
                    }
                });
                break; // Only refresh the first table found
            }
        }
    }

    // Get current page URL for table refresh
    getCurrentPageUrl() {
        return window.location.href.split('?')[0]; // Remove query params if any
    }

    // Display validation errors inline in form fields
    displayFormErrors(form, errors) {
        // Clear previous errors
        form.find('.is-invalid').removeClass('is-invalid');
        form.find('.invalid-feedback').remove();

        // Add errors for each field
        Object.keys(errors).forEach(fieldName => {
            const fieldMessages = errors[fieldName];
            const input = form.find('[name="' + fieldName + '"]');
            
            if (input.length) {
                // Mark field as invalid
                input.addClass('is-invalid');
                
                // Add error message
                const errorHtml = '<div class="invalid-feedback d-block">' + fieldMessages.join('<br>') + '</div>';
                input.after(errorHtml);
            }
        });

        // Scroll to first error field
        const firstInvalid = form.find('.is-invalid').first();
        if (firstInvalid.length) {
            firstInvalid[0].scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    }

    showSuccess(message) {
        const alert = `
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle"></i> ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `;
        $('body').prepend(alert);
        setTimeout(() => {
            $('.alert').fadeOut('slow', function() { $(this).remove(); });
        }, 3000);
    }

    showError(message) {
        const alert = `
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle"></i> ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `;
        $('body').prepend(alert);
    }
}

// Initialize on document ready
$(document).ready(function() {
    window.ajaxModal = new AjaxModal();
});
