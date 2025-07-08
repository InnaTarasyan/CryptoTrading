<?php

namespace App\Http\Controllers\CoinGecko;

use App\Http\Controllers\Controller;
use App\Models\CoinGecko\CoingeckoExchanges;
use Yajra\DataTables\Facades\DataTables as Datatables;

class ExchangesController extends Controller
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('coingecko.exchanges');
    }

    public function getData()
    {
        return Datatables::of(CoingeckoExchanges::all())
            ->editColumn('name', function ($item){
                return "<span style='font-size: 16px;'>
                           <input type='hidden' class='id' value='".$item->api_id."'/>
                           <p class='success'>".$item->name ."</p>
                        </span>";

            })
            ->editColumn('image', function ($image) {
                return '<img src="'.$image->image.'" height=25 width=25 class="previewable-img">';
            })
            ->editColumn('trade_volume_24h_btc_normalized', function ($item) {
                return "<p class='warning'>".
                    number_format((float)$item->trade_volume_24h_btc_normalized, 2, ',', ' ')."</p>";
            })
            ->editColumn('description', function($item) {
                $desc = $item->description ?? '';
                // Truncate at the last space before 150 chars to avoid cutting words
                if (mb_strlen($desc) > 150) {
                    $truncated = mb_substr($desc, 0, 150);
                    $lastSpace = mb_strrpos($truncated, ' ');
                    if ($lastSpace !== false) {
                        $truncated = mb_substr($truncated, 0, $lastSpace);
                    }
                    $truncated .= '...';
                } else {
                    $truncated = $desc;
                }
                // Use title attribute for tooltip
                return '<span class="desc-truncated" title="'.e($desc).'">'.e($truncated).'</span>';
            })
            ->editColumn('url', function($item) {
                return '<a href="'.$item->url.'">'.$item->url.'</a>';
            })
            ->editColumn('country', function($item) {
                $countryName = isset($item->country) ? $item->country : null;
                if (!$countryName) return ' - ';
                // Simple mapping for common countries (expand as needed)
                $nameToCode = [
                    'United States' => 'us', 'Germany' => 'de', 'France' => 'fr', 'United Kingdom' => 'gb', 'Canada' => 'ca',
                    'Australia' => 'au', 'Japan' => 'jp', 'China' => 'cn', 'Russia' => 'ru', 'India' => 'in', 'Brazil' => 'br',
                    'South Africa' => 'za', 'South Korea' => 'kr', 'Italy' => 'it', 'Spain' => 'es', 'Mexico' => 'mx',
                    'Turkey' => 'tr', 'Netherlands' => 'nl', 'Switzerland' => 'ch', 'Sweden' => 'se', 'Argentina' => 'ar',
                    'Saudi Arabia' => 'sa', 'Singapore' => 'sg', 'Ireland' => 'ie', 'New Zealand' => 'nz', 'Norway' => 'no',
                    'Poland' => 'pl', 'Belgium' => 'be', 'Austria' => 'at', 'Thailand' => 'th', 'Indonesia' => 'id',
                    'Egypt' => 'eg', 'Ukraine' => 'ua', 'Czech Republic' => 'cz', 'Greece' => 'gr', 'Hungary' => 'hu',
                    'Denmark' => 'dk', 'Finland' => 'fi', 'Portugal' => 'pt', 'Israel' => 'il', 'Chile' => 'cl',
                    'Colombia' => 'co', 'Philippines' => 'ph', 'Romania' => 'ro', 'Malaysia' => 'my', 'Pakistan' => 'pk',
                    'Vietnam' => 'vn', 'Bangladesh' => 'bd', 'Slovakia' => 'sk', 'Croatia' => 'hr', 'Luxembourg' => 'lu',
                    'Slovenia' => 'si', 'Lithuania' => 'lt', 'Latvia' => 'lv', 'Estonia' => 'ee', 'Iceland' => 'is',
                    'Cyprus' => 'cy', 'Malta' => 'mt', 'Morocco' => 'ma', 'Tunisia' => 'tn', 'United Arab Emirates' => 'ae',
                    'Qatar' => 'qa', 'Kuwait' => 'kw', 'Oman' => 'om', 'Bahrain' => 'bh', 'Jordan' => 'jo',
                    'Lebanon' => 'lb', 'Georgia' => 'ge', 'Armenia' => 'am', 'Azerbaijan' => 'az', 'Kazakhstan' => 'kz',
                    'Uzbekistan' => 'uz', 'Tajikistan' => 'tj', 'Kyrgyzstan' => 'kg', 'Mongolia' => 'mn', 'Afghanistan' => 'af',
                    'Iran' => 'ir', 'Iraq' => 'iq', 'Syria' => 'sy', 'Sri Lanka' => 'lk', 'Myanmar' => 'mm',
                    'Cambodia' => 'kh', 'Laos' => 'la', 'Nepal' => 'np', 'Bhutan' => 'bt', 'Maldives' => 'mv',
                    'Brunei' => 'bn', 'Timor-Leste' => 'tl', 'Taiwan' => 'tw', 'Hong Kong' => 'hk', 'Macau' => 'mo',
                ];
                $code = $nameToCode[$countryName] ?? null;
                $flagImg = $code ? "<img src='https://flagcdn.com/24x18/{$code}.png' style='margin-right:6px;vertical-align:middle;' alt='{$countryName} flag'/>" : '';
                return $flagImg . $countryName;
            })
            ->editColumn('has_trading_incentive', function($item) {
                return $item->has_trading_incentive ? 'Yes' : 'No';
            })
            ->rawColumns([
                'name',
                'trade_volume_24h_btc_normalized',
                'api_id',
            ])
            ->make(true);
    }

}