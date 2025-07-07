<?php

namespace App\Http\Controllers\CoinGecko;

use App\Http\Controllers\Controller;
use App\Models\CoinGecko\CoinGeckoCoin;
use Yajra\DataTables\Facades\DataTables as Datatables;

class MarketsController extends Controller
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('coingecko.markets');
    }

    public function getData()
    {
        return Datatables::of( CoinGeckoCoin::join('coin_gecko_markets',
            'coin_gecko_coins.api_id', '=', 'coin_gecko_markets.api_id')->get())
            ->editColumn('name', function ($item){
                return "<span style='font-size: 16px;'>
                           <input type='hidden' class='id' value='".$item->api_id."'/>
                           <p class='success'>".$item->symbol ."</p>
                        </span>";

            })
            ->editColumn('image', function ($image) {
                return '<img src="'.$image->image.'" height=50 width=50 class="previewable-img">';
            })
            ->editColumn('market_cap', function ($item) {
                return "<p class='success'>".number_format((float)$item->market_cap, 2, ',', ' ')."</p>";
            })
            ->editColumn('current_price', function ($item) {
                return "<p class='danger'>".number_format((float)$item->current_price, 2, ',', ' ')."</p>";
            })
            ->editColumn('circulatingSupply', function ($item) {
                return "<p class='warning'>".number_format((float)$item->circulatingSupply, 2, ',', ' ')."</p>";
            })
            ->editColumn('fully_diluted_valuation', function ($item) {
                return number_format((float)$item->fully_diluted_valuation, 2, ',', ' ');
            })
            ->editColumn('price_change_percentage_24h', function ($item) {
                return number_format((float)$item->price_change_percentage_24h, 2, ',', ' ');
            })
            ->editColumn('total_volume', function ($item) {
                return number_format((float)$item->total_volume, 2, ',', ' ');
            })
            ->editColumn('high_24h', function ($item) {
                return number_format((float)$item->high_24h, 2, ',', ' ');
            })
            ->editColumn('low_24h', function ($item) {
                return number_format((float)$item->low_24h, 2, ',', ' ');
            })
            ->editColumn('price_change_24h', function ($item) {
                return number_format((float)$item->price_change_24h, 2, ',', ' ');
            })
            ->editColumn('circulating_supply', function ($item) {
                return "<p class='danger'>".number_format((float)$item->circulating_supply, 2, ',', ' ')."</p>";
            })
            ->editColumn('market_cap_change_24h', function ($item) {
                return "<p class='warning'>".number_format((float)$item->market_cap_change_24h, 2, ',', ' ')."</p>";
            })
            ->editColumn('market_cap_change_percentage_24h', function ($item) {
                return "<p class='success'>".number_format((float)$item->market_cap_change_percentage_24h, 2, ',', ' ')."</p>";
            })
            ->editColumn('total_supply', function ($item) {
                return number_format((float)$item->total_supply, 2, ',', ' ');
            })
            ->editColumn('max_supply', function ($item) {
                return number_format((float)$item->max_supply, 2, ',', ' ');
            })
            ->editColumn('ath_change_percentage', function ($item) {
                return number_format((float)$item->ath_change_percentage, 2, ',', ' ');
            })
            ->editColumn('atl_change_percentage', function ($item) {
                return number_format((float)$item->atl_change_percentage, 2, ',', ' ');
            })
            ->editColumn('ath', function ($item) {
                return number_format((float)$item->ath, 2, ',', ' ');
            })
            ->editColumn('atl', function ($item) {
                return number_format((float)$item->atl, 2, ',', ' ');
            })
            ->editColumn('roi', function ($item) {
                if($item->roi === 'null' || !isset($item->roi) || $item->roi === null) {
                    return ' - ';
                }

                $json = json_decode($item->roi, true);
                if (!$json || !is_array($json)) {
                    return ' - ';
                }

                $labels = [
                    'times' => 'Times',
                    'currency' => 'Currency',
                    'percentage' => 'Percentage',
                ];
                $order = ['times', 'currency', 'percentage'];
                $parts = [];
                foreach ($order as $key) {
                    if (isset($json[$key]) && $json[$key] !== null) {
                        $value = $json[$key];
                        if ($key === 'currency') {
                            $currency = strtolower($value);
                            $iconHtml = '';
                            // If the currency matches the coin's symbol, use the coin's image
                            if (strtolower($item->symbol) === $currency && !empty($item->image)) {
                                $iconHtml = '<img src="' . $item->image . '" alt="' . htmlspecialchars($item->symbol) . ' icon" style="width:16px;height:16px;vertical-align:middle;margin-right:3px;border-radius:50%;box-shadow:0 1px 2px #eee;">';
                            } else {
                                // For common fiats, use flagcdn or a generic icon
                                $fiatFlags = [
                                    'usd' => 'us', 'eur' => 'eu', 'gbp' => 'gb', 'jpy' => 'jp', 'cny' => 'cn',
                                    'rub' => 'ru', 'aud' => 'au', 'cad' => 'ca', 'chf' => 'ch', 'inr' => 'in',
                                ];
                                if (isset($fiatFlags[$currency])) {
                                    $flagCode = $fiatFlags[$currency];
                                    $iconHtml = '<img src="https://flagcdn.com/16x12/' . $flagCode . '.png" alt="' . strtoupper($currency) . ' flag" style="width:16px;height:12px;vertical-align:middle;margin-right:3px;border-radius:2px;">';
                                } else {
                                    // fallback generic icon
                                    $iconHtml = '<span style="font-size:1em;vertical-align:middle;margin-right:3px;">💱</span>';
                                }
                            }
                            $value = $iconHtml . '$' . number_format((float)$value, 2);
                        } elseif ($key === 'percentage') {
                            $value = number_format((float)$value * 100, 2) . '%';
                        } elseif ($key === 'times') {
                            $value = number_format((float)$value, 2) . 'x';
                        }
                        $parts[] = "<span class='roi-label'>{$labels[$key]}:</span> <span class='roi-value'>{$value}</span>";
                    }
                }
                if (empty($parts)) {
                    return ' - ';
                }
                return '<div class="roi-compact">' . implode('  ', $parts) . '</div>';
            })
            ->editColumn('ath_date', function ($item) {
                if (empty($item->ath_date)) return ' - ';
                $date = \Carbon\Carbon::parse($item->ath_date);
                $now = \Carbon\Carbon::now();
                if ($date->isToday()) {
                    $label = 'Today';
                } elseif ($date->isYesterday()) {
                    $label = 'Yesterday';
                } else {
                    $label = $date->format('d M Y');
                }
                $time = $date->format('H:i');
                return '<span style="white-space:nowrap;"><span style="font-size:1em;margin-right:3px;vertical-align:middle;">📅</span> ' . $label . ', ' . $time . '</span>';
            })
            ->editColumn('last_updated', function ($item) {
                if (empty($item->last_updated)) return ' - ';
                $date = \Carbon\Carbon::parse($item->last_updated);
                $now = \Carbon\Carbon::now();
                if ($date->isToday()) {
                    $label = 'Today';
                } elseif ($date->isYesterday()) {
                    $label = 'Yesterday';
                } else {
                    $label = $date->format('d M Y');
                }
                $time = $date->format('H:i');
                return '<span style="white-space:nowrap;"><span style="font-size:1em;margin-right:3px;vertical-align:middle;">⏰</span> ' . $label . ', ' . $time . '</span>';
            })
            ->rawColumns([
                'name',
                'market_cap',
                'current_price',
                'circulatingSupply',
               // 'roi',
                'circulating_supply',
                'market_cap_change_24h',
                'market_cap_change_percentage_24h',
            ])
            ->make(true);
    }
}