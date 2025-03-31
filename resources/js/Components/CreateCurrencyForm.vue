<template>
    <div
        v-if="show"
        class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50"
    >
        <div class="p-6 bg-white rounded-md w-96">
            <h3 class="mb-4 text-lg font-semibold">Add New Currency</h3>
            <form @submit.prevent="submitForm">
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
                    <p v-if="errors?.code" class="mt-1 text-sm text-red-600">
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
                        type="number"
                        step="0.01"
                        class="block w-full px-4 py-2 mt-1 border border-gray-300 rounded-md"
                    />
                    <p v-if="errors?.rate" class="mt-1 text-sm text-red-600">
                        {{ errors.rate }}
                    </p>
                </div>
                <div class="flex justify-between">
                    <button
                        type="button"
                        @click="handleClose()"
                        class="px-4 py-2 text-gray-800 bg-gray-300 rounded-md"
                    >
                        Cancel
                    </button>
                    <button
                        type="submit"
                        class="px-4 py-2 text-white bg-blue-500 rounded-md"
                        :disabled="loading"
                    >
                        {{ loading ? "Saving..." : "Save" }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<script setup>
import { ref } from "vue";
import { router } from "@inertiajs/vue3";

const props = defineProps({
    show: Boolean,
    errors: Object,
});

const emit = defineEmits(["close", "success"]);

const form = ref({ code: "", rate: "" });
const loading = ref(false);

function handleClose() {
    emit("close");
}

const submitForm = async () => {
    loading.value = true;
    try {
        await router.post("/currencies", form.value, {
            preserveScroll: true,
            onSuccess: () => {
                form.value = { code: "", rate: "" };
                emit("success");
                emit("close");
            },
            onError: (errors) => {
                // Errors will be handled by the passed-in errors prop
            },
        });
    } finally {
        loading.value = false;
    }
};
</script>

<style scoped></style>
