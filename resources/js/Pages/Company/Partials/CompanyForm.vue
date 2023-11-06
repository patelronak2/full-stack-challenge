<script setup lang="ts">
import InputLabel from "@/Components/InputLabel.vue";
import { useForm } from "@inertiajs/vue3";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { PropType } from "vue";
import { Company } from "@/types";

const props = defineProps({
    company: {
        type: Object as PropType<Company>,
        required: false
    }
});

const form = useForm({
    name: props.company?.name ?? "",
    description: props.company?.description ?? "",
});

const editCompany = () => {
    form.patch(route('companies.update', props.company?.id));
}

const createCompany = () => {
    form.post(route('companies.store'));
};

</script>

<template>
    <section>
        <form @submit.prevent="props.company?.id ? editCompany() : createCompany()" class="mt-6 space-y-6">
            <div>
                <InputLabel for="name" value="Title" />

                <TextInput
                    id="name"
                    type="text"
                    class="mt-1 block w-full"
                    required
                    v-model="form.name"
                    autofocus
                    placeholder="Job Title"
                    autocomplete="name"
                />

                <InputError class="mt-2" :message="form.errors.name" />
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
