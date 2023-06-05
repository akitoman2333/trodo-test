<script setup>
import TheSidebar from '@/components/layouts/TheSidebar.vue'
import TheHeader from '@/components/layouts/TheHeader.vue'
import TheFooter from '@/components/layouts/TheFooter.vue'
import {ref} from "vue";

const openMenu = ref(false);
</script>
<template>
    <div class="flex min-h-screen">
        <the-sidebar :openMenu="openMenu"/>

        <div class="flex flex-col flex-grow bg-gray-200">
            <the-header @openMenu="openMenu = ! openMenu"/>

            <div class="mb-auto">
                <router-view/>
            </div>

            <the-footer/>
        </div>
    </div>
</template>
