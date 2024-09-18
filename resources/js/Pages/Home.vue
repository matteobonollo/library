<script setup>
import { ref } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import SearchBar from '@/Components/SearchBar.vue';
import BookList from './BookList.vue';

// Reactive variable to store search query
const searchQuery = ref('');

// Props
defineProps({
  canLogin: {
    type: Boolean,
  },
  canRegister: {
    type: Boolean,
  },
});

function updateSearchQuery(newQuery) {
  // Update the search query when received from the SearchBar component
  searchQuery.value = newQuery;
}

function handleImageError() {
  // Handle image errors if necessary
  document.getElementById('background')?.classList.add('!hidden');
}
</script>

<template>
  <Head title="Home" />
  <div class="bg-gray-100 text-gray-900 dark:bg-gray-900 dark:text-gray-100">
    <!-- Background image -->
    <img id="background" class="absolute -left-20 top-0 max-w-[877px] hidden md:block" src="" alt="Background" />

    <div class="relative min-h-screen flex flex-col items-center selection:bg-red-500 selection:text-white">
      <!-- Header -->
      <header class="relative w-full max-w-6xl px-6 lg:px-12 py-6 lg:py-10 flex flex-col lg:flex-row items-center justify-between">
        <!-- SearchBar -->
        <div class="flex lg:justify-start mb-6 lg:mb-0 w-full lg:w-auto">
          <SearchBar @update-search="updateSearchQuery" />
        </div>

        <!-- Logo -->
        <div class="flex justify-center lg:justify-center">
          <ApplicationLogo class="block h-10 w-auto fill-current text-blue-600" />
        </div>

        <!-- Navigation -->
        <nav v-if="canLogin" class="flex flex-1 justify-end mt-6 lg:mt-0 w-full lg:w-auto">
          <Link v-if="$page.props.auth.user" :href="route('dashboard')"
                class="px-4 py-2 text-blue-600 rounded-md ring-1 ring-transparent transition hover:text-blue-700 focus:outline-none focus-visible:ring-red-500 dark:text-white dark:hover:text-gray-200 dark:focus-visible:ring-white">
            Dashboard
          </Link>

          <template v-else>
            <Link :href="route('login')"
                  class="px-4 py-2 text-blue-600 rounded-md ring-1 ring-transparent transition hover:text-blue-700 focus:outline-none focus-visible:ring-red-500 dark:text-white dark:hover:text-gray-200 dark:focus-visible:ring-white">
              Log in
            </Link>

            <Link v-if="canRegister" :href="route('register')"
                  class="px-4 py-2 text-blue-600 rounded-md ring-1 ring-transparent transition hover:text-blue-700 focus:outline-none focus-visible:ring-red-500 dark:text-white dark:hover:text-gray-200 dark:focus-visible:ring-white">
              Register
            </Link>
          </template>
        </nav>
      </header>

      <!-- Main content -->
      <main class="w-full max-w-6xl px-6 lg:px-12 mt-8">
        <BookList :searchQuery="searchQuery" />
      </main>

      <!-- Footer -->
      <footer class="py-16 text-center text-sm text-gray-700 dark:text-gray-400">
        Matteo Bonollo
      </footer>
    </div>
  </div>
</template>
