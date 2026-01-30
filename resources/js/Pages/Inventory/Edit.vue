<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

const props = defineProps({
    item: Object,
    measurementUnits: Array,
});

const form = useForm({
    name: props.item.name,
    sku: props.item.sku,
    description: props.item.description,
    measurement_unit_id: props.item.measurement_unit_id,
    minimum_quantity: props.item.minimum_quantity,
    unit_price: props.item.unit_price,
});

const submit = () => {
    form.put(route('inventory.update', props.item.id));
};
</script>

<template>
    <Head title="Edit Inventory Item" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit: {{ item.name }}</h2>
                <Link :href="route('inventory.show', item.id)" class="text-sm text-gray-600 hover:text-gray-900">Back to Item</Link>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <form @submit.prevent="submit" class="p-6 space-y-6">
                        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4">
                            <p class="text-sm text-yellow-700">
                                <strong>Note:</strong> Current quantity cannot be edited here. Use "Add Stock" or "Deduct Stock" to change quantities.
                            </p>
                        </div>

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

                        <!-- Current Quantity (Read-only) -->
                        <div>
                            <InputLabel for="current_quantity" value="Current Quantity (Read-only)" />
                            <TextInput
                                id="current_quantity"
                                :model-value="Number(item.current_quantity).toLocaleString()"
                                type="text"
                                class="mt-1 block w-full bg-gray-100"
                                disabled
                            />
                            <p class="mt-1 text-sm text-gray-500">Use Add Stock or Deduct Stock to modify quantities</p>
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
                        </div>

                        <!-- Submit Button -->
                        <div class="flex items-center justify-end gap-4">
                            <Link :href="route('inventory.show', item.id)" class="text-sm text-gray-600 hover:text-gray-900">Cancel</Link>
                            <PrimaryButton :disabled="form.processing">Update Item</PrimaryButton>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
