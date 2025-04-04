<template>
    <nav class="bg-gray-800 text-white shadow-md">
        <div class="container mx-auto px-4 py-3 flex items-center justify-between">
            <!-- Logo -->
            <div class="text-2xl font-bold">
                <a href="/">Wollo</a>

            </div>

            <!-- Desktop Menu -->
            <ul class="hidden md:flex space-x-6">
                <li>
                    <Link href="/hello" class="hover:text-teal-400">Register</Link>
                </li>
                <li>
                    <Link href="/user" class="hover:text-teal-400">About</Link>
                </li>
                <li>
                    <Link href="/View" class="hover:text-teal-400">View</Link>
                </li>
                <li>
                    <Link href="/Auth/Login" class="hover:text-teal-400">Login</Link>
                </li>
                <li>
                    <Link href="/chat" class="hover:text-teal-400">BOT</Link>
                </li>
                <li>
                    <Link href="/res" class="hover:text-teal-400">User Response Summer</Link>
                </li>
            </ul>
            <!-- Mobile Menu Toggle -->
            <button class="block md:hidden focus:outline-none text-2xl" @click="toggleMobileMenu">
                ☰
            </button>
        </div>
        <!-- Mobile Menu -->
        <div v-if="mobileMenuOpen" class="md:hidden bg-gray-700">
            <ul class="space-y-4 p-4">
                <li>
                    <Link href="/hello" class="hover:text-teal-400">Register</Link>
                </li>
                <li>
                    <Link href="/user" class="hover:text-teal-400">About</Link>
                </li>
                <li>
                    <Link href="/View" class="hover:text-teal-400">View</Link>
                </li>
                <li>
                    <Link href="/Auth/Login" class="hover:text-teal-400">Login</Link>
                </li>
                <li>
                    <Link href="/chat" class="hover:text-teal-400">BOT</Link>
                </li>
                <li>
                    <Link href="/res" class="hover:text-teal-400">User Response Summer</Link>
                </li>
            </ul>
        </div>
    </nav>

</template>
<script>
import { ref } from 'vue';
import { Link } from '@inertiajs/vue3';
export default {
    components: {
        Link,
    },
    setup() {
        const mobileMenuOpen = ref(false);
        const toggleMobileMenu = () => {
            mobileMenuOpen.value = !mobileMenuOpen.value;
        };

        return {
            mobileMenuOpen,
            toggleMobileMenu,
        };
    },
};
</script>
<style>
/* Optional: Add your custom Tailwind CSS styles here */
</style>
