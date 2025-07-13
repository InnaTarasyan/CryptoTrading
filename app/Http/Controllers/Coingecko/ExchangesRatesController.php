<?php

namespace App\Http\Controllers\CoinGecko;

use App\Http\Controllers\Controller;
use App\Models\CoinGecko\CoinGeckoExchangeRates;
use Yajra\DataTables\Facades\DataTables as Datatables;

class ExchangesRatesController extends Controller
{
    /**
     * Show the exchange rates datatable view.
     */
    public function index()
    {
        return view('coingecko.exchanges_rates');
    }

    /**
     * DataTable AJAX endpoint for exchange rates.
     */
    public function getData()
    {
        // Country name => currency symbol (ISO 4217)
        $countryToCurrency = [
            'Afghan Afghani' => 'AFN',
            'Albanian Lek' => 'ALL',
            'Algerian Dinar' => 'DZD',
            'Euro' => 'EUR',
            'Angolan Kwanza' => 'AOA',
            'East Caribbean Dollar' => 'XCD',
            'Argentine Peso' => 'ARS',
            'Armenian Dram' => 'AMD',
            'Australian Dollar' => 'AUD',
            'Azerbaijani Manat' => 'AZN',
            'Bahamian Dollar' => 'BSD',
            'Bahraini Dinar' => 'BHD',
            'Bangladeshi Taka' => 'BDT',
            'Barbadian Dollar' => 'BBD',
            'Belarusian Ruble' => 'BYN',
            'Belize Dollar' => 'BZD',
            'West African CFA Franc' => 'XOF',
            'Bhutanese Ngultrum' => 'BTN',
            'Bolivian Boliviano' => 'BOB',
            'Bosnia-Herzegovina Convertible Mark' => 'BAM',
            'Botswana Pula' => 'BWP',
            'Brazil Real' => 'BRL',
            'Brunei Dollar' => 'BND',
            'Bulgarian Lev' => 'BGN',
            'Burundian Franc' => 'BIF',
            'Cape Verdean Escudo' => 'CVE',
            'Cambodian Riel' => 'KHR',
            'Central African CFA Franc' => 'XAF',
            'Canadian Dollar' => 'CAD',
            'Chilean Peso' => 'CLP',
            'Chinese Yuan' => 'CNY',
            'Colombian Peso' => 'COP',
            'Comorian Franc' => 'KMF',
            'Congolese Franc' => 'CDF',
            'Costa Rican Colon' => 'CRC',
            'Cuban Peso' => 'CUP',
            'Czech Koruna' => 'CZK',
            'Danish Krone' => 'DKK',
            'Djiboutian Franc' => 'DJF',
            'Dominican Peso' => 'DOP',
            'Egyptian Pound' => 'EGP',
            'Eritrean Nakfa' => 'ERN',
            'Ethiopian Birr' => 'ETB',
            'Fijian Dollar' => 'FJD',
            'Gambian Dalasi' => 'GMD',
            'Georgian Lari' => 'GEL',
            'Ghanaian Cedi' => 'GHS',
            'Gibraltar Pound' => 'GIP',
            'Guatemalan Quetzal' => 'GTQ',
            'Guinean Franc' => 'GNF',
            'Guyanese Dollar' => 'GYD',
            'Haitian Gourde' => 'HTG',
            'Honduran Lempira' => 'HNL',
            'Hong Kong Dollar' => 'HKD',
            'Hungarian Forint' => 'HUF',
            'Icelandic Krona' => 'ISK',
            'Indian Rupee' => 'INR',
            'Indonesian Rupiah' => 'IDR',
            'Iranian Rial' => 'IRR',
            'Iraqi Dinar' => 'IQD',
            'Israeli New Shekel' => 'ILS',
            'Jamaican Dollar' => 'JMD',
            'Japanese Yen' => 'JPY',
            'Jordanian Dinar' => 'JOD',
            'Kazakhstani Tenge' => 'KZT',
            'Kenyan Shilling' => 'KES',
            'Kuwaiti Dinar' => 'KWD',
            'Kyrgyzstani Som' => 'KGS',
            'Lao Kip' => 'LAK',
            'Lebanese Pound' => 'LBP',
            'Lesotho Loti' => 'LSL',
            'Liberian Dollar' => 'LRD',
            'Libyan Dinar' => 'LYD',
            'Macanese Pataca' => 'MOP',
            'Macedonian Denar' => 'MKD',
            'Malagasy Ariary' => 'MGA',
            'Malawian Kwacha' => 'MWK',
            'Malaysian Ringgit' => 'MYR',
            'Maldivian Rufiyaa' => 'MVR',
            'Mauritanian Ouguiya' => 'MRU',
            'Mauritian Rupee' => 'MUR',
            'Mexican Peso' => 'MXN',
            'Moldovan Leu' => 'MDL',
            'Mongolian Tugrik' => 'MNT',
            'Moroccan Dirham' => 'MAD',
            'Mozambican Metical' => 'MZN',
            'Myanmar Kyat' => 'MMK',
            'Namibian Dollar' => 'NAD',
            'Nepalese Rupee' => 'NPR',
            'Netherlands Antillean Guilder' => 'ANG',
            'New Taiwan Dollar' => 'TWD',
            'New Zealand Dollar' => 'NZD',
            'Nicaraguan Cordoba' => 'NIO',
            'Nigerian Naira' => 'NGN',
            'North Korean Won' => 'KPW',
            'Norwegian Krone' => 'NOK',
            'Omani Rial' => 'OMR',
            'Pakistani Rupee' => 'PKR',
            'Panamanian Balboa' => 'PAB',
            'Papua New Guinean Kina' => 'PGK',
            'Paraguayan Guarani' => 'PYG',
            'Peruvian Sol' => 'PEN',
            'Philippine Peso' => 'PHP',
            'Polish Zloty' => 'PLN',
            'Qatari Riyal' => 'QAR',
            'Romanian Leu' => 'RON',
            'Russian Ruble' => 'RUB',
            'Rwandan Franc' => 'RWF',
            'Saint Helena Pound' => 'SHP',
            'Samoan Tala' => 'WST',
            'Sao Tome and Principe Dobra' => 'STN',
            'Saudi Riyal' => 'SAR',
            'Serbian Dinar' => 'RSD',
            'Seychellois Rupee' => 'SCR',
            'Sierra Leonean Leone' => 'SLL',
            'Singapore Dollar' => 'SGD',
            'Solomon Islands Dollar' => 'SBD',
            'Somali Shilling' => 'SOS',
            'South African Rand' => 'ZAR',
            'South Korean Won' => 'KRW',
            'South Sudanese Pound' => 'SSP',
            'Sri Lankan Rupee' => 'LKR',
            'Sudanese Pound' => 'SDG',
            'Surinamese Dollar' => 'SRD',
            'Swazi Lilangeni' => 'SZL',
            'Swedish Krona' => 'SEK',
            'Swiss Franc' => 'CHF',
            'Syrian Pound' => 'SYP',
            'Tajikistani Somoni' => 'TJS',
            'Tanzanian Shilling' => 'TZS',
            'Thai Baht' => 'THB',
            'Tongan Paʻanga' => 'TOP',
            'Trinidad and Tobago Dollar' => 'TTD',
            'Tunisian Dinar' => 'TND',
            'Turkish Lira' => 'TRY',
            'Turkmenistan Manat' => 'TMT',
            'Ugandan Shilling' => 'UGX',
            'Ukrainian Hryvnia' => 'UAH',
            'United Arab Emirates Dirham' => 'AED',
            'British Pound Sterling' => 'GBP',
            'United States Dollar' => 'USD',
            'Uruguayan Peso' => 'UYU',
            'Uzbekistani Soʻm' => 'UZS',
            'Vanuatu Vatu' => 'VUV',
            'Venezuelan Bolívar' => 'VES',
            'Vietnamese Dong' => 'VND',
            'Yemeni Rial' => 'YER',
            'Zambian Kwacha' => 'ZMW',
            'Zimbabwean Dollar' => 'ZWL',
            // Add more as needed
        ];
        // Currency symbol to flag code
        $symbolToFlag = [
            'USD' => 'us', 'EUR' => 'eu', 'GBP' => 'gb', 'JPY' => 'jp', 'CNY' => 'cn', 'RUB' => 'ru',
            'AUD' => 'au', 'CAD' => 'ca', 'CHF' => 'ch', 'INR' => 'in', 'BRL' => 'br', 'ZAR' => 'za',
            'KRW' => 'kr', 'TRY' => 'tr', 'MXN' => 'mx', 'SGD' => 'sg', 'HKD' => 'hk', 'SEK' => 'se',
            'NZD' => 'nz', 'PLN' => 'pl', 'THB' => 'th', 'IDR' => 'id', 'MYR' => 'my', 'PHP' => 'ph',
            'CZK' => 'cz', 'HUF' => 'hu', 'DKK' => 'dk', 'ILS' => 'il', 'CLP' => 'cl', 'PKR' => 'pk',
            'EGP' => 'eg', 'SAR' => 'sa', 'AED' => 'ae', 'NGN' => 'ng', 'UAH' => 'ua', 'COP' => 'co',
            'TWD' => 'tw', 'VND' => 'vn', 'ARS' => 'ar', 'KZT' => 'kz', 'QAR' => 'qa', 'KWD' => 'kw',
            'BHD' => 'bh', 'OMR' => 'om', 'JOD' => 'jo', 'MAD' => 'ma', 'DZD' => 'dz', 'LKR' => 'lk',
            'BDT' => 'bd', 'BGN' => 'bg', 'HRK' => 'hr', 'RON' => 'ro', 'ISK' => 'is', 'PEN' => 'pe',
            'UYU' => 'uy', 'BOB' => 'bo', 'PYG' => 'py', 'GEL' => 'ge', 'AZN' => 'az',
            'BYN' => 'by', 'MNT' => 'mn', 'AMD' => 'am', 'UZS' => 'uz', 'TND' => 'tn', 'LBP' => 'lb',
            'JMD' => 'jm', 'TTD' => 'tt', 'XOF' => 'sn', 'XAF' => 'cm', 'XPF' => 'pf', 'XCD' => 'ag',
            'XDR' => 'imf',
        ];
        return Datatables::of(CoinGeckoExchangeRates::all())
            ->editColumn('symbol', function ($item){
                return "<span style='font-size: 18px;'>
                        <input type='hidden' class='id' value='".$item->symbol."'/>
                          $item->symbol
                        </span>";
            })
            ->editColumn('name', function ($item) use ($countryToCurrency, $symbolToFlag) {

                // Try to find the country for this currency name
                $currencySymbol = null;
                $flagCode = null;

                // Try to match the name to a country
                foreach ($countryToCurrency as $country => $symbol) {
                    if (stripos($item->name, $country) !== false) {
                        $currencySymbol = $symbol;
                        break;
                    }
                }
                // If not found, fallback to symbol field
                if (!$currencySymbol) {
                    $currencySymbol = strtoupper($item->symbol);
                }
                $flagCode = $symbolToFlag[$currencySymbol] ?? null;

                $flagImg = $flagCode
                    ? "<img src='https://flagcdn.com/24x18/{$flagCode}.png' style='margin-right:6px;vertical-align:middle;border-radius:3px;' alt='{$currencySymbol} flag'/>"
                    : '';
                return $flagImg . "<span style='font-size: 16px;vertical-align:middle;'>".e($item->name)."</span>";
            })
            ->editColumn('value', function ($item) {
                return "<p class='warning'>".
                    number_format((float)$item->value, 2, ',', ' ')."</p>";
            })
            ->editColumn('type', function ($item) {
                return "<p class='success'>".$item->type."</p>";
            })
            ->rawColumns([
                'symbol',
               // 'name',
               // 'value',
                'type'
            ])
            ->make(true);
    }
}