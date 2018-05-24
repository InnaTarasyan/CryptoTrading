<?php

use Illuminate\Database\Seeder;
use App\TradingPair;

class TradingPairSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(TradingPair::get()->count() == 0) {
            TradingPair::create([
                'coin' => 'BTC',
                'trading_pair' => 'BITFINEX:BTCUSD'
            ]);
            TradingPair::create([
                'coin' => 'ETH',
                'trading_pair' => 'NYSE:ETH'
            ]);
            TradingPair::create([
                'coin' => 'XRP',
                'trading_pair' => 'KRAKEN:XRPUSD'
            ]);
            TradingPair::create([
                'coin' => 'BCH',
                'trading_pair' => 'NYSE:BCH'
            ]);
            TradingPair::create([
                'coin' => 'LTC',
                'trading_pair' => 'NYSE:LTC'
            ]);
            TradingPair::create([
                'coin' => 'EOS',
                'trading_pair' => 'NYSE:EOS'
            ]);
            TradingPair::create([
                'coin' => 'ADA',
                'trading_pair' => 'CHXEUR:ADA'
            ]);
            TradingPair::create([
                'coin' => 'XLM',
                'trading_pair' => 'LSE:XLM'
            ]);
            TradingPair::create([
                'coin' => 'NEO',
                'trading_pair' => 'NASDAQ:NEO'
            ]);
            TradingPair::create([
                'coin' => 'XMR',
                'trading_pair' => 'OMXSTO:XMR'

            ]);
            TradingPair::create([
                'coin' => 'DASH',
                'trading_pair' => 'TSXV:DASH'
            ]);
            TradingPair::create([
                'coin' => 'TRX',
                'trading_pair' => 'AMEX:TRX'
            ]);
            TradingPair::create([
                'coin' => 'USDT',
                'trading_pair' => 'KRAKEN:USDTUSD'
            ]);
            TradingPair::create([
                'coin' => 'XEM',
                'trading_pair' => 'TSX:XEM'
            ]);
            TradingPair::create([
                'coin' => 'VEN',
                'trading_pair' => 'LSE:VEN'
            ]);
            TradingPair::create([
                'coin' => 'ETC',
                'trading_pair' => 'KRAKEN:ETCUSD'
            ]);
            TradingPair::create([
                'coin' => 'BNB',
                'trading_pair' => 'FWB:BNB'
            ]);
            TradingPair::create([
                'coin' => 'QTUM',
                'trading_pair' => 'BINANCE:QTUMBTC'
            ]);
            TradingPair::create([
                'coin' => 'XVG',
                'trading_pair' => 'BITFINEX:XVGBTC'
            ]);
            TradingPair::create([
                'coin' => 'OMG',
                'trading_pair' => 'LSE:OMG'
            ]);
            TradingPair::create([
                'coin' => 'LSK',
                'trading_pair' => 'BINANCE:LSKBTC'
            ]);
            TradingPair::create([
                'coin' => 'ICX',
                'trading_pair' => 'BITHUMB:ICXKRW'
            ]);
            TradingPair::create([
                'coin' => 'BTG',
                'trading_pair' => 'AMEX:BTG'
            ]);
            TradingPair::create([
                'coin' => 'ZEC',
                'trading_pair' => 'KRAKEN:ZECUSD'
            ]);
            TradingPair::create([
                'coin' => 'NANO',
                'trading_pair' => 'NASDAQ:NANO'
            ]);
            TradingPair::create([
                'coin' => 'BTM',
                'trading_pair' => 'GPW:BTM'
            ]);
            TradingPair::create([
                'coin' => 'STEEM',
                'trading_pair' => 'BINANCE:STEEMBTC'
            ]);
            TradingPair::create([
                'coin' => 'WAN',
                'trading_pair' => 'BINANCE:WANBTC'
            ]);
            TradingPair::create([
                'coin' => 'BCN',
                'trading_pair' => 'LSE:BCN'
            ]);
            TradingPair::create([
                'coin' => 'PPT',
                'trading_pair' => 'ASX:PPT'
            ]);
            TradingPair::create([
                'coin' => 'DGD',
                'trading_pair' => 'FWB:DGD'
            ]);
            TradingPair::create([
                'coin' => 'SC',
                'trading_pair' => 'NYSE:SC'
            ]);
            TradingPair::create([
                'coin' => 'BTS',
                'trading_pair' => 'NYSE:BTS'
            ]);
            TradingPair::create([
                'coin' => 'STRAT',
                'trading_pair' => 'BINANCE:STRATBTC'
            ]);
            TradingPair::create([
                'coin' => 'DOGE',
                'trading_pair' => 'BITTREX:DOGEBTC'
            ]);
            TradingPair::create([
                'coin' => 'DCR',
                'trading_pair' => 'GPW:DCR'
            ]);
            TradingPair::create([
                'coin' => 'WAVES',
                'trading_pair' => 'BINANCE:WAVESBTC'
            ]);
            TradingPair::create([
                'coin' => 'BCD',
                'trading_pair' => 'AMEX:BCD'
            ]);
            TradingPair::create([
                'coin' => 'MKR',
                'trading_pair' => 'TSXV:MKR'
            ]);
            TradingPair::create([
                'coin' => 'AE',
                'trading_pair' => 'AMEX:AE'
            ]);
            TradingPair::create([
                'coin' => 'ZIL',
                'trading_pair' => 'BINANCE:ZILBTC'
            ]);
            TradingPair::create([
                'coin' => 'SNT',
                'trading_pair' => 'LSE:SNT'
            ]);
            TradingPair::create([
                'coin' => 'ZRX',
                'trading_pair' => 'BINANCE:ZRXBTC'
            ]);
            TradingPair::create([
                'coin' => 'KMD',
                'trading_pair' => 'ASX:KMD'
            ]);
            TradingPair::create([
                'coin' => 'REP',
                'trading_pair' => 'BME:REP'
            ]);
            TradingPair::create([
                'coin' => 'LRC',
                'trading_pair' => 'FWB:LRC'
            ]);
            TradingPair::create([
                'coin' => 'AION',
                'trading_pair' => 'BINANCE:AIONBTC'
            ]);
            TradingPair::create([
                'coin' => 'ELF',
                'trading_pair' => 'NYSE:ELF'
            ]);
            TradingPair::create([
                'coin' => 'KCS',
                'trading_pair' => 'XETR:KSC'
            ]);
            TradingPair::create([
                'coin' => 'ARDR',
                'trading_pair' => 'BITTREX:ARDRBTC'
            ]);
            TradingPair::create([
                'coin' => 'IOST',
                'trading_pair' => 'BINANCE:IOSTBTC'
            ]);
            TradingPair::create([
                'coin' => 'ARK',
                'trading_pair' => 'BINANCE:ARKBTC'
            ]);
            TradingPair::create([
                'coin' => 'HSR',
                'trading_pair' => 'BITHUMB:HSRKRW'
            ]);
            TradingPair::create([
                'coin' => 'WTC',
                'trading_pair' => 'ASX:WTC'
            ]);
            TradingPair::create([
                'coin' => 'PIVX',
                'trading_pair' => 'BITTREX:PIVXBTC'
            ]);
            TradingPair::create([
                'coin' => 'GNT',
                'trading_pair' => 'NYSE:GNT'
            ]);
            TradingPair::create([
                'coin' => 'DGB',
                'trading_pair' => 'EURONEXT:DGB'
            ]);
            TradingPair::create([
                'coin' => 'CNX',
                'trading_pair' => 'NYSE:CNX'
            ]);
            TradingPair::create([
                'coin' => 'BAT',
                'trading_pair' => 'ASX:BAT'
            ]);
            TradingPair::create([
                'coin' => 'MONA',
                'trading_pair' => 'BITTREX:MONABTC'
            ]);
            TradingPair::create([
                'coin' => 'QASH',
                'trading_pair' => 'BITFINEX:QSHUSD'
            ]);
            TradingPair::create([
                'coin' => 'VERI',
                'trading_pair' => 'NASDAQ:VERI'
            ]);
            TradingPair::create([
                'coin' => 'FCT',
                'trading_pair' => 'MIL:FCT'
            ]);
            TradingPair::create([
                'coin' => 'NAS',
                'trading_pair' => 'LSE:NAS'
            ]);
            TradingPair::create([
                'coin' => 'ELA',
                'trading_pair' => 'LSE:ELA'
            ]);
            TradingPair::create([
                'coin' => 'GAS',
                'trading_pair' => 'BME:GAS'
            ]);
            TradingPair::create([
                'coin' => 'SUB',
                'trading_pair' => 'AMEX:SUB'
            ]);
            TradingPair::create([
                'coin' => 'ETHOS',
                'trading_pair' => 'BITHUMB:ETHOSKRW'
            ]);
            TradingPair::create([
                'coin' => 'GXS',
                'trading_pair' => 'TSXV:GXS'
            ]);
            TradingPair::create([
                'coin' => 'XIN',
                'trading_pair' => 'NYSE:XIN'
            ]);
            TradingPair::create([
                'coin' => 'SYS',
                'trading_pair' => 'LSE:SYS'
            ]);
            TradingPair::create([
                'coin' => 'FUN',
                'trading_pair' => 'NYSE:FUN'
            ]);
            TradingPair::create([
                'coin' => 'KNC',
                'trading_pair' => 'BITFINEX:KNCBTC'
            ]);
            TradingPair::create([
                'coin' => 'NXT',
                'trading_pair' => 'LSE:NXT'
            ]);
            TradingPair::create([
                'coin' => 'R',
                'trading_pair' => 'NYSE:R'
            ]);
            TradingPair::create([
                'coin' => 'GBYTE',
                'trading_pair' => 'BITTREX:GBYTEBTC'
            ]);
            TradingPair::create([
                'coin' => 'RDD',
                'trading_pair' => 'BITTREX:RDDBTC'
            ]);
            TradingPair::create([
                'coin' => 'XZC',
                'trading_pair' => 'BINANCE:XZCBTC'
            ]);
            TradingPair::create([
                'coin' => 'SALT',
                'trading_pair' => 'NYSE:SALT'
            ]);
            TradingPair::create([
                'coin' => 'SKY',
                'trading_pair' => 'AMEX:SKY'
            ]);
            TradingPair::create([
                'coin' => 'MAID',
                'trading_pair' => 'POLONIEX:MAIDBTC'
            ]);
            TradingPair::create([
                'coin' => 'NCASH',
                'trading_pair' => 'BINANCE:NCASHBTC'
            ]);
            TradingPair::create([
                'coin' => 'LINK',
                'trading_pair' => 'BIST:LINK'
            ]);
            TradingPair::create([
                'coin' => 'STORM',
                'trading_pair' => 'BINANCE:STORMBTC'
            ]);
            TradingPair::create([
                'coin' => 'BNT',
                'trading_pair' => 'BINANCE:BNTBTC'
            ]);
            TradingPair::create([
                'coin' => 'POWR',
                'trading_pair' => 'IDX:POWR'
            ]);
            TradingPair::create([
                'coin' => 'ENG',
                'trading_pair' => 'BME:ENG'
            ]);
            TradingPair::create([
                'coin' => 'WAX',
                'trading_pair' => 'ASX:WAX'
            ]);
            TradingPair::create([
                'coin' => 'REQ',
                'trading_pair' => 'BITFINEX:REQBTC'
            ]);
            TradingPair::create([
                'coin' => 'PART',
                'trading_pair' => 'BITTREX:PARTBTC'
            ]);
            TradingPair::create([
                'coin' => 'NEBL',
                'trading_pair' => 'BINANCE:NEBLBTC'
            ]);
            TradingPair::create([
                'coin' => 'NEBL',
                'trading_pair' => 'BINANCE:NEBLBTC'
            ]);
            TradingPair::create([
                'coin' => 'STORJ',
                'trading_pair' => 'BINANCE:NEBLBTC'
            ]);
            TradingPair::create([
                'coin' => 'DENT',
                'trading_pair' => 'NASDAQ:XRAY'
            ]);
            TradingPair::create([
                'coin' => 'FSN',
                'trading_pair' => 'NASDAQ:FSNN'
            ]);
            TradingPair::create([
                'coin' => 'PAY',
                'trading_pair' => 'NYSE:PAY'
            ]);
            TradingPair::create([
                'coin' => 'DCN',
                'trading_pair' => 'ASX:DCN'
            ]);
            TradingPair::create([
                'coin' => 'EMC',
                'trading_pair' => 'TSXV:EMC'
            ]);
            TradingPair::create([
                'coin' => 'NXS',
                'trading_pair' => 'SXV:NXS'
            ]);
            TradingPair::create([
                'coin' => 'CND',
                'trading_pair' => 'ASX:CND'
            ]);
            TradingPair::create([
                'coin' => 'POA',
                'trading_pair' => 'BINANCE:POABTC'
            ]);
            TradingPair::create([
                'coin' => 'ZEN',
                'trading_pair' => 'NYSE:ZEN'
            ]);
            TradingPair::create([
                'coin' => 'ICN',
                'trading_pair' => 'ASX:ICN'
            ]);
            TradingPair::create([
                'coin' => 'MAN',
                'trading_pair' => 'NYSE:MAN'
            ]);
            TradingPair::create([
                'coin' => 'HPB',
                'trading_pair' => 'XETR:HPBK'
            ]);
            TradingPair::create([
                'coin' => 'ACT',
                'trading_pair' => 'NASDAQ:ACT'
            ]);
            TradingPair::create([
                'coin' => 'GNX',
                'trading_pair' => 'ASX:GNX'
            ]);
            TradingPair::create([
                'coin' => 'VTC',
                'trading_pair' => 'LSE:VTC'
            ]);
            TradingPair::create([
                'coin' => 'CVC',
                'trading_pair' => 'ASX:CVC'
            ]);
            TradingPair::create([
                'coin' => 'KIN',
                'trading_pair' => 'NASDAQ:KIN'
            ]);
            TradingPair::create([
                'coin' => 'POLY',
                'trading_pair' => 'MOEX:POLY'
            ]);
            TradingPair::create([
                'coin' => 'MANA',
                'trading_pair' => 'NSE:MANAPPURAM'
            ]);
            TradingPair::create([
                'coin' => 'NULS',
                'trading_pair' => 'BINANCE:NULSBTC'
            ]);
            TradingPair::create([
                'coin' => 'BOS',
                'trading_pair' => 'TSX:BOS'
            ]);
            TradingPair::create([
                'coin' => 'GNO',
                'trading_pair' => 'KRAKEN:GNOEUR'
            ]);
        }
    }
}
