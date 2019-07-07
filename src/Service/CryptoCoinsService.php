<?php

namespace App\Service;

class CryptoCoinsService
{
    /**
     * CryptoCoinService constructor.
     */
    public function __construct()
    {
        $this->url = 'https://api.coinmarketcap.com/v1/ticker/';
    }

    public function getCryptoCoins()
    {
        $json = file_get_contents($this->url);

        $cryptoCoins = json_decode($json, true);

        return $cryptoCoins;
    }
}
