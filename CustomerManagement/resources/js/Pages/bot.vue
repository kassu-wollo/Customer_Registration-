<template>
    <Layout>
        <div class="header">
            <div class="text-2xl font-bold mb-4 flex space-x-4">
                <PrimaryButton @click="openModal" class="btn btn-primary">
                    የድባቴ፤ ጭንቀትና ውጥረት መለኪያ መጠይቅ
                </PrimaryButton>
                <PrimaryButton @click="Export" class="btn btn-secondary">
                    <i class="fa fa-file-export"></i>መረጃ አውርድ
                </PrimaryButton>
                <PrimaryButton @click="summeryrmodal" class="btn btn-primary">
                    <i class="fa fa-file-export"></i>የተመለሰዉ አጠቃላይ መረጃ እይ
                </PrimaryButton>
            </div>
        </div>
        <!-- Modal -->
        <div v-if="isModalOpen" class="modal-overlay">
            <div class="modal">
                <div class="flex flex-col mx-auto md:w-96 w-full">
                    <div class="flex flex-col gap-2 mb-4">
                        <label for="name" class="required">እራሴን ለማረጋጋት እቸገራለሁ፡፡</label>
                    </div>
                    <div class="flex flex-col gap-2 mb-4">
                        <label for="phone" class="required">አፌ ሲደርቅ ይታወቀኛል፡፡</label>
                    </div>
                    <div class="flex flex-col gap-2 mb-4">
                        <label for="bdate" class="required">ጥሩ ወይም አዎንታዊ ስሜት ፈፅሞ የሚሰማኝ አይመስለኝም</label>

                    </div>
                    <div class="flex flex-col gap-2 mb-4">
                        <label for="email" class="required">ምንም አካላዊ እንቅስቃሴ ሳላደርግ ለመተንፈስ እቸገራለሁ፤ ለምሳሌ ከመጠን በላይ በፍጥነት
                            የመተንፈስ ወይም የትንፋሽ ማጠር ያስቸግረኛል፡፡</label>
                    </div>

                </div>
                <div class="flex justify-between gap-2">
                    <PrimaryButton type="button" @click="closeModal" class="btn btn-secondary">Cancel
                    </PrimaryButton>
                </div>
            </div>
        </div>
        <div v-if="sModalOpen" class="modal-overlay">
            <div class="modal">
                <div>
                    <h1 align='center' class="text-xl font-bold mb-4">ጥያቂ እና መልስ ማጠቃለያ ሰንጠረዥ</h1>
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
                    <div>
                        <div class="flex justify-between gap-2">
                            <PrimaryButton type="button" @click="scloseModal" class="btn btn-secondary">Close
                            </PrimaryButton>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- User Data Table -->
        <div class="datatable1">
            <div class="mdl-data-table-container">
                <DataTable class="data-table">
                    <thead>
                        <tr>
                            <th>የመላሹ ስም</th>
                            <th>የመላሹ መለያ ቁጥር</th>
                            <th>የተጠየቁ ጥያቄዎችዎች</th>
                            <th>የተሰጠው መልስ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="data in posts" :key="data.id">
                            <td>{{ data.name }}</td>
                            <td>{{ data.user_id }}</td>
                            <td>{{ data.question }}</td>
                            <td>{{ data.response }}</td>
                        </tr>
                    </tbody>
                </DataTable>
            </div>
        </div>
    </Layout>
</template>
<script>
import { ref, reactive, watch } from "vue";
import { router, useForm } from "@inertiajs/vue3";
import Layout from "./Layout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { Inertia } from "@inertiajs/inertia";
import { error } from "jquery";
import Dropdown from "@/Components/Dropdown.vue";
export default {
    components: { Layout, PrimaryButton, Dropdown },
    props: { posts: Array, groupedResponses: Object, total: Number },

    setup() {
        const isModalOpen = ref(false);
        const sModalOpen = ref(false)
        const summeryrmodal = () => {
            sModalOpen.value = true;
        }
        const scloseModal = () => {
            sModalOpen.value = false;
        }
        const openModal = () => {
            isModalOpen.value = true;
        };
        const closeModal = () => {
            isModalOpen.value = false;
        };
        return {
            openModal,
            closeModal,
            isModalOpen,
            summeryrmodal,
            sModalOpen,
            scloseModal

        }
    }
}
</script>
<style scoped>
.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 50;
    width: auto;
    height: auto;
}

.modal {
    background: white;
    padding: 1.5rem;
    border-radius: 8px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    width: 100%;
    max-width: auto;
    max-height: 500px;
    z-index: 100;
}

.btn-secondary {
    background-color: #0fbc0f;
    color: white;
    padding: auto;

}

.btn-primary {
    background-color: #007bff;
    padding: auto;
}

.btn-danger {
    background-color: #dc3545;
}

.error {
    color: red;
    font-size: 0.875em;
}

.header {
    padding-left: 2cm;
    padding-top: 0.5cm;
    background: white;
    justify-content: right;
    border-radius: none;
    width: 100%;
    max-width: auto;
    z-index: 100;
}

.datatable1 {
    padding-left: 2cm;
    padding-right: 2cm;
    max-width: auto;
}

.data-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 10px;
}

.data-table thead {
    background-color: #f4f4f4;
}

.data-table th,
.data-table td {
    padding: 10px 15px;
    text-align: left;
    border: 1px solid #ddd;
}

.data-table th {
    font-weight: bold;
}

.data-table tbody tr:hover {
    background-color: #f9f9f9;
}

table {
    width: 100%;
    border-collapse: collapse;
}

th,
td {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
}

th {
    background-color: #f2f2f2;
}

.sub-column {
    width: 50%;
    /* Adjust width for sub-columns */
}

.header {
    padding-left: 2cm;
    padding-top: 0.5cm;
    background: white;
    justify-content: right;
    border-radius: none;
    width: 100%;
    max-width: auto;
    z-index: 100;
}
</style>
