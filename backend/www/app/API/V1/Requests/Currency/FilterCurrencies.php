<?php

namespace App\API\V1\Requests\Currency;

use App\API\V1\Requests\FormRequest;
use App\API\V1\Services\CurrenciesServices;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class FilterCurrencies extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'from_currency' => request()->fromCurrency,
            'to_currency' => request()->toCurrency,
        ]);
    }

    public function rules()
    {
        return [
            'from_currency' => ['required', Rule::in([CurrenciesServices::getBaseCurrency()])],
            'to_currency' => ['required', Rule::in(CurrenciesServices::getCurrencyKeys())],
            'order' => ['required', Rule::in('asc', 'desc'),],
            'page' => ['required', 'integer','min:1'],
        ];
    }

    /**
     * @return array
     */
    public function attributes()
    {
        return [
            'order_by' => 'Order',
            'page' => 'Page',
            'from_currency' => 'From Currency',
            'to_currency' => 'To Currency',
        ];
    }
}
