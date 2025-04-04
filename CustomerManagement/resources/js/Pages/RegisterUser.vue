<template>
    <Layout>
        <PrimaryButton @click="openModal" class="btn btn-primary">
            Open Registration Form
        </PrimaryButton>
        <!-- Modal -->
        <div v-if="isModalOpen" class="modal-overlay">
            <div class="modal">
                <form @submit.prevent="create">
                    <div class="flex flex-col mx-auto md:w-96 w-full">
                        <h1 class="text-2xl font-bold mb-4 text-center">User Register</h1>
                        <div class="flex flex-col gap-2 mb-4">
                            <label for="name" class="required">Name</label>
                            <input id="name" v-model="form.name" type="text" class="form-input" autocomplete="name" />
                            <span v-if="errors && errors.name" class="error">{{ errors.name[0] }}</span>
                        </div>
                        <div class="flex flex-col gap-2 mb-4">
                            <label for="phone" class="required">Phone</label>
                            <input id="phone" type="number" v-model="form.phone" class="form-input" autocomplete="phone"
                                required />
                            <span v-if="errors && errors.phone" class="error">{{ errors.phone[0] }}</span>

                        </div>
                        <div class="flex flex-col gap-2 mb-4">
                            <label for="bdate" class="required">Birth Date</label>
                            <input id="bdate" type="date" v-model="form.bdate" class="form-input" required />
                            <span v-if="errors && errors.bdate" class="error">{{ errors.bdate[0] }}</span>

                        </div>
                        <div class="flex flex-col gap-2 mb-4">
                            <label for="email" class="required">Email</label>
                            <input id="email" type="email" v-model="form.email" class="form-input" autocomplete="email"
                                required />
                            <span v-if="errors && errors.email" class="error">{{ errors.email[0] }}</span>

                        </div>

                        <div class="flex justify-between gap-2">
                            <PrimaryButton type="submit" class="btn btn-primary">Register</PrimaryButton>
                            <PrimaryButton type="button" @click="closeModal" class="btn btn-secondary">Cancel
                            </PrimaryButton>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </Layout>
</template>
<script>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import Layout from './Layout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { router } from '@inertiajs/vue3';
export default {
    components: { Layout, PrimaryButton },
    setup(props) {
        const isModalOpen = ref(false);
        const form = useForm({
            name: '',
            phone: '',
            bdate: '',
            email: '',
        });
        const openModal = () => {
            isModalOpen.value = true;
        };
        const closeModal = () => {
            isModalOpen.value = false;
            form.reset();
        };
        const create = () => {
            const formData = {
                name: form.name,
                phone: form.phone,
                bdate: form.bdate,
                email: form.email,
                remember: form.remember,
            };
            //Submit form data
            router.post('custreg', formData, {
                onSuccess: () => { alert('User registered successfully!'); },
                onError: (errors) => { console.error('Error registering user:', errors); },
            });
            form.reset();
            console.log(formData);
        };
        return { form, isModalOpen, openModal, closeModal, create, errors: props.errors };
    },
}
</script>
<style>
.error {
    color: red;
    font-size: 0.875em;
}
</style>
