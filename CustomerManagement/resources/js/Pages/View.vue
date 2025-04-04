<template>
    <Layout>
        <!-- Action Buttons -->
        <div class="header">
            <div class="text-2xl font-bold mb-4 flex space-x-4">
                <PrimaryButton @click="openModal" class="btn btn-primary">
                    <i class="fa fa-plus"></i> Register User
                </PrimaryButton>
                <PrimaryButton @click="exportData" class="btn btn-secondary">
                    <i class="fa fa-file-export"></i> Export
                </PrimaryButton>
                <PrimaryButton @click="openf" class="btn btn-primary">
                    <i class="fa fa-upload"></i> Import
                </PrimaryButton>
                <PrimaryButton @click="deleteall" class="btn btn-danger">
                    <i class="fa fa-trash"></i> Delete
                </PrimaryButton>
            </div>
        </div>
        <div v-if="isModalOpenf" class="modal-overlay ">
            <div class="modal ">
                <form @submit.prevent="importFile" enctype="multipart/form-data">
                    <div class="mb-4">
                        <label for="file" class="block font-bold">Upload User Information from Excel </label>
                        <input type="file" id="file" ref="file" @change="handleFile" />
                    </div>
                    <div class="text-2xl font-bold mb-4 flex space-x-4">
                        <PrimaryButton type="submit" class="btn btn-primary"><i class="fa fa-upload"></i> Import
                        </PrimaryButton>
                        <PrimaryButton type="reset" class="btn btn-Secondary">Clear</PrimaryButton>
                        <PrimaryButton type="button" @click="closeModalf" class="btn btn-danger">Close</PrimaryButton>
                    </div>
                </form>
            </div>
        </div>
        <!-- User Data Table -->
        <div class="datatable1">
            <div class="mdl-data-table-container">
                <DataTable class="data-table">
                    <thead>
                        <tr>
                            <th>Action</th>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Birth Date</th>
                            <th>Email</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="data in posts" :key="data.id">
                            <td>
                                <button @click="openEditModal(data)" class="btn btn-primary">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button @click="deleteItem(data.id)" class="btn btn-danger">
                                    <i class="fa-regular fa-trash-can"></i>
                                </button>
                            </td>
                            <td>{{ data.id }}</td>
                            <td>{{ data.name }}</td>
                            <td>{{ data.phone }}</td>
                            <td>{{ data.bdate }}</td>
                            <td>{{ data.email }}</td>
                        </tr>
                    </tbody>
                </DataTable>
            </div>
        </div>
        <!-- Registration Modal -->
        <div v-if="isModalOpen" class="modal-overlay">
            <div class="modal">
                <form @submit.prevent="registerUser" id="registration-form">
                    <h1 class="text-2xl font-bold mb-4 text-center">User Registration</h1>
                    <!-- Input Fields -->
                    <div class="flex flex-col gap-2 mb-4">
                        <label for="name" class="required">Name</label>
                        <input id="name" v-model="form.name" type="text" class="form-input" required />
                        <span id="name-error" class="error-message"></span>
                    </div>
                    <div class="flex flex-col gap-2 mb-4">
                        <label for="phone" class="required">Phone</label>
                        <input id="phone" v-model="form.phone" type="number" class="form-input" required />
                        <span v-if="errors.phone" class="error">{{ errors.phone }}</span>
                    </div>
                    <div class="flex flex-col gap-2 mb-4">
                        <label for="bdate" class="required">Birth Date</label>
                        <input id="bdate" v-model="form.bdate" type="date" class="form-input" required />
                    </div>
                    <div class="flex flex-col gap-2 mb-4">
                        <label for="email" class="required">Email</label>
                        <input id="email" v-model="form.email" type="text" placeholder="kiot12@gmail.com" required />
                        <span v-if="errors.email" class="error">{{ errors.email }}</span>
                    </div>
                    <!-- Modal Buttons -->
                    <div class="flex justify-between gap-2">
                        <PrimaryButton type="submit" class="btn btn-primary">Register</PrimaryButton>
                        <PrimaryButton type="button" @click="closeModal" class="btn btn-danger">Close
                        </PrimaryButton>
                        <PrimaryButton type="reset" class="btn btn-secondary">Clear</PrimaryButton>
                    </div>
                </form>
            </div>
        </div>
        <!-- Edit Modal -->
        <div v-if="isEditModalOpen" class="modal-overlay">
            <div class="modal">
                <form @submit.prevent="updateUser">
                    <h1 class="text-2xl font-bold mb-4 text-center">Edit User</h1>
                    <div class="flex flex-col gap-2 mb-4">
                        <label for="edit-name" class="required">Name</label>
                        <input id="edit-name" v-model="editForm.name" type="text" class="form-input" required />
                    </div>
                    <div class="flex flex-col gap-2 mb-4">
                        <label for="edit-phone" class="required">Phone</label>
                        <input id="edit-phone" v-model="editForm.phone" type="number" class="form-input" required />
                    </div>
                    <div class="flex flex-col gap-2 mb-4">
                        <label for="edit-bdate" class="required">Birth Date</label>
                        <input id="edit-bdate" v-model="editForm.bdate" type="date" class="form-input" required />
                    </div>
                    <div class="flex flex-col gap-2 mb-4">
                        <label for="edit-email" class="required">Email</label>
                        <input id="edit-email" v-model="editForm.email" type="email" class="form-input" required />
                    </div>
                    <div class="flex justify-between gap-2">
                        <PrimaryButton type="submit" class="btn btn-primary">Update</PrimaryButton>
                        <PrimaryButton type="reset" class="btn btn-primary">clear</PrimaryButton>
                        <PrimaryButton type="button" @click="closeEditModal" class="btn btn-danger">Close
                        </PrimaryButton>
                    </div>
                </form>
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
    props: { posts: Array },
    setup(props) {

        // State for modal visibility
        const isModalOpen = ref(false);
        const isModalOpenf = ref(false);
        // Form data
        const form = useForm({
            name: "",
            phone: "",
            bdate: "",
            email: "",
        });
        const openf = () => {
            form.reset();
            isModalOpenf.value = true;
        };
        // Close modal
        const closeModalf = () => {
            isModalOpenf.value = false;
        };
        // Open modal
        const openModal = () => {
            form.reset();
            isModalOpen.value = true;
        };
        // Close modal
        const closeModal = () => {
            isModalOpen.value = false;
        };
        const deleteall = () => {
            if (confirm('d you want to delete all data')) {
                Inertia.delete('/delete'), {
                    onSuccess: () => { alert('all data ara deleted'); },
                    onerror: (error) => {
                        alert('error', error);
                    }
                }

            }
        }
        const deleteItem = (id) => {
            if (confirm('Are you sure you want to delete this item?')) {
                router.delete(`/posts/${id}`, {
                    onSuccess: () => {
                        alert('Item deleted successfully!');
                        Inertia.reload()
                    },
                    onError: (error) => {
                        console.error('Error deleting item:', error);
                    },
                });
            }
        }
        const errors = reactive({ phone: null, email: null });
        const validatePhone = (phone) => {
            const phoneRegex = /^[0-9]{10}$/; // Example: Accepts exactly 10 digits
            return phoneRegex.test(phone) ? null : 'Phone number must be 10 digits';
        };
        const validateEmail = (email) => {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/; // Basic email validation
            return emailRegex.test(email) ? null : 'Invalid email address';
        };
        watch(
            () => form.phone,
            (newPhone) => {
                errors.phone = validatePhone(newPhone);
            }
        );
        watch(
            () => form.email,
            (newEmail) => {
                errors.email = validateEmail(newEmail);
            }
        );
        const registerUser = () => {
            errors.phone = validatePhone(form.phone);
            errors.email = validateEmail(form.email);
            if (!errors.phone && !errors.email) {
                router.post("/custreg", form, {
                    onSuccess: () => {
                        alert("User registered successfully!");
                    },
                    onError: (errors) => {
                        console.error("Error registering user:", errors);
                    },
                });
            }
            console.log(form);
            form.reset();
        };
        // Export data
        const exportData = () => {
            if (confirm("do yo want to export in excel ")) {
                window.location.href = "/posts/export";
            }
        };
        const selectedFile = ref(null);
        const handleFile = (event) => {
            selectedFile.value = event.target.files[0];
        };
        const importFile = () => {
            if (!selectedFile.value) {
                alert('Please select a file!');
                return;
            }
            const formData = new FormData();
            formData.append('file', selectedFile.value);
            router.post('import', formData, {
                onSuccess: () => {
                    alert('File imported successfully!');
                    Inertia.reload();
                },
                onError: (errors) => {
                    console.error(errors);
                    alert('There was an error importing the file.');
                },
            })
        };
        //update user
        const isEditModalOpen = ref(false);
        const editForm = ref({ id: null, name: "", phone: "", bdate: "", email: "" });
        const openEditModal = (data) => {
            editForm.value = { ...data };
            isEditModalOpen.value = true;
        };
        const closeEditModal = () => { isEditModalOpen.value = false; };
        const updateUser = () => {
            if (confirm("do you want to update")) {
                Inertia.put(route('posts.update', editForm.value.id), editForm.value, {
                    onSuccess: () => {
                        alert("User updated successfully!");
                        Inertia.reload();
                        closeEditModal();
                    },
                    onError: (errors) => {
                        console.error("Update failed:", errors);
                    },
                });
            }
        }
        return {
            isModalOpen,
            form,
            openModal,
            closeModal,
            registerUser,
            deleteItem,
            exportData,
            errors,
            //for importing data
            openf,
            closeModalf,
            isModalOpenf,
            importFile,
            handleFile,
            selectedFile,
            posts: ref(props.posts),
            //update user data
            openEditModal,
            closeEditModal,
            updateUser,
            isEditModalOpen,
            editForm,
            //delete all data
            deleteall
        };
    },
};
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
    max-width: 500px;
    z-index: 100;
}

.btn-secondary {
    background-color: #6c757d;
    color: white;
}

.btn-primary {
    background-color: #007bff;
}

.btn-danger {
    background-color: #dc3545;
}

.btn i {
    margin-right: 0.5rem;
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
</style>
