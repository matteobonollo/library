<template>
    <div>
        <h1>Add New User</h1>
        <form @submit.prevent="createUser">
            <label for="name">Name:</label>
            <input type="text" v-model="user.name" id="name" required />
            
            <label for="email">Email:</label>
            <input type="email" v-model="user.email" id="email" required />
            
            <button type="submit">Add User</button>
        </form>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import axios from 'axios';
import { useRouter } from 'vue-router';

const router = useRouter();
const user = ref({ name: '', email: '' });

async function createUser() {
    try {
        await axios.post('/users', user.value);
        router.push('/');
    } catch (err) {
        console.error('Failed to add user', err);
    }
}
</script>
