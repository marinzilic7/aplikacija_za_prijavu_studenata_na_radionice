import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import RegisterView from '../views/RegisterView.vue'
import LoginView from '../views/LoginView.vue'
import RadioniceView from '../views/RadioniceView.vue'
import KategorijeView from '../views/KategorijeView.vue'


const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes: [
        {
            path: '/',
            name: 'home',
            component: HomeView
        },
        {
            path: '/register',
            name: 'register',
            component: RegisterView
        },
        {
            path: '/login',
            name: 'login',
            component: LoginView
        },
        {
            path: '/radionice',
            name: 'radionice',
            component: RadioniceView
        },
        {
            path: '/kategorije',
            name: 'kategorije',
            component: KategorijeView
        },
    ]
})

export default router
