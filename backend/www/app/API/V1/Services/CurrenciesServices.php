<?php

namespace App\API\V1\Services;

use App\Models\Currency;

class CurrenciesServices
{
    private Currency $model;
    private const BASE_CURRENCY = 'EUR';
    private const CURRENCIES = ['EUR', 'USD', 'GBP', 'AUD'];

    public function __construct(Currency $currency)
    {
        $this->model = $currency;
    }

    public function getCurrencies($filters, $fromCurrency, $toCurrency)
    {
        return [
            'last_updated' => $this->getLastUpdatedCurrencies($fromCurrency),
            'max_value' => $this->getMaxValueToCurrency($fromCurrency, $toCurrency),
            'min_value' => $this->getMinValueToCurrency($fromCurrency, $toCurrency),
            'paginate' => $this->getPaginateCurrencies($fromCurrency, $toCurrency, $filters),
        ];
    }

    protected function getPaginateCurrencies($fromCurrency, $toCurrency, $filters)
    {
        $result = $this->model
            ->where('currency', $fromCurrency)
            ->orderBy('created_at', $filters['order'])
            ->paginate(10, ['*'], 'page', $filters['page']);

        $result->getCollection()->transform(function ($item) use ($toCurrency) {
            $rate = $item->rate;
            $convertedRate = $rate[$toCurrency] ?? null;
            $item->rate = $convertedRate;
            $item->to = $toCurrency;
            return $item;
        });

        return $result;
    }

    protected function getLastUpdatedCurrencies($fromCurrency)
    {
        $result = $this->model->where('currency', $fromCurrency)->orderByDesc('created_at')->first();
        return $result->created_at ?? null;
    }

    protected function getMaxValueToCurrency($fromCurrency, $toCurrency)
    {
        $result = $this->model
            ->where('currency', $fromCurrency)
            ->orderByDesc("rate->{$toCurrency}")
            ->first();
        return $result->rate[$toCurrency] ?? null;
    }

    protected function getMinValueToCurrency($fromCurrency, $toCurrency)
    {
        $result = $this->model
            ->where('currency', $fromCurrency)
            ->orderBy("rate->{$toCurrency}")
            ->first();
        return $result->rate[$toCurrency] ?? null;
    }

    public static function getBaseCurrency(): string
    {
        return self::BASE_CURRENCY;
    }

    public static function getCurrencyKeys(): array
    {
        return self::CURRENCIES;
    }
}
