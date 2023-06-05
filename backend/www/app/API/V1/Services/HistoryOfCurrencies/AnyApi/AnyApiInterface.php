<?php

namespace App\API\V1\Services\HistoryOfCurrencies\AnyApi;

interface AnyApiInterface
{
    public function setPath($value);
    public function getToDay();
    public function getCurrencies();
    public function setCurrencies();
    public function updateCurrencies($data);
    public function submit();
}
