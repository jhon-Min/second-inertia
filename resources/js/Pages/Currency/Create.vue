<template>
    <AuthenticatedLayout>
        <div class="px-[100px] mt-8 w-10/12">
            <h3 class="mb-4 text-lg font-semibold">Add New Currency</h3>
            <form @submit.prevent="submit">
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
import { ref, reactive } from "vue";
import { Link, useForm } from "@inertiajs/vue3";

defineProps({ errors: Object });

const form = useForm({
    code: "",
    rate: null,
});

async function submit() {
    await form.post("/currencies", {
        preserveScroll: true,
        onSuccess: () => form.reset("password"),
    });
}
</script>

<style lang="scss" scoped></style>
