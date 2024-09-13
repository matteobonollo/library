<script setup>
import { ref } from 'vue';

const searchQuery = ref('');
const emit = defineEmits(['update-search']);

function emitSearchQuery() {
  emit('update-search', searchQuery.value);
}
</script>

<template>
    <div class="search-bar">
      <input
        v-model="searchQuery"
        @input="emitSearchQuery"
        placeholder="Cerca libri..."
        class="p-2 border rounded-md shadow-sm"
      />
      <button @click="emitSearchQuery" class="ml-2 p-2 bg-blue-500 text-white rounded-md">
        Cerca
      </button>
    </div>
</template>

<style scoped>
.search-bar {
  display: flex;
  justify-content: center;
  align-items: center;
}
input {
  color: black; /* Ensure the text color is visible */
}
</style>
