<?php

namespace App\Library\Services;

use App\Models\Coindar;
use App\Library\Services\Base\BaseService;

class CoindarService extends  BaseService {

    public function get()
    {
        $url = env('COINDAR_API').'?access_token='.env('COINDAR_TOKEN');
        $response = $this->retrieveData($url, []);
        Coindar::truncate();
        foreach ($response as $data){
            Coindar::create($data);
        }
    }
}