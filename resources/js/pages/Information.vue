<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Information',
        href: '/information',
    },
];
</script>

<template>
    <Head title="Information" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-6 p-6">
            <!-- Page Header -->
            <div class="space-y-2">
                <h1 class="text-3xl font-bold tracking-tight">Information</h1>
                <p class="text-muted-foreground">
                    Welcome to our information page. Here you can find helpful details about our application.
                </p>
            </div>

            <!-- Info Cards -->
            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                <!-- About Card -->
                <div class="rounded-xl border border-sidebar-border/70 bg-card p-6 dark:border-sidebar-border">
                    <h2 class="mb-3 text-xl font-semibold">About Us</h2>
                    <p class="text-sm text-muted-foreground">
                        Learn more about our mission, vision, and the team behind this application.
                    </p>
                </div>

                <!-- Features Card -->
                <div class="rounded-xl border border-sidebar-border/70 bg-card p-6 dark:border-sidebar-border">
                    <h2 class="mb-3 text-xl font-semibold">Features</h2>
                    <p class="text-sm text-muted-foreground">
                        Discover the powerful features and capabilities that our platform offers.
                    </p>
                </div>

                <!-- Contact Card -->
                <div class="rounded-xl border border-sidebar-border/70 bg-card p-6 dark:border-sidebar-border">
                    <h2 class="mb-3 text-xl font-semibold">Contact</h2>
                    <p class="text-sm text-muted-foreground">
                        Have questions? Reach out to our support team for assistance.
                    </p>
                </div>
            </div>

            <!-- Additional Info Section -->
            <div class="rounded-xl border border-sidebar-border/70 bg-card p-6 dark:border-sidebar-border">
                <h2 class="mb-4 text-xl font-semibold">Getting Started</h2>
                <div class="space-y-4 text-sm text-muted-foreground">
                    <p>
                        Thank you for using our application. Here are some helpful tips to get you started:
                    </p>
                    <ul class="ml-6 list-disc space-y-2">
                        <li>Explore the dashboard to see your overview and statistics</li>
                        <li>Check your settings to customize your experience</li>
                        <li>Visit our help center for tutorials and guides</li>
                        <li>Contact support if you need any assistance</li>
                    </ul>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
