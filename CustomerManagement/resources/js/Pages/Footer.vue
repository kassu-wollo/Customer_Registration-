<template>
    <Layout>
        <footer class="bg-gray-800 text-gray-300">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                <div class="flex flex-wrap justify-between items-center">
                    <!-- Logo or Brand Name -->
                    <div class="text-lg font-bold text-white">
                        <a href="/">MyApp</a>
                    </div>
                    <!-- Links -->
                    <div class="flex space-x-4 mt-4 md:mt-0">
                        <a href="/about" class="hover:text-white text-sm">
                            About
                        </a>
                        <a href="/contact" class="hover:text-white text-sm">
                            Contact
                        </a>
                        <a href="/privacy" class="hover:text-white text-sm">
                            Privacy Policy
                        </a>
                        <a href="/terms" class="hover:text-white text-sm">
                            Terms of Service
                        </a>
                    </div>
                </div>

                <!-- Separator -->
                <div class="border-t border-gray-700 my-4"></div>

                <!-- Copyright -->
                <div class="text-center text-sm">
                    &copy; {{ new Date().getFullYear() }} MyApp. All rights reserved.
                </div>
            </div>
        </footer>
    </Layout>
</template>
<script>
import Layout from './Layout.vue';
export default {

    methods: {
        currentYear() {
            return new Date().getFullYear();
        },
    },
};
</script>
