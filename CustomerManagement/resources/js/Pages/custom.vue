<template>
    <div v-if="isOpen" class="modal">
        <div class="modal-content">
            <span class="close" @click="closeModal">&times;</span>
            <h2>User Registration</h2>
            <form @submit.prevent="submit">
                <div>
                    <label for="name">Name:</label>
                    <input type="text" v-model="form.name" required />
                </div>
                <div>
                    <label for="email">Email:</label>
                    <input type="email" v-model="form.email" required />
                </div>
                <div>
                    <label for="password">Password:</label>
                    <input type="password" v-model="form.password" required />
                </div>
                <button type="submit">Register</button>
            </form>
            <div v-if="errors.length">
                <ul>
                    <li v-for="error in errors" :key="error">{{ error }}</li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script>
import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';

export default {
    props: {
        isOpen: Boolean,
        closeModal: Function,
    },
    setup() {
        const form = ref({
            name: '',
            email: '',
            password: '',
        });
        const errors = ref([]);

        const submit = () => {
            Inertia.post('/register', form.value, {
                onSuccess: () => {
                    form.value = { name: '', email: '', password: '' }; // Reset form
                    errors.value = []; // Clear errors
                },
                onError: (error) => {
                    errors.value = error; // Capture errors from the server
                },
            });
        };

        return {
            form,
            errors,
            submit,
        };
    },
};
</script>

<style scoped>
.modal {
    display: block;
    /* Show modal */
    position: fixed;
    z-index: 1;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.5);
}

.modal-content {
    background-color: #fefefe;
    margin: 15% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 300px;
}

.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}
</style>
