<script setup lang="ts">
import { Head, router } from "@inertiajs/vue3";
import Layout from "@/Layouts/Layout.vue";
import { Job } from "@/types";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import DangerButton from "@/Components/DangerButton.vue";
import { reactive } from "vue";
import Modal from "@/Components/Modal.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";

const props = defineProps({
    job: {
        type: Object as () => Job,
        required: true
    }
});

const state = reactive({
    loader: false,
    confirmingJobDeletion: false,
})

const openModal = () => {
    state.confirmingJobDeletion = true;
};

const closeModal = () => {
    state.confirmingJobDeletion = false;
};

const deleteJob = () => {
    state.loader = true;
    router.delete(route('jobs.destroy', props.job.id), {
        onFinish: () => {
            state.loader = false;
            state.confirmingJobDeletion = false;
        }
    });
};

</script>

<template>
    <Head title="Job"/>

    <Layout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ job.title }} (#{{ job.id }})</h2>
                <div v-if="$page.props.auth.user">
                    <PrimaryButton
                        class="mr-2"
                        @click="router.get(route('jobs.edit', job.id))"
                    >
                        Edit
                    </PrimaryButton>
                    <DangerButton @click="openModal">
                        Delete
                    </DangerButton>
                </div>
            </div>

        </template>

        <div class="pb-12 pt-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-4">
                    <div class="p-6">
                        <h2 class="text-lg font-medium text-gray-900 mt-2">
                            Company: {{ job.company.name }}
                        </h2>
                        <p class="mt-1 text-md text-gray-600">
                            {{ job.company.description }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                      <span
                          :class="job.position_type === 'remote' ? 'bg-blue-100 text-blue-800': 'bg-gray-100 text-gray-800'"
                          class="text-sm font-medium px-2 py-0.5 rounded"
                      >
                        {{ job.position_type }}
                      </span>
                        <h2 class="text-lg font-medium text-gray-900 mt-2">Job Description</h2>
                        <p class="mt-1 text-md text-gray-600">
                            {{ job.description }}
                        </p>
                        <h2 class="text-lg font-medium text-gray-900 mt-2">Salary Range</h2>
                        <p class="mt-1 text-md text-gray-600">
                            {{ job.salary_min/100 }} - {{ job.salary_max/100 }} CAD
                        </p>
                        <h2 class="text-lg font-medium text-gray-900 mt-2">Job Location</h2>
                        <p
                            class="mt-1 text-md text-gray-600"
                            v-if="job.location"
                        >
                            {{ job.location }}
                        </p>
                        <p class="mt-1 text-sm italic text-gray-600">Published at: {{ job.created_at }}</p>
                    </div>
                </div>
            </div>
        </div>

        <Modal :show="state.confirmingJobDeletion" @close="closeModal">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900">
                    Are you sure you want to delete Job: {{ job.title }}?
                </h2>

                <p class="mt-1 text-sm text-gray-600">
                    Once a Job is deleted, all of its data will be permanently deleted. Please
                    confirm that you would like to permanently delete this Job.
                </p>

                <div class="mt-6 flex justify-end">
                    <SecondaryButton @click="closeModal"> Cancel </SecondaryButton>

                    <DangerButton
                        class="ml-3"
                        :class="{ 'opacity-25': state.loader }"
                        :disabled="state.loader"
                        @click="deleteJob"
                    >
                        Confirm Deletion
                    </DangerButton>
                </div>
            </div>
        </Modal>

    </Layout>
</template>
