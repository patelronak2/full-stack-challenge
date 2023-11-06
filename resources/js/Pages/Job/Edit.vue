<script setup lang="ts">
import { Head } from "@inertiajs/vue3";
import Layout from "@/Layouts/Layout.vue";
import JobForm from "@/Pages/Job/Partials/JobForm.vue";
import { PropType } from "vue";
import { Company, Job } from "@/types";

defineProps({
    companies: {
        type: Object as PropType<Company[]>,
        required: true
    },
    job: {
        type: Object as PropType<Job>,
        required: true
    }
})
</script>

<template>
    <Head title="Edit Job"/>
    <Layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Job (#{{ job.id }})</h2>
        </template>

        <div class="pb-12 pt-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <JobForm :companies="companies" :job="job"/>
                </div>
            </div>
        </div>
    </Layout>
</template>
