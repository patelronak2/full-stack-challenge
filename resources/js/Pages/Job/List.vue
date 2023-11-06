<script setup lang="ts">
import { Head, router, useForm } from '@inertiajs/vue3';
import Layout from "@/Layouts/Layout.vue";
import { PropType, reactive } from "vue";
import { Company, Job } from "@/types";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import Modal from "@/Components/Modal.vue";

defineProps({
    jobs: {
        type: Object as PropType<Job[]>,
        required: true
    },
    companies: {
        type: Object as PropType<Company[]>,
        required: true
    },
});

const form = useForm({
    salary_min: null,
    salary_max: null,
    location: "",
    position_type: "",
    company_id: ""
});

const state = reactive({
    applyingFilters: false,
    loader: false
});

const openModal = () => {
    state.applyingFilters = true;
};

const filterJobs = () => {
    form.location = form.position_type === 'remote' ? "" : form.location;
    form.get(route('jobs.index'));
}

const closeModal = () => {
    state.applyingFilters = false;
    form.reset();
};

const resetFilters = () => {
    form.reset();
    router.get(route('jobs.index'));
}

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

                <div class="flex justify-end">
                    <SecondaryButton
                        @click="resetFilters"
                    >
                        Reset
                    </SecondaryButton>
                    <button
                        @click="openModal"
                        class="inline-flex items-center px-4 py-2 bg-blue-700 border border-blue-300 rounded-md font-semibold text-xs text-white uppercase tracking-widest shadow-sm hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150 ml-2"
                    >
                        Filter Jobs
                    </button>
                </div>

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
                            Salary: {{ job.salary_min }} - {{ job.salary_max }} CAD
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

        <!-- Filters Modal -->
        <Modal :show="state.applyingFilters" @close="closeModal">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900">
                    Filter Jobs
                </h2>

                <div class="mt-6 space-y-6">

                    <div class="flex flex-row">
                        <div class="md:basis-1/2 sm:basis-1 md:pr-2">
                            <InputLabel for="salary_min" value="Minimum Salary" />

                            <input
                                id="salary_min"
                                type="number"
                                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                v-model="form.salary_min"
                                placeholder="100000"
                                autocomplete="salary"
                            />

                            <InputError class="mt-2" :message="form.errors.salary_min" />
                        </div>
                        <div class="md:basis-1/2 sm:basis-1 md:pl-2">
                            <InputLabel for="salary_max" value="Maximum Salary" />

                            <input
                                id="salary_max"
                                type="number"
                                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                                v-model="form.salary_max"
                                placeholder="110000"
                                autocomplete="salary_max"
                            />

                            <InputError class="mt-2" :message="form.errors.salary_max" />
                        </div>
                    </div>

                    <div>
                        <InputLabel for="company_id" value="Company" />

                        <select
                            id="company_id"
                            class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                            v-model="form.company_id"
                        >
                            <option
                                v-for="company in companies"
                                :value="company.id"
                            >
                                {{ company.name }}
                            </option>
                        </select>

                        <InputError class="mt-2" :message="form.errors.company_id" />
                    </div>

                    <div>
                        <InputLabel for="position_type" value="Position Type" />

                        <select

                            id="position_type"
                            class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                            v-model="form.position_type"
                        >
                            <option value="remote">Remote</option>
                            <option value="in-person">In Person</option>
                        </select>

                        <InputError class="mt-2" :message="form.errors.position_type" />
                    </div>

                    <div v-if="form.position_type !== 'remote'">
                        <InputLabel for="location" value="Location" />

                        <TextInput
                            id="location"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.location"
                            placeholder="Toronto"
                            autocomplete="location"
                        />

                        <InputError class="mt-2" :message="form.errors.location" />
                    </div>

                    <div class="mt-6 flex justify-end">
                        <SecondaryButton @click="closeModal"> Cancel </SecondaryButton>

                        <PrimaryButton
                            class="ml-3"
                            :class="{ 'opacity-25': form.processing }"
                            :disabled="form.processing"
                            @click="filterJobs"
                        >
                            Apply Filter
                        </PrimaryButton>
                    </div>
                </div>
            </div>
        </Modal>
    </Layout>
</template>
