<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import Layout from "@/Layouts/Layout.vue";
</script>

<template>
    <Head title="Dashboard" />

    <Layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Companies</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">List of Companies would be displayed here</div>
                </div>
            </div>
        </div>
    </Layout>
</template>
