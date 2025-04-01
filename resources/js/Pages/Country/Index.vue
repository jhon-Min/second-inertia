<template>
    <Head title="Countries" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Country Lists
            </h2>
        </template>

        <div class="px-[40px] mt-8">
            <div class="flex items-center justify-between">
                <div class="flex items-center mb-4">
                    <input
                        type="text"
                        v-model="searchQuery"
                        @input="debouncedSearch"
                        placeholder="Search countries..."
                        class="px-4 py-2 border border-gray-300 rounded-md"
                    />
                </div>

                <!-- Button to open the create currency form -->
                <div class="mb-4">
                    <Link
                        :href="route('countries.create')"
                        class="px-4 py-2 text-white bg-blue-500 rounded-md"
                    >
                        Add Country
                    </Link>
                </div>
            </div>

            <div class="overflow-x-auto bg-white rounded-lg shadow-md">
                <table class="min-w-full border border-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th
                                class="px-6 py-3 text-sm font-semibold tracking-wider text-left text-gray-600 uppercase"
                            >
                                Common
                            </th>
                            <th
                                class="px-6 py-3 text-sm font-semibold tracking-wider text-left text-gray-600 uppercase"
                            >
                                Offical
                            </th>
                            <th
                                class="px-6 py-3 text-sm font-semibold tracking-wider text-left text-gray-600 uppercase"
                            >
                                Region
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
                            v-for="country in countries.data"
                            :key="country.id"
                            class="border-b border-gray-100 hover:bg-gray-50"
                        >
                            <td
                                class="px-6 py-4 text-sm font-medium text-gray-900"
                            >
                                {{ country.common }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700">
                                {{ country.offical }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700">
                                {{ country.region }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700">
                                <Link
                                    :href="route('countries.edit', country.id)"
                                    class="px-2 py-1 text-white bg-yellow-500 rounded-md"
                                >
                                    Edit
                                </Link>

                                <button
                                    @click="deleteCountry(country.id)"
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
                    Showing {{ countries.from }} to {{ countries.to }} of
                    {{ countries.total }} currencies
                </div>
                <div class="flex space-x-1">
                    <template
                        v-for="(link, index) in countries.links"
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
import { debounce } from "lodash";

const props = defineProps({
    countries: Object,
});

const searchQuery = ref("");

const search = () => {
    router.get(
        "/countries",
        { search: searchQuery.value },
        { preserveState: true }
    );
};

const debouncedSearch = debounce(search, 500);

const handlePagination = (url) => {
    router.visit(
        url + (searchQuery.value ? `&search=${searchQuery.value}` : ""),
        {
            preserveState: true,
            preserveScroll: true,
        }
    );
};

const deleteCountry = (id) => {
    if (confirm("Are you sure you want to delete this country?")) {
        router.delete(`/countries/${id}`);
    }
};
</script>
