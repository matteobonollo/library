<template>
  <div v-if="book" class="p-6">
    <h1 class="text-2xl font-bold mb-4">{{ book.name }}</h1>
    <img :src="book.image" alt="Book Image" class="w-full h-auto mb-4" />
    <p class="text-lg mb-4">{{ book.description }}</p>
    <p class="text-lg font-semibold">Price: ${{ book.price }}</p>
    
    <!-- Display the appropriate button based on the favorite status -->
    <button v-if="!isBookFavorite" @click="addFavorite" class="bg-green-500 text-white px-4 py-2 rounded-md">
      Add to Favorites
    </button>
    <button v-if="isBookFavorite" @click="removeFavorite" class="bg-red-500 text-white px-4 py-2 rounded-md">
      Remove from Favorites
    </button>
  </div>
  <div v-else class="p-6 text-center text-gray-500">
    Loading...
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { usePage } from '@inertiajs/vue3';

// Props
const { book, isFavorite } = usePage().props;

// Local state to track favorite status
const isBookFavorite = ref(isFavorite);

async function addFavorite() {
  try {
    await axios.post('/favorites', { book_id: book.id });
    isBookFavorite.value = true;
  } catch (error) {
    console.error('Error adding favorite:', error);
  }
}

async function removeFavorite() {
  try {
    await axios.delete(`/favorites/${book.id}`);
    isBookFavorite.value = false;
  } catch (error) {
    console.error('Error removing favorite:', error);
  }
}
</script>

<style scoped>
/* Add your styles here */
</style>
