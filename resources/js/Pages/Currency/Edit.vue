<template>
    <AuthenticatedLayout>
        <div class="px-[100px] mt-8 w-10/12">
            <h3 class="mb-4 text-lg font-semibold">Edit Currency</h3>
            <form
                @submit.prevent="form.put(route('currencies.update', form.id))"
            >
                <div class="mb-4">
                    <label
                        for="code"
                        class="block text-sm font-medium text-gray-700"
                        >Currency Code</label
                    >
                    <input
                        id="code"
                        v-model="form.code"
                        type="text"
                        class="block w-full px-4 py-2 mt-1 border border-gray-300 rounded-md"
                    />
                    <p v-if="errors.code" class="mt-1 text-sm text-red-600">
                        {{ errors.code }}
                    </p>
                </div>
                <div class="mb-4">
                    <label
                        for="rate"
                        class="block text-sm font-medium text-gray-700"
                        >Exchange Rate</label
                    >
                    <input
                        id="rate"
                        v-model="form.rate"
                        class="block w-full px-4 py-2 mt-1 border border-gray-300 rounded-md"
                    />
                    <p v-if="errors?.rate" class="mt-1 text-sm text-red-600">
                        {{ errors.rate }}
                    </p>
                </div>
                <div class="flex mt-[50px]">
                    <Link
                        type="button"
                        :href="route('currencies.index')"
                        class="px-4 py-2 text-gray-800 bg-gray-300 rounded-md me-5"
                    >
                        Cancel
                    </Link>
                    <button
                        type="submit"
                        class="px-4 py-2 text-white bg-blue-500 rounded-md"
                        :disabled="form.processing"
                    >
                        Save
                    </button>
                </div>
            </form>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { ref } from "vue";
import { Link, useForm } from "@inertiajs/vue3";

const props = defineProps({
    errors: Object,
    currency: {
        type: Object,
        required: true,
    },
});

const form = useForm({
    id: props.currency.id,
    code: props.currency.code,
    rate: parseFloat(props.currency.rate),
});
</script>

<style lang="scss" scoped></style>
