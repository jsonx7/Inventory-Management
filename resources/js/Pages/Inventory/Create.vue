<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

const props = defineProps({
    measurementUnits: Array,
});

const form = useForm({
    name: '',
    sku: '',
    description: '',
    measurement_unit_id: '',
    current_quantity: 0,
    minimum_quantity: '',
    unit_price: '',
});

const submit = () => {
    form.post(route('inventory.store'));
};
</script>

<template>
    <Head title="Create Inventory Item" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Create New Inventory Item</h2>
                <Link :href="route('inventory.index')" class="text-sm text-gray-600 hover:text-gray-900">Back to Inventory</Link>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <form @submit.prevent="submit" class="p-6 space-y-6">
                        <!-- Item Name -->
                        <div>
                            <InputLabel for="name" value="Item Name *" />
                            <TextInput
                                id="name"
                                v-model="form.name"
                                type="text"
                                class="mt-1 block w-full"
                                required
                                autofocus
                            />
                            <InputError class="mt-2" :message="form.errors.name" />
                        </div>

                        <!-- SKU -->
                        <div>
                            <InputLabel for="sku" value="SKU (Stock Keeping Unit)" />
                            <TextInput
                                id="sku"
                                v-model="form.sku"
                                type="text"
                                class="mt-1 block w-full"
                            />
                            <InputError class="mt-2" :message="form.errors.sku" />
                            <p class="mt-1 text-sm text-gray-500">Optional unique identifier for this item</p>
                        </div>

                        <!-- Description -->
                        <div>
                            <InputLabel for="description" value="Description" />
                            <textarea
                                id="description"
                                v-model="form.description"
                                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                rows="3"
                            ></textarea>
                            <InputError class="mt-2" :message="form.errors.description" />
                        </div>

                        <!-- Measurement Unit -->
                        <div>
                            <InputLabel for="measurement_unit_id" value="Measurement Unit *" />
                            <select
                                id="measurement_unit_id"
                                v-model="form.measurement_unit_id"
                                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                required
                            >
                                <option value="">Select a unit</option>
                                <optgroup v-for="type in ['weight', 'length', 'volume', 'quantity']" :key="type" :label="type.charAt(0).toUpperCase() + type.slice(1)">
                                    <option
                                        v-for="unit in measurementUnits.filter(u => u.type === type)"
                                        :key="unit.id"
                                        :value="unit.id"
                                    >
                                        {{ unit.name }} ({{ unit.symbol }})
                                    </option>
                                </optgroup>
                            </select>
                            <InputError class="mt-2" :message="form.errors.measurement_unit_id" />
                        </div>

                        <!-- Current Quantity -->
                        <div>
                            <InputLabel for="current_quantity" value="Initial Quantity *" />
                            <TextInput
                                id="current_quantity"
                                v-model="form.current_quantity"
                                type="number"
                                step="0.0001"
                                min="0"
                                class="mt-1 block w-full"
                                required
                            />
                            <InputError class="mt-2" :message="form.errors.current_quantity" />
                        </div>

                        <!-- Minimum Quantity -->
                        <div>
                            <InputLabel for="minimum_quantity" value="Minimum Quantity (Low Stock Alert)" />
                            <TextInput
                                id="minimum_quantity"
                                v-model="form.minimum_quantity"
                                type="number"
                                step="0.0001"
                                min="0"
                                class="mt-1 block w-full"
                            />
                            <InputError class="mt-2" :message="form.errors.minimum_quantity" />
                            <p class="mt-1 text-sm text-gray-500">Optional: Alert when stock falls below this level</p>
                        </div>

                        <!-- Unit Price -->
                        <div>
                            <InputLabel for="unit_price" value="Unit Price" />
                            <TextInput
                                id="unit_price"
                                v-model="form.unit_price"
                                type="number"
                                step="0.01"
                                min="0"
                                class="mt-1 block w-full"
                            />
                            <InputError class="mt-2" :message="form.errors.unit_price" />
                            <p class="mt-1 text-sm text-gray-500">Optional: Price per unit for inventory valuation</p>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex items-center justify-end gap-4">
                            <Link :href="route('inventory.index')" class="text-sm text-gray-600 hover:text-gray-900">Cancel</Link>
                            <PrimaryButton :disabled="form.processing">Create Item</PrimaryButton>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
