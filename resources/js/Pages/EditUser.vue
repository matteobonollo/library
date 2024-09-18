<template>
    <div>
        <h1>Edit User</h1>
        <form @submit.prevent="saveUser">
            <label for="name">Name:</label>
            <input type="text" v-model="user.name" id="name" required />
            
            <label for="email">Email:</label>
            <input type="email" v-model="user.email" id="email" required />
            
            <button type="submit">Save</button>
        </form>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { useRoute, useRouter } from 'vue-router';

const route = useRoute();
const router = useRouter();
const userId = route.params.id;
const user = ref({ name: '', email: '' });

async function fetchUser() {
    try {
        const response = await axios.get(`/users/${userId}`);
        user.value = response.data;
    } catch (err) {
        console.error('Failed to fetch user', err);
    }
}

async function saveUser() {
    try {
        await axios.put(`/users/${userId}`, user.value);
        router.push('/');
    } catch (err) {
        console.error('Failed to save user', err);
    }
}

onMounted(() => {
    fetchUser();
});
</script>
