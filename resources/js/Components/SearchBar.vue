<script setup>
import { ref } from 'vue';

// Create a reactive reference for the search query
const searchQuery = ref('');

// Emit an event when the user performs a search
const emit = defineEmits(['search']);
function handleSearch() {
  emit('search', searchQuery.value);  // Emit the search query to the parent
}
</script>

<template>
  <div class="search-bar">
    <input
      type="text"
      v-model="searchQuery"
      placeholder="Search..."
      class="p-2 border rounded-md shadow-sm dark:bg-gray-800 dark:border-gray-700 dark:text-white"
    />
    <button @click="handleSearch" class="ml-2 p-2 bg-blue-500 text-white rounded-md">
      Search
    </button>
  </div>
</template>

<style scoped>
.search-bar {
  display: flex;
  justify-content: center;
  align-items: center;
}
</style>
