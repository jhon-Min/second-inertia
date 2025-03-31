<template>
    <AuthenticatedLayout>
        <div class="px-[100px] mt-8 w-10/12">
            <h3 class="mb-4 text-lg font-semibold">Edit City</h3>
            <form @submit.prevent="form.put(route('cities.update', form.id))">
                <div class="mb-4">
                    <label
                        for="common"
                        class="block text-sm font-medium text-gray-700"
                        >Capital Name
                    </label>
                    <input
                        id="capital"
                        v-model="form.capital"
                        type="text"
                        class="block w-full px-4 py-2 mt-1 border border-gray-300 rounded-md"
                    />
                    <p v-if="errors.capital" class="mt-1 text-sm text-red-600">
                        {{ errors.capital }}
                    </p>
                </div>

                <div class="mb-4">
                    <label
                        for="countries"
                        class="block mb-2 text-sm font-medium text-gray-900"
                        >Select Country</label
                    >
                    <select
                        id="countries"
                        v-model="form.country_id"
                        class="text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50"
                    >
                        <option value="" disabled selected>
                            Choose a country
                        </option>
                        <option
                            v-for="country in countries"
                            :key="country.id"
                            :value="country.id"
                        >
                            {{ country.common }}
                        </option>
                    </select>

                    <p
                        v-if="errors.country_id"
                        class="mt-1 text-sm text-red-600"
                    >
                        {{ errors.country_id }}
                    </p>
                </div>

                <div class="flex mt-[50px]">
                    <Link
                        type="button"
                        :href="route('cities.index')"
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
    city: {
        type: Object,
        required: true,
    },
    countries: {
        type: Object,
        required: true,
    },
});

const form = useForm({
    id: props.city.id,
    capital: props.city.capital,
    country_id: props.city.country_id,
});
</script>
