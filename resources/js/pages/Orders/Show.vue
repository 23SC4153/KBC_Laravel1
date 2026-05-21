<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { Button } from '@/components/ui/button';
import { Badge } from '@/components/ui/badge';
import { type BreadcrumbItem } from '@/types';

interface OrderItem {
    id: number;
    quantity: number;
    unit_price: string;
    total: string;
    product: {
        id: number;
        name: string;
        description: string | null;
    };
}

interface Order {
    id: number;
    order_number: string;
    status: 'pending' | 'processing' | 'completed' | 'cancelled';
    subtotal: string;
    tax: string;
    total: string;
    notes: string | null;
    created_at: string;
    items: OrderItem[];
}

interface Props {
    order: Order;
}

const props = defineProps<Props>();

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Dashboard', href: '/dashboard' },
    { title: 'Orders', href: '/orders' },
    { title: props.order.order_number, href: `/orders/${props.order.id}` },
];

const statusColors: Record<string, string> = {
    pending: 'bg-yellow-100 text-yellow-800',
    processing: 'bg-blue-100 text-blue-800',
    completed: 'bg-green-100 text-green-800',
    cancelled: 'bg-red-100 text-red-800',
};

const formatDate = (date: string) => {
    return new Date(date).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit',
    });
};

const formatCurrency = (amount: string) => {
    return new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD',
    }).format(parseFloat(amount));
};

const cancelOrder = () => {
    if (confirm('Are you sure you want to cancel this order?')) {
        router.post(`/orders/${props.order.id}/cancel`);
    }
};
</script>

<template>
    <Head :title="`Order ${order.order_number}`" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-6 p-6">
            <!-- Header -->
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div>
                    <div class="flex items-center gap-3">
                        <h1 class="text-3xl font-bold tracking-tight">{{ order.order_number }}</h1>
                        <Badge :class="statusColors[order.status]" class="text-sm">
                            {{ order.status }}
                        </Badge>
                    </div>
                    <p class="text-muted-foreground">{{ formatDate(order.created_at) }}</p>
                </div>
                <div class="flex gap-2">
                    <Link href="/orders">
                        <Button variant="outline">Back to Orders</Button>
                    </Link>
                    <Button
                        v-if="order.status === 'pending'"
                        variant="destructive"
                        @click="cancelOrder"
                    >
                        Cancel Order
                    </Button>
                </div>
            </div>

            <div class="grid gap-6 lg:grid-cols-3">
                <!-- Order Items -->
                <div class="lg:col-span-2 rounded-xl border border-sidebar-border/70 bg-card p-6 dark:border-sidebar-border">
                    <h2 class="mb-4 text-xl font-semibold">Order Items</h2>
                    <div class="space-y-4">
                        <div
                            v-for="item in order.items"
                            :key="item.id"
                            class="flex items-center justify-between rounded-lg bg-muted/50 p-4"
                        >
                            <div>
                                <h3 class="font-medium">{{ item.product.name }}</h3>
                                <p class="text-sm text-muted-foreground">
                                    {{ formatCurrency(item.unit_price) }} × {{ item.quantity }}
                                </p>
                            </div>
                            <span class="font-semibold">{{ formatCurrency(item.total) }}</span>
                        </div>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="rounded-xl border border-sidebar-border/70 bg-card p-6 dark:border-sidebar-border">
                    <h2 class="mb-4 text-xl font-semibold">Order Summary</h2>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-muted-foreground">Subtotal</span>
                            <span>{{ formatCurrency(order.subtotal) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-muted-foreground">Tax (10%)</span>
                            <span>{{ formatCurrency(order.tax) }}</span>
                        </div>
                        <div class="border-t pt-3 flex justify-between font-bold text-lg">
                            <span>Total</span>
                            <span>{{ formatCurrency(order.total) }}</span>
                        </div>
                    </div>

                    <div v-if="order.notes" class="mt-6 border-t pt-4">
                        <h3 class="font-medium mb-2">Order Notes</h3>
                        <p class="text-sm text-muted-foreground">{{ order.notes }}</p>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
