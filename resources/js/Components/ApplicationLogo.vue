<script setup>
import { Inertia } from '@inertiajs/inertia';

// Function to handle navigation
function goHome() {
    Inertia.visit('/');
}
</script>


<template>
    <button @click="goHome" class="bg-blue-500 text-white p-2 rounded flex items-center">
  <i class="fas fa-home mr-2"></i></button>
</template>
