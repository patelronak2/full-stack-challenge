<script setup lang="ts">
import { Head } from "@inertiajs/vue3";
import Layout from "@/Layouts/Layout.vue";
import { Company } from "@/types";
import { PropType } from "vue";

defineProps({
    company: {
        type: Object as PropType<Company>,
        required: true
    }
});
</script>

<template>
    <Head title="Jobs"/>

    <Layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ company.name }} (#{{ company.id }})</h2>
        </template>

        <div class="pb-12 pt-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h2 class="text-lg font-medium text-gray-900 mt-2">
                            Company Description
                        </h2>
                        <p class="mt-1 text-md text-gray-600">
                            {{ company.description }}
                        </p>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-6">
                    <div class="p-6 text-gray-900">
                        <h2 class="text-lg font-medium text-gray-900 mt-2">
                            Published Jobs
                        </h2>

                        <div class="relative overflow-x-auto border sm:rounded-lg mt-2">
                            <table class="w-full text-sm text-left text-gray-500">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b">
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        Job Title
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Position Type
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Salary Range
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Location
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        <span class="sr-only">View</span>
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr
                                    class="bg-white border-b hover:bg-gray-50"
                                    v-for="job in company.jobs"
                                    :key="job.id"
                                >
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                        {{ job.title }}
                                    </th>
                                    <td class="px-6 py-4">
                                        {{ job.position_type }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ job.salary_min / 100 }} - {{ job.salary_max / 100 }} CAD
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ job.location ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <a :href="route('jobs.show', job.id)"
                                           class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Manage</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td
                                        v-if="!company.jobs?.length"
                                        colspan="5"
                                        class="py-4 text-center"
                                    >
                                        No Published Jobs
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </Layout>
</template>
