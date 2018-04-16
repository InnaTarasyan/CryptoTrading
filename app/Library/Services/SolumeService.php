<?php

namespace App\Library\Services;
use App\Library\Services\Base\BaseService;
use App\Solume;

class SolumeService extends BaseService{

    public function get(){

        $params = [
            'auth' => config('solume.key')
        ];

        $response = $this->retrieveData(config('solume.url'), $params);

        Solume::truncate();
        foreach ($response as $index => $value){
            Solume::create($value);
        }

    }
}