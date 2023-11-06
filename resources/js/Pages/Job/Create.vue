<script setup lang="ts">
import { Head } from "@inertiajs/vue3";
import Layout from "@/Layouts/Layout.vue";
import { PropType } from "vue";
import { Company } from "@/types";
import JobForm from "@/Pages/Job/Partials/JobForm.vue";

defineProps({
    companies: {
        type: Object as PropType<Company[]>,
        required: true
    }
})
</script>

<template>
    <Head title="Create Job"/>
    <Layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Create a Job</h2>
        </template>

        <div class="pb-12 pt-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <JobForm :companies="companies" />
                </div>
            </div>
        </div>
    </Layout>
</template>
