<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { ref, watch } from 'vue';
import debounce from 'lodash/debounce';

const props = defineProps({
    items: Object,
    filters: Object,
});

const search = ref(props.filters.search || '');

// Debounced search to avoid too many requests
const performSearch = debounce(() => {
    router.get('/inventory', { search: search.value }, {
        preserveState: true,
        replace: true,
    });
}, 300);

watch(search, () => {
    performSearch();
});

const deleteItem = (item) => {
    if (confirm(`Are you sure you want to delete "${item.name}"?`)) {
        router.delete(route('inventory.destroy', item.id), {
            preserveScroll: true,
        });
    }
};
</script>

<template>
    <Head title="Inventory Management" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Inventory Management</h2>
                <div class="flex gap-2">
                    <Link :href="route('stock.add')" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        Add Stock
                    </Link>
                    <Link :href="route('stock.deduct')" class="inline-flex items-center px-4 py-2 bg-orange-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-orange-700 focus:bg-orange-700 active:bg-orange-900 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        Deduct Stock
                    </Link>
                    <Link :href="route('inventory.create')" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        New Item
                    </Link>
                </div>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <!-- Search Bar -->
                        <div class="mb-6">
                            <input
                                v-model="search"
                                type="text"
                                placeholder="Search items by name, SKU, or description..."
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                            />
                        </div>

                        <!-- Items Table -->
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Item Name</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">SKU</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Unit</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr v-for="item in items.data" :key="item.id" class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ item.name }}</div>
                                            <div v-if="item.description" class="text-sm text-gray-500">{{ item.description.substring(0, 50) }}{{ item.description.length > 50 ? '...' : '' }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ item.sku || '-' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium" :class="item.is_low_stock ? 'text-red-600' : 'text-gray-900'">
                                                {{ Number(item.current_quantity).toLocaleString() }}
                                            </div>
                                            <div v-if="item.minimum_quantity" class="text-xs text-gray-500">
                                                Min: {{ Number(item.minimum_quantity).toLocaleString() }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ item.measurement_unit.symbol }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span v-if="item.is_low_stock" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                Low Stock
                                            </span>
                                            <span v-else class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                In Stock
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                            <Link :href="route('inventory.show', item.id)" class="text-blue-600 hover:text-blue-900">View</Link>
                                            <Link :href="route('inventory.edit', item.id)" class="text-indigo-600 hover:text-indigo-900">Edit</Link>
                                            <button @click="deleteItem(item)" class="text-red-600 hover:text-red-900">Delete</button>
                                        </td>
                                    </tr>
                                    <tr v-if="items.data.length === 0">
                                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                            No items found. <Link :href="route('inventory.create')" class="text-blue-600 hover:text-blue-900">Create your first item</Link>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div v-if="items.links.length > 3" class="mt-6 flex justify-between items-center">
                            <div class="text-sm text-gray-700">
                                Showing {{ items.from }} to {{ items.to }} of {{ items.total }} results
                            </div>
                            <div class="flex gap-1">
                                <Link
                                    v-for="(link, index) in items.links"
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
