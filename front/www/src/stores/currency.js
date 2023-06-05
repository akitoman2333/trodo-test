import {defineStore} from 'pinia';

import {fetchWrapper} from '@/helpers';

const baseUrl = `${import.meta.env.VITE_API_URL}`;

export const useCurrencyStore = defineStore({
    id: 'currency',
    state: () => ({
        paginate: {},
        lastUpdated: null,
        maxValue: null,
        minValue: null,
        baseCurrency: 'EUR',
        currencies: ['USD', 'GBP', 'AUD']
    }),
    actions: {
        async load(to, page = 1, order = 'desc') {

            let query = new URLSearchParams({page, order}).toString();

            const {result} = await fetchWrapper.get(`${baseUrl}/currencies/${this.baseCurrency}/${to}?${query}`);

            this.paginate = result.paginate
            this.lastUpdated = result.last_updated
            this.maxValue = result.max_value
            this.minValue = result.min_value
        },
    }
});