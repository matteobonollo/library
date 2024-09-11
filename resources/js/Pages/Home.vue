<script setup>
import { ref, onMounted } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import { Inertia } from '@inertiajs/inertia';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});

const searchQuery = ref('');
const books = ref([]);


async function fetchBooks() {
    const response = await axios.get('/books');
    books.value = response.data;
}

async function searchBooks() {
    const response = await axios.get('/books', { params: { search: searchQuery.value } });
    books.value = response.data;
}

function goToBook(id) {
    console.log(`Navigating to /books/${id}`);
    Inertia.visit(`/books/${id}`);
}

onMounted(() => {
    fetchBooks();
});





function handleImageError() {
    document.getElementById('screenshot-container')?.classList.add('!hidden');
    document.getElementById('docs-card')?.classList.add('!row-span-1');
    document.getElementById('docs-card-content')?.classList.add('!flex-row');
    document.getElementById('background')?.classList.add('!hidden');
}
function handleSearch() {
    console.log(searchQuery.value); // Handle the search action here, maybe make an API call.
}
</script>

<template>

    <Head title="Welcome" />
    <div class="bg-gray-50 text-black/50 dark:bg-black dark:text-white/50">
        <img id="background" class="absolute -left-20 top-0 max-w-[877px]" src="" />
        <div
            class="relative min-h-screen flex flex-col items-center justify-center selection:bg-[#FF2D20] selection:text-white">
            <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl">
                <header class="grid grid-cols-2 items-center gap-2 py-10 lg:grid-cols-3">
                    <div class="flex justify-center mb-6">
                        <input v-model="searchQuery" @input="handleSearch" type="text" placeholder="Search..."
                            class="w-full max-w-lg p-2 border rounded-md shadow-sm dark:bg-gray-800 dark:border-gray-700 dark:text-white" />
                        <button @click="handleSearch" class="ml-2 p-2 bg-[#FF2D20] text-white rounded-md">
                            Search
                        </button>
                    </div>
                    <div class="flex lg:justify-center lg:col-start-2">
                        <!-- Your SVG Logo -->
                    </div>
                    <nav v-if="canLogin" class="-mx-3 flex flex-1 justify-end">
                        <Link v-if="$page.props.auth.user" :href="route('dashboard')"
                            class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                        Dashboard
                        </Link>

                        <template v-else>
                            <Link :href="route('login')"
                                class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                            Log in
                            </Link>

                            <Link v-if="canRegister" :href="route('register')"
                                class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                            Register
                            </Link>
                        </template>
                    </nav>
                </header>

                <main class="mt-6">
                    <!-- Add search bar here -->


                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 p-6">
                        <div v-for="book in books" :key="book.id"
                            class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-lg overflow-hidden transition-transform transform hover:scale-105">
                            <img :src="book.image" alt="Book Image" class="w-full h-48 object-cover">
                            <div class="p-4">
                                <h3 class="text-xl font-semibold text-gray-800 dark:text-white mb-2">{{ book.name }}
                                </h3>
                                <p class="text-gray-600 dark:text-gray-400 mb-4">{{ book.description }}</p>
                                <button @click="goToBook(book.id)"
                                    class="bg-blue-500 text-white px-4 py-2 rounded-md shadow hover:bg-blue-600 transition-colors">
                                    Scopri di più
                                </button>
                            </div>
                        </div>
                    </div>
                </main>

                <footer class="py-16 text-center text-sm text-black dark:text-white/70">
                    Laravel v{{ laravelVersion }} (PHP v{{ phpVersion }})
                </footer>
            </div>
        </div>
    </div>
</template>
