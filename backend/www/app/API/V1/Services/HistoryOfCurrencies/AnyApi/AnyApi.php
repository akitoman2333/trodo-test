<?php

namespace App\API\V1\Services\HistoryOfCurrencies\AnyApi;
use App\API\V1\Services\CurrenciesServices;
use App\Models\Currency;
use Illuminate\Support\Facades\Http;
use Monolog\Logger;

class AnyApi implements AnyApiInterface
{
    protected $path;

    protected $result = null;

    public function __construct()
    {
        $this->key = env('AnyApi_KEY');
        $this->url = env('AnyApi_URL') . '/exchange/';
    }

    public function getCurrencies(): array
    {
        $data = $this->setPath('rates')->submit();
        return $data->getToDay();
    }

    public function updateCurrencies($data)
    {
        Currency::create(
            [
                'currency' => CurrenciesServices::getBaseCurrency(),
                'rate' => $data
            ]
        );
    }
    public function setCurrencies()
    {
        $this->updateCurrencies($this->getCurrencies());
    }

    /**
     * @param $value
     * @return $this
     */
    public function setPath($value): static
    {
        $this->path = $value;
        return $this;
    }

    public function getToDay(): array
    {
        return collect($this->result['rates'])
            ->filter(
                function(string $value, string $key){
                    return in_array($key, CurrenciesServices::getCurrencyKeys());
                }
            )
            ->toArray();
    }

    public function submit(): static
    {
        $params = [
            'apiKey' => $this->key
        ];

        $response = Http::get($this->url.$this->path, $params);
        $this->result = json_decode($response->body(), true);

        return $this;
    }
}
