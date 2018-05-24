<?php

use Illuminate\Database\Seeder;
use App\TwitterAccount;

class TwitterAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(TwitterAccount::get()->count() == 0) {
            TwitterAccount::create([
               'coin' => 'BTC',
               'account' => 'Bitcoin'
            ]);
            TwitterAccount::create([
                'coin' => 'XRP',
                'account' => 'Ripple_XRP1'
            ]);
            TwitterAccount::create([
                'coin' => 'LTC',
                'account' => 'ltc'
            ]);
            TwitterAccount::create([
                'coin' => 'BCH',
                'account' => 'BTCNewsUpdates'
            ]);
            TwitterAccount::create([
                'coin' => 'BCH',
                'account' => 'BTCNewsUpdates'
            ]);
            TwitterAccount::create([
                'coin' => 'NEO',
                'account' => 'NEO_council'
            ]);
            TwitterAccount::create([
                'coin' => 'EOS',
                'account' => 'EOS_io'
            ]);
            TwitterAccount::create([
                'coin' => 'ADA',
                'account' => 'ADAcoin_'
            ]);
            TwitterAccount::create([
                'coin' => 'XMR',
                'account' => 'monerocurrency'
            ]);
            TwitterAccount::create([
                'coin' => 'XMR',
                'account' => 'monerocurrency'
            ]);
            TwitterAccount::create([
                'coin' => 'DASH',
                'account' => 'coindash_co'
            ]);
            TwitterAccount::create([
                'coin' => 'TRX',
                'account' => 'coindash_co'
            ]);
            TwitterAccount::create([
                'coin' => 'ETC',
                'account' => 'ETCCooperative'
            ]);
            TwitterAccount::create([
                'coin' => 'QTUM',
                'account' => 'QtumOfficial'
            ]);
            TwitterAccount::create([
                'coin' => 'ICX',
                'account' => 'icx_official'
            ]);
            TwitterAccount::create([
                'coin' => 'BTG',
                'account' => 'bitcoingold'
            ]);
            TwitterAccount::create([
                'coin' => 'NANO',
                'account' => 'nano'
            ]);
            TwitterAccount::create([
                'coin' => 'STEEM',
                'account' => 'steemit'
            ]);
            TwitterAccount::create([
                'coin' => 'WAN',
                'account' => 'steemit'
            ]);
            TwitterAccount::create([
                'coin' => 'BCN',
                'account' => 'Bytecoin_BCN'
            ]);
            TwitterAccount::create([
                'coin' => 'BTCP',
                'account' => 'bitcoinprivate'
            ]);
            TwitterAccount::create([
                'coin' => 'ZIL',
                'account' => 'zilliqatrader'
            ]);
            TwitterAccount::create([
                'coin' => 'ZIL',
                'account' => 'zilliqatrader'
            ]);
        }
    }
}
