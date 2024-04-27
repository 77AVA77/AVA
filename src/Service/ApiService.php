<?php

namespace App\Service;

use GuzzleHttp\Client;

class ApiService
{
    private $client;

    public function __construct(Client $guzzleClient)
    {
        $this->client = $guzzleClient;
    }

    public function getWeatherApi():string
    {
        $options = [
            'appid' => '254aacacec43c9cccc92d4936d8624d9',
            'q' => 'Yerevan',
            'units' => 'current',
            'lang' => 'en'
        ];

        $queryString = http_build_query($options);
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://api.openweathermap.org/data/2.5/weather?' . $queryString,
            CURLOPT_RETURNTRANSFER => true, // Return the response instead of outputting it
        ]);

        $response = curl_exec($curl);

        if ($response === false) {
            $error = curl_error($curl);
            // Handle error
        } else {
            // Handle successful response
            // $response contains the response body
        }

        return json_decode($response);
    }

}