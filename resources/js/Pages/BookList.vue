<script setup>
import { ref, watch, onMounted } from 'vue';
import axios from 'axios';
import { Inertia } from '@inertiajs/inertia';

// Props
const props = defineProps({
  searchQuery: {
    type: String,
    default: '',
  },
  favorites: {
    type: Array,
    default: () => [],
  },

});

const books = ref([]);

async function fetchBooks(searchQuery = '') {
  const response = await axios.get('/books', { params: { search: searchQuery } });
  books.value = response.data;
}

watch(() => props.searchQuery, (newSearchQuery) => {
  fetchBooks(newSearchQuery);
});

function goToBook(id) {
  console.log(`Navigating to /books/${id}`);
  Inertia.visit(`/books/${id}`);
}

async function addFavorite(bookId) {
  try {
    await axios.post('/favorites', { book_id: bookId });
    // Optionally update the UI or refetch favorites
  } catch (error) {
    console.error('Error adding favorite:', error);
  }
}

async function removeFavorite(bookId) {
  try {
    await axios.delete(`/favorites/${bookId}`);
    // Optionally update the UI or refetch favorites
  } catch (error) {
    console.error('Error removing favorite:', error);
  }
}

onMounted(() => {
  fetchBooks(props.searchQuery);
});
</script>

<template>
  <div class="p-6">
    <!-- Display a message if no books are available -->
    <div v-if="books.length === 0" class="text-center text-gray-500">
      Nessun risultato trovato
    </div>

    <!-- Display books if available -->
    <div v-else class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
      <div v-for="book in books" :key="book.id"
          class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-lg overflow-hidden transition-transform transform hover:scale-105">
        <img :src="book.image" alt="Book Image" class="w-full h-48 object-cover">
        <div class="p-4">
          <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-2">{{ book.name }}</h3>
          <p class="text-gray-600 dark:text-gray-400 mb-4">{{ book.description }}</p>
          <button @click="goToBook(book.id)"
              class="bg-blue-500 text-white px-4 py-2 rounded-md shadow hover:bg-blue-600 transition-colors">
              Scopri di più
          </button>
          <button v-if="$page.props.auth.user" 
                  @click="addFavorite(book.id)"
                  v-show="!props.favorites.includes(book.id)"
                  class="mt-2 bg-green-500 text-white px-4 py-2 rounded-md shadow hover:bg-green-600 transition-colors">
              Add to Favorites
          </button>
          <button v-if="$page.props.auth.user" 
                  @click="removeFavorite(book.id)"
                  v-show="props.favorites.includes(book.id)"
                  class="mt-2 bg-red-500 text-white px-4 py-2 rounded-md shadow hover:bg-red-600 transition-colors">
              Remove from Favorites
          </button>
        </div>
      </div>
    </div>
  </div>
</template>
