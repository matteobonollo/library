<template>
    <div class="max-w-4xl mx-auto p-6" v-if="book">
      <div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-lg p-6">
        <img :src="book.image" alt="Book Image" class="w-full h-64 object-cover rounded-lg mb-4">
        <h2 class="text-3xl font-bold text-gray-800 dark:text-white mb-4">{{ book.name }}</h2>
        <p class="text-gray-600 dark:text-gray-400 mb-4">{{ book.description }}</p>
        <p class="text-lg font-bold text-gray-800 dark:text-white mb-6">Price: ${{ book.price }}</p>
        <button @click="goBack" class="bg-gray-500 text-white px-4 py-2 rounded-md shadow hover:bg-gray-600 transition-colors">
          Go Back
        </button>
      </div>
    </div>
    <div v-else>
      <p>Loading...</p>
    </div>
  </template>
  
  <script setup>
  import { ref, onMounted } from 'vue';
  import { usePage } from '@inertiajs/inertia-vue3';
  import { useRouter } from 'vue-router';
  
  const { book } = usePage().props;
  
  // Define the `goBack` function to navigate back
  const router = useRouter();
  function goBack() {
    router.back();
  }
  </script>
  