<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';

const translations = ref([]);

const getTranslations = async () => {
    try {
        const response = await axios.get('/api/translations');
        translations.value = response.data.data;
    } catch (error) {
        console.error('Failed to fetch translations:', error);
    }
};

// 'onMounted' runs when the component is first loaded.
onMounted(() => {
    // 1. Fetch the data immediately when the page loads.
    getTranslations();

    // 2. Then, set a timer to call getTranslations again every 5 seconds.
    setInterval(getTranslations, 5000); // 5000 milliseconds = 5 seconds
});
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Translation History</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">

                        <div v-if="translations.length === 0">
                            You don't have any saved translations yet. Use Postman to add some!
                        </div>

                        <ul v-else class="space-y-4">
                            <li v-for="translation in translations" :key="translation.id" class="border-b pb-2">
                                <p class="text-lg font-medium">{{ translation.translated_text }}</p>
                                <span class="text-sm text-gray-500">
                                    Received on: {{ new Date(translation.created_at).toLocaleString() }}
                                </span>
                            </li>
                        </ul>

                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
