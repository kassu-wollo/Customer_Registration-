<template>
    <Layout>
        <div class="min-h-screen flex items-center justify-center bg-gray-100">
            <div class="w-full max-w-md bg-white rounded-lg shadow-md p-6">
                <h2 class="text-2xl font-semibold text-center text-gray-800 mb-6">Customer Registration</h2>
                <form @submit.prevent="handleSubmit">
                    <!-- Name -->
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Full Name</label>
                        <input type="text" id="name" v-model="form.name"
                            class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            placeholder="John Doe" required />
                    </div>
                    <!-- Email -->
                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                        <input type="email" id="email" v-model="form.email"
                            class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            placeholder="example@domain.com" required />
                    </div>
                    <!-- Password -->
                    <div class="mb-4">
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                        <input type="password" id="password" v-model="form.password"
                            class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            placeholder="********" required />
                    </div>
                    <!-- Confirm Password -->
                    <div class="mb-6">
                        <label for="confirmPassword" class="block text-sm font-medium text-gray-700 mb-2">Confirm
                            Password</label>
                        <input type="password" id="confirmPassword" v-model="form.confirmPassword"
                            class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                            placeholder="********" required />
                    </div>
                    <!-- Submit Button -->
                    <button type="submit"
                        class="w-full bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2">
                        Register
                    </button>
                </form>
            </div>
        </div>
    </Layout>
</template>
<script setup>
import { reactive } from 'vue';
import { router } from '@inertiajs/vue3';
import Layout from './Layout.vue';
const form = reactive({
    name: '',
    email: '',
    password: '',
    confirmPassword: '',
});
const handleSubmit = () => {
    if (form.password !== form.confirmPassword) {
        alert("Passwords don't match!");
        return;
    }
    const formdata = {
        name: form.name,
        email: form.email,
        password: form.password
    };
    console.log(formdata);
    router.post('/register-user', formdata);
};
</script>

<style>
/* Optional: TailwindCSS already provides all necessary styles */
</style>
