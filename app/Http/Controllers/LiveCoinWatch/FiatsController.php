<?php

namespace App\Http\Controllers\LiveCoinWatch;

use App\Http\Controllers\Controller;
use App\Models\LiveCoinWatch\Fiats;
use Yajra\DataTables\Facades\DataTables as Datatables;

class FiatsController extends Controller
{
    /**
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('livecoinwatch.fiats');
    }

    public function getData()
    {
        return Datatables::of(Fiats::query()->where('countries', '<>', null)->get())
            ->editColumn('name', function ($item){
                return "<span style='font-size: 16px;'>
                           <input type='hidden' class='id' value='".$item->code."'/>
                           <p class='success'>$item->name</p>
                        </span>";

            })
            ->editColumn('countries', function ($item) {
                if(empty($item->countries)) {
                    return '';
                }
                $countriesList = json_decode($item->countries, true);
                $countryNames = config('countries');
                // Alpha-3 to Alpha-2 mapping for common countries
                $alpha3To2 = [
                    'USA' => 'us', 'DEU' => 'de', 'FRA' => 'fr', 'GBR' => 'gb', 'CAN' => 'ca', 'AUS' => 'au',
                    'JPN' => 'jp', 'CHN' => 'cn', 'RUS' => 'ru', 'IND' => 'in', 'BRA' => 'br', 'ZAF' => 'za',
                    'KOR' => 'kr', 'ITA' => 'it', 'ESP' => 'es', 'MEX' => 'mx', 'TUR' => 'tr', 'NLD' => 'nl',
                    'CHE' => 'ch', 'SWE' => 'se', 'ARG' => 'ar', 'SAU' => 'sa', 'SGP' => 'sg', 'IRL' => 'ie',
                    'NZL' => 'nz', 'NOR' => 'no', 'POL' => 'pl', 'BEL' => 'be', 'AUT' => 'at', 'THA' => 'th',
                    'IDN' => 'id', 'EGY' => 'eg', 'UKR' => 'ua', 'CZE' => 'cz', 'GRC' => 'gr', 'HUN' => 'hu',
                    'DNK' => 'dk', 'FIN' => 'fi', 'PRT' => 'pt', 'ISR' => 'il', 'CHL' => 'cl', 'COL' => 'co',
                    'PHL' => 'ph', 'ROU' => 'ro', 'MYS' => 'my', 'PAK' => 'pk', 'VNM' => 'vn', 'BGD' => 'bd',
                    'SVK' => 'sk', 'HRV' => 'hr', 'LUX' => 'lu', 'SVN' => 'si', 'LTU' => 'lt', 'LVA' => 'lv',
                    'EST' => 'ee', 'ISL' => 'is', 'CYP' => 'cy', 'MLT' => 'mt', 'MAR' => 'ma', 'TUN' => 'tn',
                    'ARE' => 'ae', 'QAT' => 'qa', 'KWT' => 'kw', 'OMN' => 'om', 'BHR' => 'bh', 'JOR' => 'jo',
                    'LBN' => 'lb', 'GEO' => 'ge', 'ARM' => 'am', 'AZE' => 'az', 'KAZ' => 'kz', 'UZB' => 'uz',
                    'TJK' => 'tj', 'KGZ' => 'kg', 'MNG' => 'mn', 'AFG' => 'af', 'IRN' => 'ir', 'IRQ' => 'iq',
                    'SYR' => 'sy', 'LKA' => 'lk', 'MMR' => 'mm', 'KHM' => 'kh', 'LAO' => 'la', 'NPL' => 'np',
                    'BTN' => 'bt', 'MDV' => 'mv', 'BRN' => 'bn', 'TLS' => 'tl', 'SGP' => 'sg', 'IDN' => 'id',
                    'MYS' => 'my', 'THA' => 'th', 'VNM' => 'vn', 'KOR' => 'kr', 'PRK' => 'kp', 'MYS' => 'my',
                    'TWN' => 'tw', 'HKG' => 'hk', 'MAC' => 'mo', 'MYS' => 'my', 'SGP' => 'sg', 'IDN' => 'id',
                    'PHL' => 'ph', 'VNM' => 'vn', 'KHM' => 'kh', 'LAO' => 'la', 'THA' => 'th', 'MMR' => 'mm',
                    'BGD' => 'bd', 'NPL' => 'np', 'BTN' => 'bt', 'MDV' => 'mv',
                ];
                $str =  '<ul>';
                foreach($countriesList as $countryCode) {
                    $name = $countryNames[$countryCode] ?? $countryCode;
                    $flagCode = $alpha3To2[$countryCode] ?? null;
                    $flagImg = $flagCode
                        ? "<img src='https://flagcdn.com/24x18/{$flagCode}.png' style='margin-right:6px;vertical-align:middle;' alt='{$name} flag'/>"
                        : '';
                    $str.= '<li>'.$flagImg.$name.'</li>';
                }
                $str.=  '</ul>';
                return $str;
            })
            ->editColumn('flag', function ($item){
                $countryNames = config('countries');
                return "<p class='danger'>".($countryNames[$item->flag] ?? $item->flag)."</p>";

            })
            ->rawColumns(['countries', 'name', 'flag'])
            ->make(true);
    }

}
