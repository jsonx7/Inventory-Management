<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps({
    item: Object,
    transactions: Object,
});

const formatDate = (date) => {
    return new Date(date).toLocaleString();
};

const formatNumber = (number) => {
    return Number(number).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 4 });
};
</script>

<template>
    <Head :title="`Inventory - ${item.name}`" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ item.name }}</h2>
                <div class="flex gap-2">
                    <Link :href="route('inventory.edit', item.id)" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                        Edit Item
                    </Link>
                    <Link :href="route('inventory.index')" class="text-sm text-gray-600 hover:text-gray-900 flex items-center">
                        Back to Inventory
                    </Link>
                </div>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <!-- Item Details Card -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4">Item Details</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <p class="text-sm text-gray-500">Name</p>
                                <p class="text-base font-medium">{{ item.name }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">SKU</p>
                                <p class="text-base font-medium">{{ item.sku || 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Current Quantity</p>
                                <p class="text-base font-medium" :class="item.is_low_stock ? 'text-red-600' : ''">
                                    {{ formatNumber(item.current_quantity) }} {{ item.measurement_unit.symbol }}
                                </p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Measurement Unit</p>
                                <p class="text-base font-medium">{{ item.measurement_unit.name }} ({{ item.measurement_unit.symbol }})</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Minimum Quantity</p>
                                <p class="text-base font-medium">{{ item.minimum_quantity ? `${formatNumber(item.minimum_quantity)} ${item.measurement_unit.symbol}` : 'Not set' }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Unit Price</p>
                                <p class="text-base font-medium">{{ item.unit_price ? `$${formatNumber(item.unit_price)}` : 'Not set' }}</p>
                            </div>
                            <div v-if="item.description" class="md:col-span-2">
                                <p class="text-sm text-gray-500">Description</p>
                                <p class="text-base">{{ item.description }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Status</p>
                                <span v-if="item.is_low_stock" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                    Low Stock
                                </span>
                                <span v-else class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    In Stock
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Transaction History Card -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4">Transaction History</h3>
                        
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Before</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">After</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Notes</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr v-for="transaction in transactions.data" :key="transaction.id" class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ formatDate(transaction.transaction_date) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span
                                                :class="transaction.type === 'addition' ? 'bg-green-100 text-green-800' : 'bg-orange-100 text-orange-800'"
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full"
                                            >
                                                {{ transaction.type === 'addition' ? '+ Addition' : '- Deduction' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium"
                                            :class="transaction.type === 'addition' ? 'text-green-600' : 'text-orange-600'"
                                        >
                                            {{ formatNumber(transaction.quantity) }} {{ item.measurement_unit.symbol }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ formatNumber(transaction.quantity_before) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">
                                            {{ formatNumber(transaction.quantity_after) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ transaction.user.name }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500">
                                            <div v-if="transaction.reference_number" class="font-medium">
                                                Ref: {{ transaction.reference_number }}
                                            </div>
                                            <div v-if="transaction.notes">{{ transaction.notes }}</div>
                                        </td>
                                    </tr>
                                    <tr v-if="transactions.data.length === 0">
                                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                                            No transactions yet for this item.
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div v-if="transactions.links.length > 3" class="mt-6 flex justify-between items-center">
                            <div class="text-sm text-gray-700">
                                Showing {{ transactions.from }} to {{ transactions.to }} of {{ transactions.total }} transactions
                            </div>
                            <div class="flex gap-1">
                                <Link
                                    v-for="(link, index) in transactions.links"
                                    :key="index"
                                    :href="link.url"
                                    :class="[
                                        'px-3 py-2 rounded-md text-sm',
                                        link.active ? 'bg-blue-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-50 border border-gray-300',
                                        !link.url ? 'opacity-50 cursor-not-allowed' : ''
                                    ]"
                                    :disabled="!link.url"
                                    v-html="link.label"
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
