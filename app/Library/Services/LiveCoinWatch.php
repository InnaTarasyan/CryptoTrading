<?php

namespace App\Library\Services;
use App\Models\LiveCoinWatch as LiveCoinWatchModel;
use App\Models\LoveCoinHistory;

class LiveCoinWatch
{
    public function handle()
    {
       // $this->getCoins();
        $this->getHistory();
    }
    public function getCoins()
    {
        $data = json_encode(array('currency' => 'USD', 'sort' => 'rank', 'order' => 'ascending', 'offset' => 0, 'limit' => 2500,'meta' => false));
        $context_options = array (
            'http' => array (
                'method' => 'POST',
                'header' => "Content-type: application/json\r\n"
                    . "x-api-key: ".env('LIVE') . "\r\n",
                'content' => $data
            )
        );
        $context = stream_context_create($context_options);
        $fp = fopen('https://api.livecoinwatch.com/coins/list', 'r', false, $context);
        $data = json_decode(stream_get_contents($fp), true);
        foreach ($data as $datum) {
            LiveCoinWatchModel::updateOrCreate(['code' => $datum['code']], [
                'code' => $datum['code'],
                'rate' => $datum['rate'],
                'volume' => $datum['volume'],
                'cap'    => $datum['cap'],
                'delta' => json_encode($datum['delta'], true)
            ]);
        }
    }

    public function getHistory()
    {
       $coins = LiveCoinWatchModel::all();
       foreach ($coins as $coin) {
           $data = json_encode(array('currency' => 'USD', 'code' => $coin->code, 'start' => 1617035100000, 'end' => 1617035400000, 'meta' => true));
           $context_options = array (
               'http' => array (
                   'method' => 'POST',
                   'header' => "Content-type: application/json\r\n"
                       . "x-api-key: ".env('LIVE') . "\r\n",
                   'content' => $data
               )
           );
           $context = stream_context_create($context_options);
           $fp = fopen('https://api.livecoinwatch.com/coins/single/history', 'r', false, $context);
           $datum = json_decode(stream_get_contents($fp), true);

           LoveCoinHistory::updateOrCreate(['code' => $datum['code']], [
               'code' => $datum['code'],
               'name' => $datum['name'],
               'symbol' => array_key_exists('symbol', $datum) ? $datum['symbol'] : null,
               'rank'   => $datum['rank'],
               'age'    => $datum['age'],
               'color'  => $datum['color'],
               'png32'  => $datum['png32'],
               'png64'  => $datum['png64'],
               'webp32' => $datum['webp32'],
               'webp64' => json_encode($datum['webp64'], true),
               'exchanges' => $datum['exchanges'],
               'markets' => $datum['markets'],
               'pairs' => $datum['pairs'],
               'allTimeHighUSD' => $datum['allTimeHighUSD'],
               'circulatingSupply' => $datum['circulatingSupply'],
               'totalSupply' => $datum['totalSupply'],
               'maxSupply' => $datum['maxSupply'],
               'categories' => json_encode($datum['categories'], true),
               'history' => json_encode('history', true),
           ]);
       }
    }
}