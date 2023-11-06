<script setup lang="ts">
import InputLabel from "@/Components/InputLabel.vue";
import { useForm } from "@inertiajs/vue3";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { PropType } from "vue";
import { Company, Job } from "@/types";

const props = defineProps({
    companies: {
        type: Object as PropType<Company[]>,
        required: true
    },
    job: {
        type: Object as PropType<Job>,
        required: false
    }
});

const form = useForm({
    title: props.job?.title ?? "",
    description: props.job?.description ?? "",
    salary_min: props.job ? props.job.salary_min / 100 : null,
    salary_max: props.job ? props.job.salary_max / 100 : null,
    location: props.job?.location ?? "",
    position_type: props.job?.position_type ?? "in-person",
    company_id: props.job?.company_id ?? ""
});

const createJob = () => {
    form.post(route('jobs.store'));
};

const editJob = () => {
    form.patch(route('jobs.update', props.job?.id));
}
</script>

<template>
    <section>
        <form @submit.prevent="props.job?.id ? editJob() : createJob()" class="mt-6 space-y-6">
            <div>
                <InputLabel for="title" value="Title" />

                <TextInput
                    id="title"
                    type="text"
                    class="mt-1 block w-full"
                    required
                    v-model="form.title"
                    autofocus
                    placeholder="Job Title"
                    autocomplete="title"
                />

                <InputError class="mt-2" :message="form.errors.title" />
            </div>

            <div>
                <InputLabel for="description" value="Description" />

                <textarea
                    id="description"
                    rows="4"
                    class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                    v-model="form.description"
                    required
                    placeholder="Enter Job description here..."
                    autocomplete="description"
                />

                <InputError class="mt-2" :message="form.errors.description" />
            </div>

            <div class="flex flex-row">
                <div class="md:basis-1/2 sm:basis-1 md:pr-2">
                    <InputLabel for="salary_min" value="Minimum Salary" />

                    <input
                        id="salary_min"
                        type="number"
                        class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                        v-model="form.salary_min"
                        required
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
                        required
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
                    required
                    placeholder="Toronto"
                    autocomplete="location"
                />

                <InputError class="mt-2" :message="form.errors.location" />
            </div>

            <div class="flex items-center gap-4">
                <PrimaryButton :disabled="form.processing">Save</PrimaryButton>

                <Transition
                    enter-active-class="transition ease-in-out"
                    enter-from-class="opacity-0"
                    leave-active-class="transition ease-in-out"
                    leave-to-class="opacity-0"
                >
                    <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">Saved.</p>
                </Transition>
            </div>
        </form>
    </section>
</template>
