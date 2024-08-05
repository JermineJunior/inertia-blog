<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";
import TextInput from "@/Components/TextInput.vue";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import DangerButton from "@/Components/DangerButton.vue";

const props = defineProps({
    post: {
        type: Object,
    },
});

const form = useForm({
    title: props.post.title,
    body: props.post.body,
});

const submit = () => {
    form.put(`/posts/${props.post.id}`, {
        onFinish: () => form.reset(),
    });
};
</script>

<template>
    <Head title="Posts" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Edit Your Post
                </h2>

                <Link class="cu-btn" :href="post.path"> Go Back </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
                <div class="p-6 overflow-hidden bg-white rounded-lg shadow">
                    <h2 class="py-2 text-xl font-bold">
                        Add a new Post to the feed
                    </h2>
                    <div class="mt-4">
                        <form @submit.prevent="submit">
                            <!-- post title -->
                            <div>
                                <InputLabel for="title" value="Post Title" />

                                <TextInput
                                    id="title"
                                    type="text"
                                    class="block w-full mt-1"
                                    v-model="form.title"
                                    required
                                    placeholder="this is a new title"
                                    autofocus
                                />

                                <InputError
                                    class="mt-2"
                                    :message="form.errors.title"
                                />
                            </div>
                            <!-- post body -->
                            <div class="mt-4">
                                <InputLabel for="body" value="Post Content" />
                                <textarea
                                    v-model="form.body"
                                    placeholder="here is the content of my post"
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    autofocus
                                    required
                                ></textarea>
                                <InputError
                                    class="mt-2"
                                    :message="form.errors.body"
                                />
                            </div>
                            <!-- submit form -->
                            <div class="flex items-center justify-end mt-4">
                                <PrimaryButton
                                    class="ms-4"
                                    :class="{ 'opacity-25': form.processing }"
                                    :disabled="form.processing"
                                >
                                    Save Post
                                </PrimaryButton>
                                <DangerButton class="ml-1">Delete</DangerButton>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
