<template>
    <Head title="Cities" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                City Lists
            </h2>
        </template>

        <div class="px-[40px] mt-8">
            <div class="mb-4">
                <Link
                    :href="route('cities.create')"
                    class="px-4 py-2 text-white bg-blue-500 rounded-md"
                >
                    Add City
                </Link>
            </div>

            <div class="overflow-x-auto bg-white rounded-lg shadow-md">
                <table class="min-w-full border border-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th
                                class="px-6 py-3 text-sm font-semibold tracking-wider text-left text-gray-600 uppercase"
                            >
                                Capital
                            </th>
                            <th
                                class="px-6 py-3 text-sm font-semibold tracking-wider text-left text-gray-600 uppercase"
                            >
                                Country
                            </th>
                            <th
                                class="px-6 py-3 text-sm font-semibold tracking-wider text-left text-gray-600 uppercase"
                            >
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="city in cities.data"
                            :key="city.id"
                            class="border-b border-gray-100 hover:bg-gray-50"
                        >
                            <td
                                class="px-6 py-4 text-sm font-medium text-gray-900"
                            >
                                {{ city.capital }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700">
                                {{ city.country.common }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700">
                                <Link
                                    :href="route('cities.edit', city.id)"
                                    class="px-2 py-1 text-white bg-yellow-500 rounded-md"
                                >
                                    Edit
                                </Link>

                                <button
                                    @click="deleteCity(city.id)"
                                    class="px-2 py-1 text-white bg-red-500 rounded-md ms-3"
                                >
                                    Delete
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="flex items-center justify-between mt-4 pb-[40px]">
                <div class="text-sm text-gray-600">
                    Showing {{ cities.from }} to {{ cities.to }} of
                    {{ cities.total }} currencies
                </div>
                <div class="flex space-x-1">
                    <template
                        v-for="(link, index) in cities.links"
                        :key="index"
                    >
                        <button
                            v-if="link.url"
                            @click="handlePagination(link.url)"
                            class="px-3 py-1 text-sm border rounded-md"
                            :class="{
                                'bg-blue-500 text-white border-blue-500':
                                    link.active,
                                'bg-white text-gray-700 border-gray-300 hover:bg-gray-100':
                                    !link.active,
                            }"
                            v-html="link.label"
                        ></button>
                        <span
                            v-else
                            class="px-3 py-1 text-sm text-gray-400 bg-white border border-gray-200 rounded-md"
                            v-html="link.label"
                        ></span>
                    </template>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, router, Link } from "@inertiajs/vue3";
import { ref } from "vue";

const props = defineProps({
    cities: Object,
});

const handlePagination = (url) => {
    router.visit(url, {
        preserveState: true,
        preserveScroll: true,
    });
};

const deleteCity = (id) => {
    if (confirm("Are you sure you want to delete this city?")) {
        router.delete(`/cities/${id}`);
    }
};
</script>
