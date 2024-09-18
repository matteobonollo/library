<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { usePage } from '@inertiajs/vue3';
import { Head } from '@inertiajs/vue3';
import { Inertia } from '@inertiajs/inertia';

const page = usePage();
const currentUser = page.props.auth.user;

const users = ref([]);
const error = ref(null);
const selectedUserId = ref(null);
const selectedUserBooks = ref([]);
const loadingBooks = ref(false);

async function fetchUsers() {
    try {
        const response = await axios.get('/users');
        users.value = response.data;
    } catch (err) {
        error.value = err.response?.data?.error || 'An error occurred';
    }
}

onMounted(() => {
    if (currentUser && currentUser.is_admin) {
        fetchUsers();
    } else {
        error.value = 'You are not authorized to view this page.';
    }
});

function editUser(userId) {
    Inertia.visit(`/users/${userId}/edit`);
}

async function deleteUser(userId) {
    if (confirm('Are you sure you want to delete this user?')) {
        try {
            await Inertia.delete(`/users/${userId}`);
            fetchUsers();
        } catch (err) {
            console.error('Failed to delete user', err);
        }
    }
}

function addUser() {
    Inertia.visit('/profile/AddUser'); // Update to navigate to AddUser.vue
}

async function fetchUserBooks(userId) {
    loadingBooks.value = true;
    try {
        const response = await axios.get(`/users/${userId}/favorites`);
        selectedUserBooks.value = response.data;
    } catch (err) {
        console.error('Failed to fetch user books', err);
    } finally {
        loadingBooks.value = false;
    }
}

function toggleBooks(userId) {
    if (selectedUserId.value === userId) {
        selectedUserId.value = null;
    } else {
        selectedUserId.value = userId;
        fetchUserBooks(userId);
    }
}

function viewBookDetail(bookId) {
    Inertia.visit(`/books/${bookId}`);
}
</script>


<template>
    <Head title="User List" />

    <div v-if="error" class="text-red-500 mb-4">{{ error }}</div>

    <div v-if="users.length > 0">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-bold">User List</h2>
        </div>
        <ul class="list-none p-0 space-y-4">
            <li v-for="user in users" :key="user.id" class="bg-white border rounded-lg shadow-md overflow-hidden">
                <div class="p-4">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="font-semibold text-lg cursor-pointer flex items-center" @click="toggleBooks(user.id)">
                                {{ user.name }}
                                <i :class="['fas', 'ml-2', selectedUserId === user.id ? 'fa-chevron-down' : 'fa-chevron-right']"></i>
                            </p>
                            <p class="text-gray-600">{{ user.email }}</p>
                        </div>
                    </div>
                    <div v-if="selectedUserId === user.id" class="mt-4">
                        <div v-if="loadingBooks" class="text-gray-500">Loading favorite books...</div>
                        <div v-else-if="selectedUserBooks.length > 0">
                            <h3 class="text-lg font-bold mb-2">Favorite Books</h3>
                            <div v-for="book in selectedUserBooks" :key="book.id" class="p-4 mb-2 bg-gray-100 border rounded-lg shadow-sm cursor-pointer hover:bg-gray-200 transition" @click="viewBookDetail(book.id)">
                                <p class="font-semibold text-md">{{ book.name }}</p>
                                <p class="text-gray-600">{{ book.description }}</p>
                            </div>
                        </div>
                        <div v-else>
                            <p>No favorite books available.</p>
                        </div>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</template>
