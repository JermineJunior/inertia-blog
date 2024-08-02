<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";

defineProps({
    posts: {
        type: Array,
    },
});
</script>

<template>
    <Head title="Posts" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Posts
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <ul class="container mx-auto my-4">
                        <li
                            class="px-4 py-2"
                            v-for="post in posts"
                            :key="post.id"
                        >
                            <a href="#" class="font-bold text-xl">
                                {{ post.title }}
                            </a>
                            <small> posted by </small>
                            <p>{{ post.body }}</p>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
