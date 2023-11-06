<script setup lang="ts">
import { Head, router } from '@inertiajs/vue3';
import Layout from "@/Layouts/Layout.vue";
import { PropType } from "vue";
import { Job } from "@/types";
import PrimaryButton from "@/Components/PrimaryButton.vue";

defineProps({
    jobs: {
        type: Object as PropType<Job[]>,
        required: true
    }
});

const redirectToCreate = () => {
    router.get(route('jobs.create'));
}

</script>

<template>
    <Head title="Jobs List"/>

    <Layout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Jobs</h2>
                <div v-if="$page.props.auth.user">
                    <PrimaryButton @click="redirectToCreate">
                        Create New Job
                    </PrimaryButton>
                </div>
            </div>
        </template>

        <div class="pb-12 pt-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                <a
                    v-for="job in jobs"
                    :href="route('jobs.show', job.id)"
                    :key="job.id"
                    class="mt-6 scale-100 p-6 bg-white from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none flex justify-between motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500"
                >
                    <div>
            <span
                :class="job.position_type === 'remote' ? 'bg-blue-100 text-blue-800': 'bg-gray-100 text-gray-800'"
                class="text-sm font-medium px-2 py-0.5 rounded"
            >
              {{ job.position_type }}
            </span>
                        <h2 class="text-lg font-medium text-gray-900 mt-2">{{ job.title }}</h2>
                        <p class="mt-1 text-sm font-medium italic text-gray-900">{{ job.company.name }}</p>
                        <p
                            class="mt-1 text-sm font-medium italic text-gray-900"
                            v-if="job.location"
                        >
                            Location: {{ job.location }}
                        </p>
                        <p class="mt-1 text-sm text-gray-600">
                            {{ job.description.slice(0, 200) }} ...view more
                        </p>
                        <p class="mt-1 text-sm text-gray-600">
                            Salary: {{ job.salary_min/100 }} - {{ job.salary_max/100 }} CAD
                        </p>
                        <p class="mt-1 text-sm italic text-gray-600">Published at: {{ job.created_at }}</p>
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
                    class="p-6 bg-white rounded py-4 mt-6"
                    v-if="!jobs.length"
                >
                    No Jobs to display
                </div>

            </div>
        </div>
    </Layout>
</template>
