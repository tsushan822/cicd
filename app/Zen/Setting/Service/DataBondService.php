<?php

namespace App\Zen\Setting\Service;

use GuzzleHttp\Client;

class DataBondService
{
    protected $bearerToken;

    public static function dataBondLogin()
    {
        $client = new Client();
        $res = $client -> post('https://gateway.databond.biz/prodapi/login', [
            'headers' => [
                'Content-Type' => 'application/json',
                'ReturnFormat' => 'json',
            ],
            'body' => json_encode([
                'email' => config('rate.databond.email'),
                'password' => config('rate.databond.password'),
                'token' => config('rate.databond.token'),
            ])
        ]);

        return $res -> getBody() -> getContents();
    }

    public function dataBondLogout()
    {
        $client = new Client();
        $res = $client -> post('https://gateway.databond.biz/prodapi/logout', [
            'headers' => self ::getHeaderArrayParam(),
            'body' => json_encode([
                'email' => config('rate.databond.email'),
            ])
        ]);

        return $res -> getBody() -> getContents();
    }

    public function addDataBondRateClient(string $clientId, string $sourceId)
    {
        $client = new Client();
        $res = $client -> post('https://gateway.databond.biz/prodapi/api/rates/updateCollection', [
            'headers' => self ::getHeaderArrayParam(),
            'body' => json_encode([
                'client_id' => $clientId,
                'sourceid' => $sourceId,
            ])
        ]);

        return $res -> getBody() -> getContents();
    }

    public function getDataBondLatestRate(string $clientId = "5", string $date = "9999-12-31")
    {
        $client = new Client();
        $res = $client -> put('https://gateway.databond.biz/prodapi/api/rates/latestRates', [
            'headers' => self ::getHeaderArrayParam(),
            'body' => json_encode([
                'client_id' => $clientId,
                'date' => $date,
            ])
        ]);

        return $res -> getBody();
    }

    public function getDataBondRateSources()
    {
        $client = new Client();
        $res = $client -> get('https://gateway.databond.biz/prodapi/api/rates/rateSources', [
            'headers' => self ::getHeaderArrayParam()
        ]);

        return $res -> getBody();
    }

    public function getAllClientData()
    {
        $client = new Client();
        $res = $client -> get('https://gateway.databond.biz/prodapi/api/rates/rateCollections/1/all', [
            'headers' => self ::getHeaderArrayParam(),
        ]);

        return $res -> getBody() -> getContents();
    }

    /**
     * @return array
     */
    private function getHeaderArrayParam(): array
    {
        $arrayHeader = [
            'Content-Type' => 'application/json',
            'ReturnFormat' => 'json',
            'Authorization' => 'Bearer ' . $this -> bearerToken,
        ];
        return $arrayHeader;
    }

    /**
     * @param mixed $bearerToken
     * @return DataBondService
     */
    public function setBearerToken($bearerToken)
    {
        $this -> bearerToken = $bearerToken;
        return $this;
    }
}