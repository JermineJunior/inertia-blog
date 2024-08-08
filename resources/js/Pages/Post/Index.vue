<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link } from "@inertiajs/vue3";

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

                <Link class="cu-btn" :href="route('posts.create')">
                Create a Post
                </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden">
                    <ul class="container mx-auto my-4">
                        <div v-for="post in posts.data" :key="post.id" id="docs-card-content"
                            class="flex items-start gap-6 p-4 my-3 bg-white rounded-lg shadow lg:flex-col">
                            <div
                                class="flex items-center justify-center rounded-full size-12 shrink-0 bg-indigo-500/10 sm:size-16">
                                <svg class="size-5 sm:size-6 fill-indigo-500" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24">
                                    <g>
                                        <path
                                            d="M8.75 4.5H5.5c-.69 0-1.25.56-1.25 1.25v4.75c0 .69.56 1.25 1.25 1.25h3.25c.69 0 1.25-.56 1.25-1.25V5.75c0-.69-.56-1.25-1.25-1.25Z" />
                                        <path
                                            d="M24 10a3 3 0 0 0-3-3h-2V2.5a2 2 0 0 0-2-2H2a2 2 0 0 0-2 2V20a3.5 3.5 0 0 0 3.5 3.5h17A3.5 3.5 0 0 0 24 20V10ZM3.5 21.5A1.5 1.5 0 0 1 2 20V3a.5.5 0 0 1 .5-.5h14a.5.5 0 0 1 .5.5v17c0 .295.037.588.11.874a.5.5 0 0 1-.484.625L3.5 21.5ZM22 20a1.5 1.5 0 1 1-3 0V9.5a.5.5 0 0 1 .5-.5H21a1 1 0 0 1 1 1v10Z" />
                                        <path
                                            d="M12.751 6.047h2a.75.75 0 0 1 .75.75v.5a.75.75 0 0 1-.75.75h-2A.75.75 0 0 1 12 7.3v-.5a.75.75 0 0 1 .751-.753ZM12.751 10.047h2a.75.75 0 0 1 .75.75v.5a.75.75 0 0 1-.75.75h-2A.75.75 0 0 1 12 11.3v-.5a.75.75 0 0 1 .751-.753ZM4.751 14.047h10a.75.75 0 0 1 .75.75v.5a.75.75 0 0 1-.75.75h-10A.75.75 0 0 1 4 15.3v-.5a.75.75 0 0 1 .751-.753ZM4.75 18.047h7.5a.75.75 0 0 1 .75.75v.5a.75.75 0 0 1-.75.75h-7.5A.75.75 0 0 1 4 19.3v-.5a.75.75 0 0 1 .75-.753Z" />
                                    </g>
                                </svg>
                            </div>

                            <div class="pt-3 sm:pt-5 lg:pt-0">
                                <Link class="block text-xl font-semibold text-black" :href="post.path">
                                {{ post.title }}
                                </Link>
                                <div class="">
                                    <div>
                                        <small class="italic"> posted by </small>
                                        <span class="text-lg font-bold">
                                            {{ post.user }}
                                        </span>
                                    </div>
                                    <small>Posted: {{ post.created_at }}</small>
                                </div>
                                <p class="mt-4 text-sm/relaxed">
                                    {{ post.body }}
                                </p>
                            </div>
                        </div>
                    </ul>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
