<template>
  <ApplicationLogo  />
  <div v-if="book" class="p-6 bg-background max-w-4xl mx-auto">
    <h1 class="text-3xl font-bold mb-4 text-gray-900">{{ book.name }}</h1>
    <img :src="book.image" alt="Book Image" class="w-full h-64 object-cover mb-4 rounded-lg">
    <p class="text-lg text-gray-700 mb-4">{{ book.description }}</p>
    <p class="text-lg font-semibold text-gray-900">Price: ${{ book.price }}</p>

    <!-- Display the appropriate button based on the favorite status -->
    <button v-if="$page.props.auth.user && !isBookFavorite" @click="addFavorite" class="mt-4 bg-accent text-white px-6 py-3 rounded-md shadow-default hover:bg-yellow-600 transition-colors">
      Add to Favorites
    </button>
    <button v-if="$page.props.auth.user && isBookFavorite" @click="removeFavorite" class="mt-4 bg-red-500 text-white px-6 py-3 rounded-md shadow-default hover:bg-red-600 transition-colors">
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
import ApplicationLogo from '@/Components/ApplicationLogo.vue';

const { book, isFavorite } = usePage().props;
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
/* Optional: Add additional styles if necessary */
</style>
