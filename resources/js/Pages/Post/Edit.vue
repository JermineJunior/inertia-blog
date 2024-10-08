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
        required: true
    },
});

const form = useForm({
    title: props.post.data.title,
    body: props.post.data.body,
});
//update the post
const submit = () => {
    form.put(`/posts/${props.post.data.id}`, {
        onFinish: () => form.reset(),
    });
};
//delete the post
const deleteForm = useForm({});

const deletePost = (id) => {
    if (confirm("Are you sure you want to delete this post?")) {
        deleteForm.delete(route("posts.destroy", id), {
            preserveScroll: true,
        });
    }
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

                <Link class="cu-btn" :href="post.data.path"> Go Back </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
                <div class="p-6 overflow-hidden bg-white rounded-lg shadow">
                    <div class="flex items-center justify-between">
                        <h2 class="py-2 text-xl font-bold">
                            Update the post details
                        </h2>
                        <DangerButton @click="deletePost(post.data.id)">Delete</DangerButton>
                    </div>
                    <div class="mt-4">
                        <form @submit.prevent="submit">
                            <!-- post title -->
                            <div>
                                <InputLabel for="title" value="Post Title" />

                                <TextInput id="title" type="text" class="block w-full mt-1" v-model="form.title" required
                                    placeholder="this is a new title" autofocus />

                                <InputError class="mt-2" :message="form.errors.title" />
                            </div>
                            <!-- post body -->
                            <div class="mt-4">
                                <InputLabel for="body" value="Post Content" />
                                <textarea v-model="form.body" placeholder="here is the content of my post"
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                    autofocus required></textarea>
                                <InputError class="mt-2" :message="form.errors.body" />
                            </div>
                            <!-- submit form -->
                            <div class="flex justify-end">
                                <PrimaryButton class="my-2 m6-3" :class="{ 'opacity-25': form.processing }"
                                    :disabled="form.processing">
                                    Save Post
                                </PrimaryButton>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
