<template>
    <AuthenticatedLayout>
        <div class="px-[100px] mt-8 w-10/12">
            <h3 class="mb-4 text-lg font-semibold">Edit Country</h3>
            <form
                @submit.prevent="form.put(route('countries.update', form.id))"
            >
                <div class="mb-4">
                    <label
                        for="common"
                        class="block text-sm font-medium text-gray-700"
                        >Country Common</label
                    >
                    <input
                        id="common"
                        v-model="form.common"
                        type="text"
                        class="block w-full px-4 py-2 mt-1 border border-gray-300 rounded-md"
                    />
                    <p v-if="errors.common" class="mt-1 text-sm text-red-600">
                        {{ errors.common }}
                    </p>
                </div>

                <div class="mb-4">
                    <label
                        for="offical"
                        class="block text-sm font-medium text-gray-700"
                        >Country Offical</label
                    >
                    <input
                        id="offical"
                        v-model="form.offical"
                        type="text"
                        class="block w-full px-4 py-2 mt-1 border border-gray-300 rounded-md"
                    />
                    <p v-if="errors.offical" class="mt-1 text-sm text-red-600">
                        {{ errors.offical }}
                    </p>
                </div>

                <div class="mb-4">
                    <label
                        for="region"
                        class="block text-sm font-medium text-gray-700"
                        >Region</label
                    >
                    <input
                        id="region"
                        v-model="form.region"
                        type="text"
                        class="block w-full px-4 py-2 mt-1 border border-gray-300 rounded-md"
                    />
                    <p v-if="errors.region" class="mt-1 text-sm text-red-600">
                        {{ errors.region }}
                    </p>
                </div>

                <div class="flex mt-[50px]">
                    <Link
                        type="button"
                        :href="route('countries.index')"
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
    country: {
        type: Object,
        required: true,
    },
});

const form = useForm({
    id: props.country.id,
    common: props.country.common,
    offical: props.country.offical,
    region: props.country.region,
});
</script>
