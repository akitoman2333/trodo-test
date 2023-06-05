<script setup>
import { Form, Field } from 'vee-validate';
import * as Yup from 'yup';
import { useAuthStore } from '@/stores';

const schema = Yup.object().shape({
    email: Yup.string().required('Email is required').email('Email must be a valid email'),
    name: Yup.string().required('Name is required'),
    password: Yup.string().required('Password is required')
});

function onSubmit(values, { setErrors }) {
    const authStore = useAuthStore();
    const { email, name, password } = values;

    return authStore.register(email, name, password)
        .catch(error => {

            console.log('error', error)

            setErrors({apiError: error})
        });
}
</script>
<template>
    <div class="min-h-screen flex items-center justify-center bg-gray-50 px-4">
        <div class="max-w-md w-full">
            <h2 class="text-center text-2xl font-bold text-gray-800 mb-6">Create your dashboard</h2>

            <Form @submit="onSubmit" :validation-schema="schema" v-slot="{ errors, isSubmitting }" class="space-y-4">
                <div>
                    <div class="relative text-gray-400">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-2">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-6 w-6"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"
                        />
                      </svg>
                    </span>

                        <Field name="name"
                               type="text"
                               class="
                                  w-full
                                  py-4
                                  text-sm text-gray-900
                                  rounded-md
                                  pl-10
                                  border
                                  border-gray-300
                                  focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10
                                "
                               placeholder="Name"
                               :class="{ 'border-red-300': errors.name }" />
                    </div>
                    <div class="text-red-300">{{errors.name}}</div>
                </div>

                <div>
                    <div class="relative text-gray-400">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-2">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-6 w-6"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"
                        />
                      </svg>
                    </span>

                        <Field name="email"
                               type="text"
                               class="
                              w-full
                              py-4
                              text-sm text-gray-900
                              rounded-md
                              pl-10
                              border
                              border-gray-300
                              focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10
                            "
                               placeholder="Email address"
                               :class="{ 'border-red-300': errors.email }" />
                    </div>
                    <div class="text-red-300">{{errors.email}}</div>
                </div>

                <div>
                    <div class="relative text-gray-400">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-2">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-6 w-6"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"
                        />
                      </svg>
                    </span>

                        <Field
                            id="password"
                            name="password"
                            type="password"
                            autocomplete="current-password"
                            required=""
                            class="
                              w-full
                              py-4
                              text-sm text-gray-900
                              rounded-md
                              pl-10
                              border border-gray-300
                              focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10
                            "
                            placeholder="Password"
                            :class="{ 'border-red-300': errors.password }" />
                    </div>
                    <div class="text-red-300">{{errors.password}}</div>
                </div>

                <div>
                    <button
                            type="submit"
                            class="
                              group
                              relative
                              w-full
                              flex
                              justify-center
                              py-4
                              px-6
                              border border-transparent
                              font-medium
                              rounded-md
                              text-white
                              bg-indigo-600
                              hover:bg-indigo-700
                              focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500
                            "
                            :disabled="isSubmitting"
                    >
                        <span v-show="isSubmitting" class="spinner-border spinner-border-sm mr-1"></span>
                        Create an account
                    </button>
                </div>

                <div v-if="errors.apiError" class="text-red-300">{{errors.apiError}}</div>
            </form>

            <div class="mt-2 text-sm text-gray-600">
                Registered already?
                <router-link to="/login" class="font-medium text-indigo-600 hover:text-indigo-500">
                    Sing in
                </router-link>
            </div>
        </div>
    </div>
</template>
