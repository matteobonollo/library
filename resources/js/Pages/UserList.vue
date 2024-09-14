<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { usePage } from '@inertiajs/vue3'; // To get the current page data
import { Head } from '@inertiajs/vue3';

// Fetch current user data from Inertia page props
const page = usePage();
const currentUser = page.props.auth.user;

const users = ref([]);
const error = ref(null);

async function fetchUsers() {
    try {
        // Fetch users from API
        const response = await axios.get('/users');
        users.value = response.data;
    } catch (err) {
        error.value = err.response?.data?.error || 'An error occurred';
    }
}

// Fetch users on component mount if the current user is an admin
onMounted(() => {
    if (currentUser && currentUser.is_admin) {
        fetchUsers();
    } else {
        error.value = 'You are not authorized to view this page.';
    }
});

function editUser(userId) {
    // Logic for editing a user
    console.log(`Edit user ${userId}`);
}

function deleteUser(userId) {
    // Logic for deleting a user
    console.log(`Delete user ${userId}`);
}

function addUser() {
    // Logic for adding a user
    console.log('Add new user');
}
</script>

<template>
    <Head title="User List" />

    <div v-if="error" class="text-red-500 mb-4">{{ error }}</div>

    <div v-if="users.length > 0">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-bold">User List</h2>
            <button @click="addUser" class="bg-green-500 text-white px-4 py-2 rounded-full shadow-lg hover:bg-green-600 transition">
                <i class="fas fa-plus"></i>
            </button>
        </div>
        <ul class="list-none p-0">
            <li v-for="user in users" :key="user.id" class="flex items-center justify-between p-4 mb-2 bg-white border rounded-lg shadow-md">
                <div class="flex-1">
                    <p class="font-semibold">{{ user.name }}</p>
                    <p class="text-gray-600">{{ user.email }}</p>
                    <div class="flex items-center mt-2">
                        <input type="checkbox" :checked="user.is_admin" disabled class="mr-2" />
                        <label class="text-gray-600">Admin</label>
                    </div>
                </div>
                <div class="flex gap-2">
                    <button @click="editUser(user.id)" class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 transition">Edit</button>
                    <button @click="deleteUser(user.id)" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 transition">Delete</button>
                </div>
            </li>
        </ul>
    </div>
</template>

<style scoped>
/* Add any additional styles here */
</style>
