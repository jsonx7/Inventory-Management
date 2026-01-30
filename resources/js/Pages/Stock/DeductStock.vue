<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

const props = defineProps({
    items: Array,
});

const form = useForm({
    items: [
        {
            item_id: '',
            quantity: '',
            reference_number: '',
            notes: '',
        }
    ],
});

const addItemRow = () => {
    form.items.push({
        item_id: '',
        quantity: '',
        reference_number: '',
        notes: '',
    });
};

const removeItemRow = (index) => {
    if (form.items.length > 1) {
        form.items.splice(index, 1);
    }
};

const getItemDetails = (itemId) => {
    return props.items.find(item => item.id == itemId);
};

const getAvailableQuantity = (itemId) => {
    const item = getItemDetails(itemId);
    return item ? Number(item.current_quantity).toLocaleString() : '0';
};

const submit = () => {
    form.post(route('stock.deduct.store'));
};
</script>

<template>
    <Head title="Deduct Stock" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Deduct Stock from Inventory</h2>
                <Link :href="route('inventory.index')" class="text-sm text-gray-600 hover:text-gray-900">Back to Inventory</Link>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <form @submit.prevent="submit" class="p-6 space-y-6">
                        <div class="bg-orange-50 border-l-4 border-orange-400 p-4">
                            <p class="text-sm text-orange-700">
                                Deduct stock from one or multiple items at once. The system will verify sufficient stock before processing. All deductions will be recorded in the transaction history.
                            </p>
                        </div>

                        <InputError v-if="form.errors.error" class="mt-2" :message="form.errors.error" />

                        <!-- Items List -->
                        <div class="space-y-4">
                            <div v-for="(item, index) in form.items" :key="index" class="border border-gray-200 rounded-lg p-4">
                                <div class="flex justify-between items-center mb-4">
                                    <h3 class="font-semibold text-gray-700">Item #{{ index + 1 }}</h3>
                                    <button
                                        v-if="form.items.length > 1"
                                        type="button"
                                        @click="removeItemRow(index)"
                                        class="text-red-600 hover:text-red-900 text-sm"
                                    >
                                        Remove
                                    </button>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <!-- Item Selection -->
                                    <div>
                                        <InputLabel :for="`item_${index}`" value="Select Item *" />
                                        <select
                                            :id="`item_${index}`"
                                            v-model="item.item_id"
                                            class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                            required
                                        >
                                            <option value="">Choose an item...</option>
                                            <option v-for="inventoryItem in items" :key="inventoryItem.id" :value="inventoryItem.id">
                                                {{ inventoryItem.name }} ({{ inventoryItem.measurement_unit.symbol }}) - Available: {{ Number(inventoryItem.current_quantity).toLocaleString() }}
                                            </option>
                                        </select>
                                        <InputError class="mt-2" :message="form.errors[`items.${index}.item_id`]" />
                                    </div>

                                    <!-- Quantity -->
                                    <div>
                                        <InputLabel :for="`quantity_${index}`" value="Quantity to Deduct *" />
                                        <div class="mt-1 flex rounded-md shadow-sm">
                                            <TextInput
                                                :id="`quantity_${index}`"
                                                v-model="item.quantity"
                                                type="number"
                                                step="0.0001"
                                                min="0.0001"
                                                :max="item.item_id ? getItemDetails(item.item_id)?.current_quantity : null"
                                                class="block w-full"
                                                required
                                            />
                                            <span v-if="item.item_id" class="inline-flex items-center px-3 rounded-r-md border border-l-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">
                                                {{ getItemDetails(item.item_id)?.measurement_unit.symbol || '' }}
                                            </span>
                                        </div>
                                        <p v-if="item.item_id" class="mt-1 text-xs text-gray-500">
                                            Available: {{ getAvailableQuantity(item.item_id) }} {{ getItemDetails(item.item_id)?.measurement_unit.symbol }}
                                        </p>
                                        <InputError class="mt-2" :message="form.errors[`items.${index}.quantity`]" />
                                    </div>

                                    <!-- Reference Number -->
                                    <div>
                                        <InputLabel :for="`reference_${index}`" value="Reference Number" />
                                        <TextInput
                                            :id="`reference_${index}`"
                                            v-model="item.reference_number"
                                            type="text"
                                            class="mt-1 block w-full"
                                            placeholder="Sales order, job number, etc."
                                        />
                                        <InputError class="mt-2" :message="form.errors[`items.${index}.reference_number`]" />
                                    </div>

                                    <!-- Notes -->
                                    <div>
                                        <InputLabel :for="`notes_${index}`" value="Notes" />
                                        <TextInput
                                            :id="`notes_${index}`"
                                            v-model="item.notes"
                                            type="text"
                                            class="mt-1 block w-full"
                                            placeholder="Purpose, customer, etc."
                                        />
                                        <InputError class="mt-2" :message="form.errors[`items.${index}.notes`]" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Add More Button -->
                        <div>
                            <button
                                type="button"
                                @click="addItemRow"
                                class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                            >
                                + Add Another Item
                            </button>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex items-center justify-end gap-4 pt-4 border-t">
                            <Link :href="route('inventory.index')" class="text-sm text-gray-600 hover:text-gray-900">Cancel</Link>
                            <PrimaryButton :disabled="form.processing" class="bg-orange-600 hover:bg-orange-700 focus:bg-orange-700 active:bg-orange-900 focus:ring-orange-500">
                                Deduct Stock
                            </PrimaryButton>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
