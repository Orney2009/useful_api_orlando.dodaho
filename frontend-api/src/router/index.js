import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/RegistrationView.vue'
import ModulesView from '@/views/ModulesView.vue'
import UrlShortenerView from '@/views/UrlShortenerView.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/auth/register',
      name: 'home',
      component: HomeView,
    },
    {
      path: '/modules',
      name: 'modules',
      component: ModulesView,
    },
    {
      path: '/url-shortener',
      name: 'urls',
      component: UrlShortenerView,
    },
    {
      path: '/auth/login',
      name: 'login',
      // route level code-splitting
      // this generates a separate chunk (About.[hash].js) for this route
      // which is lazy-loaded when the route is visited.
      component: () => import('../views/LoginView.vue'),
    },
  ],
})

export default router
