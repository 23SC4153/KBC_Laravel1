<script setup lang="ts">
import { Head, router } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { type BreadcrumbItem } from '@/types';

interface Product {
    id: number;
    name: string;
    description: string | null;
    price: string;
    stock: number;
}

interface CartItem {
    product: Product;
    quantity: number;
}

interface Props {
    products: Product[];
}

const props = defineProps<Props>();

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Dashboard', href: '/dashboard' },
    { title: 'Orders', href: '/orders' },
    { title: 'New Order', href: '/orders/create' },
];

const cart = ref<CartItem[]>([]);
const notes = ref('');
const isSubmitting = ref(false);

const addToCart = (product: Product) => {
    const existing = cart.value.find(item => item.product.id === product.id);
    if (existing) {
        if (existing.quantity < product.stock) {
            existing.quantity++;
        }
    } else {
        cart.value.push({ product, quantity: 1 });
    }
};

const removeFromCart = (productId: number) => {
    cart.value = cart.value.filter(item => item.product.id !== productId);
};

const updateQuantity = (productId: number, quantity: number) => {
    const item = cart.value.find(item => item.product.id === productId);
    if (item) {
        if (quantity <= 0) {
            removeFromCart(productId);
        } else if (quantity <= item.product.stock) {
            item.quantity = quantity;
        }
    }
};

const subtotal = computed(() => {
    return cart.value.reduce((sum, item) => {
        return sum + parseFloat(item.product.price) * item.quantity;
    }, 0);
});

const tax = computed(() => subtotal.value * 0.1);
const total = computed(() => subtotal.value + tax.value);

const formatCurrency = (amount: number) => {
    return new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD',
    }).format(amount);
};

const submitOrder = () => {
    if (cart.value.length === 0) return;

    isSubmitting.value = true;

    router.post('/orders', {
        items: cart.value.map(item => ({
            product_id: item.product.id,
            quantity: item.quantity,
        })),
        notes: notes.value || null,
    }, {
        onFinish: () => {
            isSubmitting.value = false;
        },
    });
};
</script>

<template>
    <Head title="Create Order" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-6 p-6 lg:flex-row">
            <!-- Products Grid -->
            <div class="flex-1 space-y-4">
                <div>
                    <h2 class="text-2xl font-bold tracking-tight">Products</h2>
                    <p class="text-muted-foreground">Select products to add to your order</p>
                </div>

                <div v-if="products.length > 0" class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3">
                    <div
                        v-for="product in products"
                        :key="product.id"
                        class="rounded-xl border border-sidebar-border/70 bg-card p-4 dark:border-sidebar-border"
                    >
                        <div class="space-y-2">
                            <h3 class="font-semibold">{{ product.name }}</h3>
                            <p v-if="product.description" class="text-sm text-muted-foreground line-clamp-2">
                                {{ product.description }}
                            </p>
                            <div class="flex items-center justify-between">
                                <span class="text-lg font-bold">{{ formatCurrency(parseFloat(product.price)) }}</span>
                                <span class="text-sm text-muted-foreground">Stock: {{ product.stock }}</span>
                            </div>
                            <Button
                                @click="addToCart(product)"
                                :disabled="product.stock === 0"
                                class="w-full"
                                size="sm"
                            >
                                {{ product.stock === 0 ? 'Out of Stock' : 'Add to Order' }}
                            </Button>
                        </div>
                    </div>
                </div>

                <div v-else class="flex flex-1 flex-col items-center justify-center rounded-xl border border-dashed border-sidebar-border/70 p-12 dark:border-sidebar-border">
                    <p class="text-muted-foreground">No products available</p>
                </div>
            </div>

            <!-- Cart Sidebar -->
            <div class="w-full lg:w-96">
                <div class="sticky top-6 rounded-xl border border-sidebar-border/70 bg-card p-6 dark:border-sidebar-border">
                    <h2 class="mb-4 text-xl font-bold">Order Summary</h2>

                    <div v-if="cart.length > 0" class="space-y-4">
                        <!-- Cart Items -->
                        <div class="max-h-64 space-y-3 overflow-y-auto">
                            <div
                                v-for="item in cart"
                                :key="item.product.id"
                                class="flex items-center justify-between gap-2 rounded-lg bg-muted/50 p-3"
                            >
                                <div class="flex-1 min-w-0">
                                    <p class="font-medium truncate">{{ item.product.name }}</p>
                                    <p class="text-sm text-muted-foreground">
                                        {{ formatCurrency(parseFloat(item.product.price)) }} each
                                    </p>
                                </div>
                                <div class="flex items-center gap-2">
                                    <Input
                                        type="number"
                                        :value="item.quantity"
                                        @input="updateQuantity(item.product.id, parseInt(($event.target as HTMLInputElement).value) || 0)"
                                        min="1"
                                        :max="item.product.stock"
                                        class="w-16 text-center"
                                    />
                                    <Button
                                        variant="ghost"
                                        size="sm"
                                        @click="removeFromCart(item.product.id)"
                                    >
                                        ✕
                                    </Button>
                                </div>
                            </div>
                        </div>

                        <!-- Notes -->
                        <div class="space-y-2">
                            <Label for="notes">Order Notes (optional)</Label>
                            <Input
                                id="notes"
                                v-model="notes"
                                placeholder="Special instructions..."
                            />
                        </div>

                        <!-- Totals -->
                        <div class="border-t pt-4 space-y-2">
                            <div class="flex justify-between text-sm">
                                <span>Subtotal</span>
                                <span>{{ formatCurrency(subtotal) }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span>Tax (10%)</span>
                                <span>{{ formatCurrency(tax) }}</span>
                            </div>
                            <div class="flex justify-between font-bold text-lg">
                                <span>Total</span>
                                <span>{{ formatCurrency(total) }}</span>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <Button
                            @click="submitOrder"
                            :disabled="isSubmitting"
                            class="w-full"
                        >
                            {{ isSubmitting ? 'Placing Order...' : 'Place Order' }}
                        </Button>
                    </div>

                    <div v-else class="text-center py-8">
                        <p class="text-muted-foreground">Your cart is empty</p>
                        <p class="text-sm text-muted-foreground mt-1">Add products to get started</p>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
