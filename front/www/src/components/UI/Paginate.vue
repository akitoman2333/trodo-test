<script setup>
import LeftIcon from "@/components/icons/LeftIcon.vue";
import RightIcon from "@/components/icons/RightIcon.vue";
import {computed} from "vue";

const props = defineProps({
    data: Object
})

const emit = defineEmits(['changePage'])

const startPages = computed(() => {
    if (props.data.last_page > 5)
        return [1, 2]

    return props.data.last_page
})
const endPages = computed(() => {
    if (props.data.last_page > 5)
        return [
            props.data.last_page - 1,
            props.data.last_page,
        ]

    return []
})


</script>

<template>
    <nav>
        <ul class="inline-flex -space-x-px">
            <ul class="inline-flex -space-x-px">
                <li>
                    <button
                        :disabled="data.current_page === 1"
                        @click="emit('changePage', data.current_page-1)"
                        class="h-full px-3 py-2 ml-0 leading-tight text-gray-500 bg-white border border-gray-300 rounded-l-lg hover:bg-gray-100 hover:text-gray-700">
                        <LeftIcon />
                    </button>
                </li>
                <li v-for="page in startPages">
                    <button @click="emit('changePage', page)"
                            :disabled="page === data.current_page"
                            :class="{'font-black': page === data.current_page}"
                            class="px-3 py-2 text-sm leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700">{{ page }}</button>
                </li>

                <template v-if="endPages.length">
                    <li>
                        <div class="px-3 py-2 text-sm leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700">
                            ...
                        </div>
                    </li>
                    <li v-if="data.current_page > 2 && data.current_page < endPages[0]">
                        <button disabled class="px-3 py-2 font-black text-sm leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700">{{ data.current_page }}</button>
                    </li>
                    <li v-if="data.current_page > 2 && data.current_page < endPages[0]">
                        <div class="px-3 py-2 text-sm leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700">
                            ...
                        </div>
                    </li>
                </template>

                <li v-for="page in endPages">
                    <button @click="emit('changePage', page)"
                            :class="{'font-black': page === data.current_page}"
                            class="px-3 py-2 text-sm leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700">{{ page }}</button>
                </li>
                <li>
                    <button
                        :disabled="data.current_page === data.last_page"
                        @click="emit('changePage', data.current_page+1)"
                        class="h-full px-3 py-2 leading-tight text-gray-500 bg-white border border-gray-300 rounded-r-lg hover:bg-gray-100 hover:text-gray-700">
                        <RightIcon />
                    </button>
                </li>
            </ul>
        </ul>
    </nav>
</template>

<style scoped>

</style>