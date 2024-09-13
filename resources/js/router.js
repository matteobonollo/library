import { createRouter, createWebHistory } from 'vue-router';
import BookDetail from './Pages/BookDetail.vue'; // Adjust path if necessary

const routes = [
  {
    path: '/book/:id',
    name: 'BookDetail',
    component: BookDetail,
    props: true,
  },
  // Other routes
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
