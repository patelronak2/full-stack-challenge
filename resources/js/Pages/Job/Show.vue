<script setup lang="ts">
import { Head, router } from "@inertiajs/vue3";
import Layout from "@/Layouts/Layout.vue";
import { Job } from "@/types";

defineProps({
    job: {
        type: Object as () => Job,
        required: true
    }
});
</script>

<template>
    <Head title="Jobs"/>

    <Layout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ job.title }} (#{{ job.id }})</h2>
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
    </Layout>
</template>
