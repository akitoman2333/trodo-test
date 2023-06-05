<script setup>
import {Menu, MenuButton, MenuItems, MenuItem} from '@headlessui/vue'
const emit = defineEmits(['openMenu'])
import { useAuthStore } from '@/stores';
import DownIcon from "@/components/icons/DownIcon.vue";

function onLogout() {
    const authStore = useAuthStore()
    authStore.logout()
}
</script>
<template>
    <header class="flex justify-between bg-white border-b-2 px-4 sm:justify-end sm:px-6">
        <button class="sm:hidden" @click="emit('openMenu')">
            <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-6 w-6 text-gray-600"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
            >
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>
        <Menu as="div" class="relative">
            <MenuButton class="flex items-center space-x-2 px-2 py-3 text-sm hover:bg-gray-200 focus:outline-none">
                <span>Sub Menu</span>
                <DownIcon />
            </MenuButton>
            <transition
                    enter-active-class="transition ease-out duration-100"
                    enter-from-class="transform opacity-0 scale-95"
                    enter-to-class="transform opacity-100 scale-100"
                    leave-active-class="transition ease-in duration-75"
                    leave-from-class="transform opacity-100 scale-100"
                    leave-to-class="transform opacity-0 scale-95"
            >
                <MenuItems
                        class="
                            origin-top-right
                            absolute
                            right-0
                            w-48
                            shadow-lg
                            py-1
                            bg-white
                            ring-1 ring-black ring-opacity-5
                            divide-y divide-gray-200
                            focus:outline-none
                          "
                >
                    <MenuItem v-slot="{ active }">
                        <a
                            href="#"
                            class="block px-4 py-2 text-sm text-gray-700"
                            @click="onLogout"
                            :class="[active ? 'bg-gray-200' : '', 'block px-4 py-2 text-sm text-gray-700']"
                        >
                            Sign out
                        </a>
                    </MenuItem>
                </MenuItems>
            </transition>
        </Menu>
    </header>
</template>
