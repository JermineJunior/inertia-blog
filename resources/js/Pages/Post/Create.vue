<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import NavLink from "@/Components/NavLink.vue";

const form = useForm({
    title: "",
    body: "",
});

const submit = () => {
    form.post(route("posts-create"), {
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
                    Create a Post
                </h2>

                <NavLink :href="route('posts')"> Go Back </NavLink>
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-2xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-bold py-2">
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
                                    class="mt-1 block w-full"
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
                                    class="w-full mt-1 block border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
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
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
