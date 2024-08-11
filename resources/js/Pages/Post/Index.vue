<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import MagnifyingGlass from "@/Components/icons/MagnifyingGlass.vue";
import Pagination from "@/Components/Pagination.vue";
import { Head, Link, router, usePage } from "@inertiajs/vue3";
import { ref, computed, watch } from "vue";

defineProps({
    posts: {
        type: Object,
    },
    search: {
        type: String,
    }
});
//capture the user`s search value
const search = ref(usePage().props.search),
    pageNumber = ref(1);
let postsUrl = computed(() => {
    //build the current url
    let url = new URL(route('posts'));
    /**
     * reseating the page number to view the
     *  returned search data
     */
    url.searchParams.append("page", pageNumber.value);
    //append the user search as a param to the url
    if (search.value) {
        url.searchParams.append("search", search.value);
    }
    return url;
});
//keep track of the changes in the url
watch(
    () => postsUrl.value,
    //capture and visit the new url on change
    (updatedUrl) => {
        router.visit(updatedUrl, {
            preserveScroll: true,
            preserveState: true,
            replace: true
        })
    });
//when the user searches we return the results from the first page
watch(() => search,
    (value) => {
        if (value) {
            pageNumber.value = 1
        }
    }
)
const updatedPageNumber = (link) => {
    pageNumber.value = link.url.split("=")[1]
}
const clearFilters = () => {
    search.value = ''
}
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
                    <h1 class="text-2xl font-bold">All Posts:</h1>
                    <div class="container mx-auto my-3">
                        <div class="flex flex-col justify-start sm:flex-row">
                            <div class="relative col-span-3 text-sm text-gray-800">
                                <div
                                    class="absolute top-0 bottom-0 left-0 flex items-center pl-2 text-gray-500 pointer-events-none">
                                    <MagnifyingGlass />
                                </div>

                                <input type="text" v-model="search" placeholder="Search for posts..." id="search"
                                    class="block py-2 pl-10 text-gray-900 border-0 rounded-lg w-[25rem] ring-1 ring-inset ring-gray-200 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
                            </div>

                            <button @click="clearFilters" class="mx-3 text-sm text-gray-700">
                                clear all
                            </button>
                        </div>
                    </div>
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
                        <Pagination :data="posts" :updatedPageNumber="updatedPageNumber" />
                    </ul>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
