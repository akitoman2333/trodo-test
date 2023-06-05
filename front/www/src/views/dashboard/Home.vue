<script setup>
import { useCurrencyStore } from '@/stores'
import {computed, ref, watchEffect} from "vue"
import { debounce, formatDate } from "@/helpers";
import UpIcon from "@/components/icons/UpIcon.vue";
import DownIcon from "@/components/icons/DownIcon.vue";
import Paginate from "@/components/UI/Paginate.vue";

const currencyStore = useCurrencyStore()
const currencies = computed(() => currencyStore.currencies)
const baseCurrency = computed(() => currencyStore.baseCurrency)
const paginate = computed(() => currencyStore.paginate)
const lastUpdated = computed(() => currencyStore.lastUpdated)
const maxValue = computed(() => currencyStore.maxValue)
const minValue = computed(() => currencyStore.minValue)
const avgValue = computed(() => {

    if (! minValue.value || ! maxValue.value)
        return null

    return (minValue.value + maxValue.value) / 2
})

const toCurrency = ref(currencies.value[0])
const page = ref(1)
const order = ref('desc')
const loading = ref(true)

const load = debounce(async () => await currencyStore.load(toCurrency.value, page.value, order.value)
    .finally(() => loading.value = false))

const changePage = (p) => {
    loading.value = true
    page.value = p
    load()
}

const changeToCurrency = () => {
  loading.value = true
  load()
}

const changeOrder = () => {
    loading.value = true
    order.value = order.value === 'asc' ? 'desc' : 'asc'
    load()
}
load()
watchEffect(() => changeToCurrency(toCurrency.value))
</script>
<template>
  <div class="flex justify-between px-4 mt-4 sm:px-8">
    <h2 class="text-2xl text-gray-600">Dashboard</h2>

    <div class="flex items-center space-x-1 text-xs">
      <a href="#" class="font-bold text-indigo-700">Home</a>
      <svg xmlns="http://www.w3.org/2000/svg" class="h-2 w-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
      </svg>
      <span class="text-gray-600">Dashboard</span>
    </div>
  </div>

  <div class="px-4 mt-4 sm:px-8 flex flex-col items-center gap-4">
      <div>
          <label for="toCurrency" class="block mb-2 text-sm font-medium text-gray-900">Select an option</label>
          <select id="toCurrency" v-model="toCurrency" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
            <option v-for="cur in currencies" :value="cur">{{ cur }}</option>
          </select>
      </div>
      <div class="flex items-center font-black text-3xl">
          1 {{ baseCurrency }} to {{ toCurrency }} Exchange Rate
      </div>
      <div v-if="lastUpdated" class="flex items-center">
          Last updated: {{ formatDate(lastUpdated) }}
      </div>
      <div class="flex items-center">
          <Paginate :data="paginate" @changePage="changePage" />
      </div>
      <div class="relative min-w-[300px] overflow-x-auto">
          <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
              <thead class="text-xs text-gray-700 uppercase bg-gray-50">
              <tr>
                  <th scope="col" class="px-6 py-3 flex justify-between cursor-pointer" @click="changeOrder">
                      <span>Date</span>
                      <UpIcon v-if="order === 'asc'"/>
                      <DownIcon v-if="order === 'desc'"/>
                  </th>
                  <th scope="col" class="px-6 py-3">
                      {{ baseCurrency }} to {{ toCurrency }}
                  </th>
              </tr>
              </thead>
              <tbody v-if="! loading">
              <template v-if="paginate.data"></template>
              <tr v-for="item in paginate.data" class="bg-white border-b">
                  <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                      {{ formatDate(item.created_at) }}
                  </th>
                  <td class="px-6 py-4">
                      {{ item.rate }}
                  </td>
              </tr>

              <tr v-if="! paginate.data" class="bg-white border-b">
                  <th colspan="2" scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                      No data
                  </th>
              </tr>
              </tbody>
              <tfoot v-else>
              <tr class="bg-white border-b">
                  <th colspan="2" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                      Loading...
                  </th>
              </tr>
              </tfoot>
          </table>
      </div>
      <div class="flex items-center">
          <Paginate :data="paginate" @changePage="changePage" />
      </div>
      <div class="flex items-center">
          <span v-if="minValue">Minimum: {{ minValue }} {{ toCurrency }}</span>,
          <span v-if="maxValue">Maximum: {{ maxValue }} {{ toCurrency }}</span>
      </div>
      <div class="flex items-center">
          <span v-if="avgValue">Average: {{ avgValue }} {{ toCurrency }}</span>
      </div>
  </div>
</template>
