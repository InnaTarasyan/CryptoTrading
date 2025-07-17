<?php

namespace App\Http\Controllers\CoinGecko;

use App\Http\Controllers\Controller;
use App\Models\CoinGecko\DerivativesExchanges;
use Yajra\DataTables\Facades\DataTables as Datatables;

class DerivativesExchangesController extends Controller
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('coingecko.derivatives_exchanges');
    }

    public function getData()
    {

        return Datatables::of(DerivativesExchanges::all())
            ->editColumn('name', function ($item){
                return "<span style='font-size: 16px;'>
                           <input type='hidden' class='id' value='".$item->api_id."'/>
                           <p class='success'>".$item->name ."</p>
                        </span>";

            })
            ->editColumn('description', function ($item) {
                return substr($item->description, 0, 100).' .... ';
            })
            ->editColumn('image', function ($item) {
                return '<img src="'.$item->image.'" height=25 width=25 class="previewable-img" style="object-fit:contain;border-radius:8px;box-shadow:0 1px 4px rgba(0,0,0,0.08);cursor:pointer;">';
            })
            ->editColumn('url', function($item) {
                return '<a href="'.$item->url.'">'.$item->url.'</a>';
            })
            ->editColumn('open_interest_btc', function ($item) {
                return "<p class='success'>".number_format((float)$item->open_interest_btc, 2, ',', ' ')."</p>";
            })
            ->editColumn('trade_volume_24h_btc', function ($item) {
                return "<p class='danger'>".number_format((float)$item->trade_volume_24h_btc, 2, ',', ' ')."</p>";
            })
            ->editColumn('country', function($item) {
                $countryName = isset($item->country) ? $item->country : null;
                if (!$countryName) return ' - ';
                // Simple mapping for common countries (expand as needed)
                $nameToCode = [
                    'Afghanistan' => 'af', 'Åland Islands' => 'ax', 'Albania' => 'al', 'Algeria' => 'dz', 'American Samoa' => 'as',
                    'Andorra' => 'ad', 'Angola' => 'ao', 'Anguilla' => 'ai', 'Antarctica' => 'aq', 'Antigua and Barbuda' => 'ag',
                    'Argentina' => 'ar', 'Armenia' => 'am', 'Aruba' => 'aw', 'Australia' => 'au', 'Austria' => 'at',
                    'Azerbaijan' => 'az', 'Bahamas' => 'bs', 'Bahrain' => 'bh', 'Bangladesh' => 'bd', 'Barbados' => 'bb',
                    'Belarus' => 'by', 'Belgium' => 'be', 'Belize' => 'bz', 'Benin' => 'bj', 'Bermuda' => 'bm',
                    'Bhutan' => 'bt', 'Bolivia' => 'bo', 'Bonaire, Sint Eustatius and Saba' => 'bq', 'Bosnia and Herzegovina' => 'ba', 'Botswana' => 'bw',
                    'Bouvet Island' => 'bv', 'Brazil' => 'br', 'British Indian Ocean Territory' => 'io', 'Brunei Darussalam' => 'bn', 'Bulgaria' => 'bg',
                    'Burkina Faso' => 'bf', 'Burundi' => 'bi', 'Cabo Verde' => 'cv', 'Cambodia' => 'kh', 'Cameroon' => 'cm',
                    'Canada' => 'ca', 'Cayman Islands' => 'ky', 'Central African Republic' => 'cf', 'Chad' => 'td', 'Chile' => 'cl',
                    'China' => 'cn', 'Christmas Island' => 'cx', 'Cocos (Keeling) Islands' => 'cc', 'Colombia' => 'co', 'Comoros' => 'km',
                    'Congo' => 'cg', 'Congo, Democratic Republic of the' => 'cd', 'Cook Islands' => 'ck', 'Costa Rica' => 'cr', 'Côte d\'Ivoire' => 'ci',
                    'Croatia' => 'hr', 'Cuba' => 'cu', 'Curaçao' => 'cw', 'Cyprus' => 'cy', 'Czechia' => 'cz',
                    'Denmark' => 'dk', 'Djibouti' => 'dj', 'Dominica' => 'dm', 'Dominican Republic' => 'do', 'Ecuador' => 'ec',
                    'Egypt' => 'eg', 'El Salvador' => 'sv', 'Equatorial Guinea' => 'gq', 'Eritrea' => 'er', 'Estonia' => 'ee',
                    'Eswatini' => 'sz', 'Ethiopia' => 'et', 'Falkland Islands (Malvinas)' => 'fk', 'Faroe Islands' => 'fo', 'Fiji' => 'fj',
                    'Finland' => 'fi', 'France' => 'fr', 'French Guiana' => 'gf', 'French Polynesia' => 'pf', 'French Southern Territories' => 'tf',
                    'Gabon' => 'ga', 'Gambia' => 'gm', 'Georgia' => 'ge', 'Germany' => 'de', 'Ghana' => 'gh',
                    'Gibraltar' => 'gi', 'Greece' => 'gr', 'Greenland' => 'gl', 'Grenada' => 'gd', 'Guadeloupe' => 'gp',
                    'Guam' => 'gu', 'Guatemala' => 'gt', 'Guernsey' => 'gg', 'Guinea' => 'gn', 'Guinea-Bissau' => 'gw',
                    'Guyana' => 'gy', 'Haiti' => 'ht', 'Heard Island and McDonald Islands' => 'hm', 'Holy See' => 'va', 'Honduras' => 'hn',
                    'Hong Kong' => 'hk', 'Hungary' => 'hu', 'Iceland' => 'is', 'India' => 'in', 'Indonesia' => 'id',
                    'Iran, Islamic Republic of' => 'ir', 'Iraq' => 'iq', 'Ireland' => 'ie', 'Isle of Man' => 'im', 'Israel' => 'il',
                    'Italy' => 'it', 'Jamaica' => 'jm', 'Japan' => 'jp', 'Jersey' => 'je', 'Jordan' => 'jo',
                    'Kazakhstan' => 'kz', 'Kenya' => 'ke', 'Kiribati' => 'ki', 'Korea, Democratic People\'s Republic of' => 'kp', 'Korea, Republic of' => 'kr',
                    'Kuwait' => 'kw', 'Kyrgyzstan' => 'kg', 'Lao People\'s Democratic Republic' => 'la', 'Latvia' => 'lv', 'Lebanon' => 'lb',
                    'Lesotho' => 'ls', 'Liberia' => 'lr', 'Libya' => 'ly', 'Liechtenstein' => 'li', 'Lithuania' => 'lt',
                    'Luxembourg' => 'lu', 'Macao' => 'mo', 'Madagascar' => 'mg', 'Malawi' => 'mw', 'Malaysia' => 'my',
                    'Maldives' => 'mv', 'Mali' => 'ml', 'Malta' => 'mt', 'Marshall Islands' => 'mh', 'Martinique' => 'mq',
                    'Mauritania' => 'mr', 'Mauritius' => 'mu', 'Mayotte' => 'yt', 'Mexico' => 'mx', 'Micronesia, Federated States of' => 'fm',
                    'Moldova, Republic of' => 'md', 'Monaco' => 'mc', 'Mongolia' => 'mn', 'Montenegro' => 'me', 'Montserrat' => 'ms',
                    'Morocco' => 'ma', 'Mozambique' => 'mz', 'Myanmar' => 'mm', 'Namibia' => 'na', 'Nauru' => 'nr',
                    'Nepal' => 'np', 'Netherlands' => 'nl', 'New Caledonia' => 'nc', 'New Zealand' => 'nz', 'Nicaragua' => 'ni',
                    'Niger' => 'ne', 'Nigeria' => 'ng', 'Niue' => 'nu', 'Norfolk Island' => 'nf', 'North Macedonia' => 'mk',
                    'Northern Mariana Islands' => 'mp', 'Norway' => 'no', 'Oman' => 'om', 'Pakistan' => 'pk', 'Palau' => 'pw',
                    'Palestine, State of' => 'ps', 'Panama' => 'pa', 'Papua New Guinea' => 'pg', 'Paraguay' => 'py', 'Peru' => 'pe',
                    'Philippines' => 'ph', 'Pitcairn' => 'pn', 'Poland' => 'pl', 'Portugal' => 'pt', 'Puerto Rico' => 'pr',
                    'Qatar' => 'qa', 'Réunion' => 're', 'Romania' => 'ro', 'Russian Federation' => 'ru', 'Rwanda' => 'rw',
                    'Saint Barthélemy' => 'bl', 'Saint Helena, Ascension and Tristan da Cunha' => 'sh', 'Saint Kitts and Nevis' => 'kn', 'Saint Lucia' => 'lc', 'Saint Martin (French part)' => 'mf',
                    'Saint Pierre and Miquelon' => 'pm', 'Saint Vincent and the Grenadines' => 'vc', 'Samoa' => 'ws', 'San Marino' => 'sm', 'Sao Tome and Principe' => 'st',
                    'Saudi Arabia' => 'sa', 'Senegal' => 'sn', 'Serbia' => 'rs', 'Seychelles' => 'sc', 'Sierra Leone' => 'sl',
                    'Singapore' => 'sg', 'Sint Maarten (Dutch part)' => 'sx', 'Slovakia' => 'sk', 'Slovenia' => 'si', 'Solomon Islands' => 'sb',
                    'Somalia' => 'so', 'South Africa' => 'za', 'South Georgia and the South Sandwich Islands' => 'gs', 'South Sudan' => 'ss', 'Spain' => 'es',
                    'Sri Lanka' => 'lk', 'Sudan' => 'sd', 'Suriname' => 'sr', 'Svalbard and Jan Mayen' => 'sj', 'Sweden' => 'se',
                    'Switzerland' => 'ch', 'Syrian Arab Republic' => 'sy', 'Taiwan, Province of China' => 'tw', 'Tajikistan' => 'tj', 'Tanzania, United Republic of' => 'tz',
                    'Thailand' => 'th', 'Timor-Leste' => 'tl', 'Togo' => 'tg', 'Tokelau' => 'tk', 'Tonga' => 'to',
                    'Trinidad and Tobago' => 'tt', 'Tunisia' => 'tn', 'Turkey' => 'tr', 'Turkmenistan' => 'tm', 'Turks and Caicos Islands' => 'tc',
                    'Tuvalu' => 'tv', 'Uganda' => 'ug', 'Ukraine' => 'ua', 'United Arab Emirates' => 'ae', 'United Kingdom' => 'gb',
                    'United States' => 'us', 'United States Minor Outlying Islands' => 'um', 'Uruguay' => 'uy', 'Uzbekistan' => 'uz', 'Vanuatu' => 'vu',
                    'Venezuela, Bolivarian Republic of' => 've', 'Viet Nam' => 'vn', 'Virgin Islands, British' => 'vg', 'Virgin Islands, U.S.' => 'vi', 'Wallis and Futuna' => 'wf',
                    'Western Sahara' => 'eh', 'Yemen' => 'ye', 'Zambia' => 'zm', 'Zimbabwe' => 'zw',
                ];
                $code = $nameToCode[$countryName] ?? null;
                $flagImg = $code ? "<img src='https://flagcdn.com/24x18/{$code}.png' style='margin-right:6px;vertical-align:middle;' alt='{$countryName} flag'/>" : '';
                return $flagImg . $countryName;
            })
            ->rawColumns([
                'name',
              //  'image',
              //  'url',
                'open_interest_btc',
                'trade_volume_24h_btc',
            ])
            ->make(true);
    }

}