<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import Layout from "@/Layouts/Layout.vue";
import { PropType } from "vue";
import { Company } from "@/types";

defineProps({
    companies: {
        type: Object as PropType<Company[]>,
        required: true
    }
});
</script>

<template>
    <Head title="Companies" />

    <Layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Companies</h2>
        </template>

        <div class="pb-12 pt-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <a
                    v-for="company in companies"
                    :href="route('companies.show', company.id)"
                    :key="company.id"
                    class="mt-6 scale-100 p-6 bg-white from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none flex justify-between motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500"
                >
                    <div>
                        <h2 class="text-lg font-medium text-gray-900">{{ company.name }}</h2>
                        <p class="mt-1 text-sm text-gray-600">
                            {{ company.description.slice(0, 200) }} ...view more
                        </p>
                        <p class="mt-1 text-sm italic text-gray-600">Published Job Count: {{ company.jobs_count }}</p>
                    </div>

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        class="self-center shrink-0 stroke-red-500 w-6 h-6 mx-6"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75"
                        />
                    </svg>
                </a>

                <div
                    class="p-6 bg-white rounded mt-6"
                    v-if="!companies.length"
                >
                    No companies to display
                </div>
            </div>
        </div>
    </Layout>
</template>
