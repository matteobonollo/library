<template>
  <div class="p-6 bg-background">
    <!-- Display a message if no books are available -->
    <div v-if="books.length === 0" class="text-center text-gray-500">
      No results found
    </div>

    <!-- Display books if available -->
    <div v-else class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
      <div v-for="book in books" :key="book.id"
          class="bg-white border border-gray-200 rounded-lg shadow-default overflow-hidden transition-transform transform hover:scale-105">
        <img :src="book.image" alt="Book Image" class="w-full h-48 object-cover">
        <div class="p-4">
          <h3 class="text-xl font-semibold text-gray-800 mb-2">{{ book.name }}</h3>
          <p class="text-gray-600 mb-4">{{ book.description }}</p>
          <button @click="goToBook(book.id)"
              class="bg-primary text-white px-4 py-2 rounded-md shadow-default hover:bg-blue-600 transition-colors">
              View Details
          </button>
          <!-- Show "Add to Favorites" button if the book is not in favorites -->
          <button v-if="$page.props.auth.user" 
                  @click="addFavorite(book.id)"
                  v-show="!book.is_favorite"
                  class="mt-2 bg-accent text-white px-4 py-2 rounded-md shadow-default hover:bg-yellow-600 transition-colors">
              Add to Favorites
          </button>
          
          <!-- Show "Remove from Favorites" button if the book is in favorites -->
          <button v-if="$page.props.auth.user" 
                  @click="removeFavorite(book.id)"
                  v-show="book.is_favorite"
                  class="mt-2 bg-red-500 text-white px-4 py-2 rounded-md shadow-default hover:bg-red-600 transition-colors">
              Remove from Favorites
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

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
const favorites = ref([...props.favorites]);

async function fetchBooks(searchQuery = '') {
  const response = await axios.get('/books', { params: { search: searchQuery } });
  books.value = response.data;
}

watch(() => props.searchQuery, (newSearchQuery) => {
  fetchBooks(newSearchQuery);
});

function goToBook(id) {
  Inertia.visit(`/books/${id}`);
}

async function addFavorite(bookId) {
  try {
    await axios.post('/favorites', { book_id: bookId });
    favorites.value.push(bookId);
    books.value = books.value.map(book => 
      book.id === bookId ? { ...book, is_favorite: true } : book
    );
  } catch (error) {
    console.error('Error adding favorite:', error);
  }
}

async function removeFavorite(bookId) {
  try {
    await axios.delete(`/favorites/${bookId}`);
    favorites.value = favorites.value.filter(id => id !== bookId);
    books.value = books.value.map(book => 
      book.id === bookId ? { ...book, is_favorite: false } : book
    );
  } catch (error) {
    console.error('Error removing favorite:', error);
  }
}

onMounted(() => {
  fetchBooks(props.searchQuery);
});
</script>
