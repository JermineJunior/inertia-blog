<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import NavLink from "@/Components/NavLink.vue";

defineProps({
    posts: {
        type: Object,
    },
});
</script>

<template>
    <Head title="Posts" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Posts
                </h2>

                <NavLink :href="route('posts.create')"> Create a Post </NavLink>
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden">
                    <ul class="container mx-auto my-4">
                        <li class="px-4 py-2 bg-white shadow-sm sm:rounded-lg my-4 mx-3" v-for="post in posts"
                            :key="post.id">
                            <a href="#" class="font-bold text-xl">
                                {{ post.title }}
                            </a>
                            <small> posted by <span class="font-bold text-lg"> {{ post.user }} </span></small>
                            <p>{{ post.body }}</p>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
