<?php

namespace App\Library\Services;

use App\Models\CoinMarketCal\CoinMarketCal;
use App\Models\CoinMarketCal\CoinMarketCalEvents;
use Carbon\Carbon;

class CoinMarketCalService
{
    public function handle()
    {
        $this->coins();
        $this->getEvents();
    }

    protected function coins()
    {
        $params = [];
        $url = 'https://developers.coinmarketcal.com/v1/coins';

        $headers = [
            'Accepts: application/json',
            'x-api-key:'.env('COIN_MARKET_CAL')
        ];

        if($params) {
            $qs = http_build_query($params); // query string encode the parameters
            $request = "{$url}?{$qs}"; // create the request URL
        } else {
            $request = "{$url}"; // create the request URL
        }

        $curl = curl_init(); // Get cURL resource
        // Set cURL options
        curl_setopt_array($curl, array(
            CURLOPT_URL => $request,            // set the request URL
            CURLOPT_HTTPHEADER => $headers,     // set the headers
            CURLOPT_RETURNTRANSFER => 1         // ask for raw response instead of bool
        ));

        $response = curl_exec($curl); // Send the request, save the response
        // print_r(json_decode($response)); // print json decoded response
        curl_close($curl); // Close request

        //  print_r($response);
        $items = json_decode($response);


        foreach ($items->body as $item) {
            CoinMarketCal::updateOrCreate(['symbol' => $item->symbol], [
                'api_id' => $item->id,
                'symbol' => $item->symbol,
                'name'   => $item->name,
                'rank'   => $item->rank,
                'fullname' => $item->fullname
            ]);
        }
    }


    protected function getEvents()
    {
        $params = [];
        $url = 'https://developers.coinmarketcal.com/v1/events';

        $headers = [
            'Accepts: application/json',
            'x-api-key:'.env('COIN_MARKET_CAL')
        ];

        if($params) {
            $qs = http_build_query($params); // query string encode the parameters
            $request = "{$url}?{$qs}"; // create the request URL
        } else {
            $request = "{$url}"; // create the request URL
        }

        $curl = curl_init(); // Get cURL resource
        // Set cURL options
        curl_setopt_array($curl, array(
            CURLOPT_URL => $request,            // set the request URL
            CURLOPT_HTTPHEADER => $headers,     // set the headers
            CURLOPT_RETURNTRANSFER => 1         // ask for raw response instead of bool
        ));

        $response = curl_exec($curl); // Send the request, save the response
        // print_r(json_decode($response)); // print json decoded response
        curl_close($curl); // Close request

        print_r($response);

        $data = json_decode($response);
        print_r($data);


        foreach ($data->body as $item) {
            CoinMarketCalEvents::updateOrCreate(['api_id' => $item->id], [
                'api_id' => $item->id,
                'title'  => json_encode($item->title),
                'coins'  => json_encode($item->coins),
                'date_event' => new Carbon($item->date_event),
                'displayed_date' => $item->displayed_date,
                'can_occur_before' => $item->can_occur_before ?? false,
                'created_date' => new Carbon($item->created_date),
                'categories' => json_encode($item->categories),
                'proof' => $item->proof,
                'source' => $item->source,
            ]);
        }

        // print_r($response);
    }
}