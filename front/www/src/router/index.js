import {createRouter, createWebHistory} from 'vue-router'
import {useAuthStore} from '@/stores';

const routes = [
    {
        path: '/',
        name: 'dashboard',
        component: () => import('@/views/Dashboard.vue'),
        children: [
            {
                path: '',
                component: () => import('@/views/dashboard/Home.vue'),
            },
        ],
    },
    {
        path: '/',
        name: 'guest',
        component: () => import('@/views/Guest.vue'),
        children: [
            {
                path: '/login',
                name: 'login',
                component: () => import('@/views/guest/Login.vue'),
            },
            {
                path: '/register',
                name: 'register',
                component: () => import('@/views/guest/Register.vue'),
            },
        ],
    },
]

const router = createRouter({
    history: createWebHistory(),
    scrollBehavior() {
        return {top: 0}
    },
    routes,
})

router.beforeEach(async (to) => {
    // redirect to login page if not logged in and trying to access a restricted page
    const publicPages = ['/login', '/register'];
    const authRequired = !publicPages.includes(to.path);
    const auth = useAuthStore();

    if (authRequired && ! auth.user) {
        auth.returnUrl = to.fullPath;
        return '/login';
    } else if (! authRequired && auth.user) {
        return '/';
    }
});

export default router
