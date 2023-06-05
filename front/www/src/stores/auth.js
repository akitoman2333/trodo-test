import { defineStore } from 'pinia';

import { fetchWrapper } from '@/helpers';
import router from '@/router'

const baseUrl = `${import.meta.env.VITE_API_URL}`;

export const useAuthStore = defineStore({
    id: 'auth',
    state: () => ({
        // initialize state from local storage to enable user to stay logged in
        user: JSON.parse(localStorage.getItem('user')),
        returnUrl: null
    }),
    actions: {
        async login(email, password) {
            const { result } = await fetchWrapper.post(`${baseUrl}/auth/login`, { email, password });

            // update pinia state
            this.user = {
                token: result.access_token,
                id: result.id,
                name: result.name,
            };

            // store user details and jwt in local storage to keep user logged in between page refreshes
            localStorage.setItem('user', JSON.stringify(this.user));

            // redirect to previous url or default to home page
            router.push(this.returnUrl || '/');
        },
        async register(email, name, password) {

            const { success } = await fetchWrapper.post(`${baseUrl}/auth/register`, { email, name, password });

            if (success)
                this.login(email, password)
        },
        logout() {
            this.user = null;
            localStorage.removeItem('user');
            router.push('/login');
        }
    }
});