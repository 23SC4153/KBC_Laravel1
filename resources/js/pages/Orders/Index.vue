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
    orders: {
        data: Order[];
        links: any;
    };
}

defineProps<Props>();

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Dashboard', href: '/dashboard' },
    { title: 'Orders', href: '/orders' },
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
        month: 'short',
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
</script>

<template>
    <Head title="My Orders" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-6 p-6">
            <!-- Header -->
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold tracking-tight">My Orders</h1>
                    <p class="text-muted-foreground">View and manage your orders</p>
                </div>
                <Link href="/orders/create">
                    <Button>New Order</Button>
                </Link>
            </div>

            <!-- Orders List -->
            <div v-if="orders.data.length > 0" class="space-y-4">
                <div
                    v-for="order in orders.data"
                    :key="order.id"
                    class="rounded-xl border border-sidebar-border/70 bg-card p-6 dark:border-sidebar-border"
                >
                    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                        <div class="space-y-1">
                            <div class="flex items-center gap-3">
                                <h3 class="font-semibold">{{ order.order_number }}</h3>
                                <Badge :class="statusColors[order.status]">
                                    {{ order.status }}
                                </Badge>
                            </div>
                            <p class="text-sm text-muted-foreground">
                                {{ formatDate(order.created_at) }}
                            </p>
                            <p class="text-sm text-muted-foreground">
                                {{ order.items.length }} item(s)
                            </p>
                        </div>
                        <div class="flex items-center gap-4">
                            <div class="text-right">
                                <p class="text-sm text-muted-foreground">Total</p>
                                <p class="text-lg font-semibold">{{ formatCurrency(order.total) }}</p>
                            </div>
                            <Link :href="`/orders/${order.id}`">
                                <Button variant="outline" size="sm">View Details</Button>
                            </Link>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Empty State -->
            <div v-else class="flex flex-1 flex-col items-center justify-center rounded-xl border border-dashed border-sidebar-border/70 p-12 dark:border-sidebar-border">
                <div class="text-center">
                    <h3 class="text-lg font-semibold">No orders yet</h3>
                    <p class="mt-1 text-sm text-muted-foreground">
                        Get started by creating your first order.
                    </p>
                    <Link href="/orders/create" class="mt-4 inline-block">
                        <Button>Create Order</Button>
                    </Link>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
