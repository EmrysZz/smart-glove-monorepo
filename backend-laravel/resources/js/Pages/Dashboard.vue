<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, usePage } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';

// Get the authenticated user from Inertia's page props
const user = usePage().props.auth.user;

const translations = ref([]);

// This function now only fetches the initial list of translations
const getTranslations = async () => {
    try {
        const response = await axios.get('/api/translations');
        translations.value = response.data;
    } catch (error) {
        console.error('Failed to fetch translations:', error);
    }
};

onMounted(() => {
    // 1. Fetch the initial data when the page loads.
    getTranslations();

    // 2. Listen for new translations on the private WebSocket channel.
    window.Echo.private('translations.' + user.id) // <-- This line is now correct
        .listen('TranslationCreated', (e) => {
            // Add the new translation to the top of the list in real-time
            console.log('New Translation Received:', e);
            translations.value.unshift(e);
        });
});
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Translation History (Real-Time)</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">

                        <div v-if="translations.length === 0">
                            Listening for new translations...
                        </div>

                        <ul v-else class="space-y-4">
                            <li v-for="translation in translations" :key="translation.id" class="border-b pb-2 animate-fade-in">
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
