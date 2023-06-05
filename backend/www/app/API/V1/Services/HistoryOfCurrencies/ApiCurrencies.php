<?php

namespace App\API\V1\Services\HistoryOfCurrencies;

use App\API\V1\Services\HistoryOfCurrencies\AnyApi\AnyApi;
use App\API\V1\Services\HistoryOfCurrencies\AnyApi\AnyApiInterface;

class ApiCurrencies
{
    public function api($gateway): ?AnyApiInterface
    {
        switch ($gateway) {
            case 'AnyApi':
                return new AnyApi;
        }

        return null;
    }
}
