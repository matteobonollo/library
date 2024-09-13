<template>
  <div v-if="book" class="p-6">
    <h1 class="text-2xl font-bold mb-4">{{ book.name }}</h1>
    <img :src="book.image" alt="Book Image" class="w-full h-auto mb-4" />
    <p class="text-lg mb-4">{{ book.description }}</p>
    <p class="text-lg font-semibold">Price: ${{ book.price }}</p>
  </div>
  <div v-else class="p-6 text-center text-gray-500">
    Loading...
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';

import { usePage } from '@inertiajs/vue3';



const { book } = usePage().props;




</script>

<style scoped>
/* Add your styles here */
</style>
