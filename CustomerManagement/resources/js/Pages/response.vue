<template>
    <Layout>
        <div>
            <h1 align='center' class="text-xl font-bold mb-4">ጥያቂ እናና መልስ ማጠቃለያ ሰንጠረዥ</h1>
            <table class="table-auto border-collapse border border-gray-400 w-full text-left">
                <thead>
                    <tr>
                        <th class="border border-gray-300 px-4 py-2" rowspan="2">የተጠየቁ ጥያቂዎች</th>
                        <th class="border border-gray-300 px-4 py-2" colspan="4">የመለሰው የስዉ ብዛት ለያንዳንዱ ጥያቄ</th>
                        <!-- Main Response Header -->
                    </tr>
                    <tr>
                        <th class="border border-gray-300 px-4 py-2">ፍፁም እኔን አይገልፀኝም</th>
                        <th class="border border-gray-300 px-4 py-2">በተወሰነ ደረጃ ወይም አንዳንዴ ይገልፀኛል</th>
                        <th class="border border-gray-300 px-4 py-2">በደንብ አድርጎ ወይም ብዙ ጊዜ ይገልፀኛል</th>
                        <th class="border border-gray-300 px-4 py-2">በከፍተኛ ደረጃ ወይም ሁል ጊዜ ይገልፀኛል</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(counts, question) in groupedResponses" :key="question">
                        <td class="border border-gray-300 px-4 py-2">{{ question }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ counts['0'] || 0 }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ counts['1'] || 0 }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ counts['2'] || 0 }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ counts['3'] || 0 }}</td>
                    </tr>
                </tbody>

            </table>
            <div class="mt-4">
                <p class="text-lg font-semibold">አጠቃላይ የሞሉ ሰዎች: {{ total }}</p>
            </div>
        </div>
    </Layout>
</template>
<script>
import Layout from './Layout.vue';

export default {
    components: { Layout },
    props: {
        groupedResponses: {
            type: Object,
            required: true,
        },
        total: {
            type: Number,
            required: true,
        },
    },
};
</script>

<style scoped>
/* Optional Styling */
table {
    width: auto;
    margin-top: 20px;
    border-spacing: 0;
    border-collapse: collapse;
    margin-left: 50px;
}

th,
td {
    text-align: left;
    padding: 8px;
}

thead {
    background-color: #f9fafb;
    font-weight: bold;
}
</style>
