<?php

namespace App\Http\Controllers\CryptoCompare;

use App\Http\Controllers\Controller;
use App\Models\CryptoCompare\CryptoCompareMarkets;
use Yajra\DataTables\Facades\DataTables as Datatables;

class MarketsController extends Controller
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('cryptocompare.markets');
    }

    public function getData()
    {
        return Datatables::of(CryptoCompareMarkets::orderBy('supply', 'DESC')->where('supply', '>', 0)->get())
            ->editColumn('symbol', function ($item){
                return "<span style='font-size: 16px;'>
                           <input type='hidden' class='id' value='".$item->symbol."'/>
                           <p class='success'>".$item->symbol ."</p>
                        </span>";
            })
            ->editColumn('name', function ($item) {
                return "<p class='warning'>".$item->name."</p>";
            })
            ->editColumn('image_url', function ($item) {
                if ($item->image_url) {
                    return '<img src="https://www.cryptocompare.com/'.$item->image_url.'" height=50 width=50 class="previewable-img">';
                }
                return '<span class="text-muted">No image</span>';
            })
            ->editColumn('price_usd', function ($item) {
                if ($item->price_usd) {
                    $full = number_format((float)$item->price_usd, 2, '.', ',');
                    $value = (float)$item->price_usd;
                    $compact = '';
                    if ($value >= 1000000000) {
                        $compact = '$' . number_format($value / 1000000000, 2) . 'B';
                    } elseif ($value >= 1000000) {
                        $compact = '$' . number_format($value / 1000000, 2) . 'M';
                    } elseif ($value >= 1000) {
                        $compact = '$' . number_format($value / 1000, 2) . 'K';
                    } else {
                        $compact = '$' . number_format($value, 2);
                    }
                    return "<span class='price-compact' title='$$full'>$compact</span>";
                }
                return '<span class="text-muted">N/A</span>';
            })
            ->editColumn('market_cap_usd', function ($item) {
                if ($item->market_cap_usd) {
                    return "<p class='success'>".number_format((float)$item->market_cap_usd, 2, ',', ' ')."</p>";
                }
                return '<span class="text-muted">N/A</span>';
            })
            ->editColumn('volume_24h_usd', function ($item) {
                if ($item->volume_24h_usd) {
                    return "<p class='warning'>".number_format((float)$item->volume_24h_usd, 2, ',', ' ')."</p>";
                }
                return '<span class="text-muted">N/A</span>';
            })
            ->editColumn('change_24h_usd', function ($item) {
                if ($item->change_24h_usd) {
                    $class = (float)$item->change_24h_usd >= 0 ? 'success' : 'danger';
                    return "<p class='$class'>".number_format((float)$item->change_24h_usd, 2, ',', ' ')."</p>";
                }
                return '<span class="text-muted">N/A</span>';
            })
            ->editColumn('change_pct_24h_usd', function ($item) {
                if ($item->change_pct_24h_usd) {
                    $class = (float)$item->change_pct_24h_usd >= 0 ? 'success' : 'danger';
                    return "<p class='$class'>".number_format((float)$item->change_pct_24h_usd, 2, ',', ' ')."%</p>";
                }
                return '<span class="text-muted">N/A</span>';
            })
            ->editColumn('high_24h_usd', function ($item) {
                if ($item->high_24h_usd) {
                    return number_format((float)$item->high_24h_usd, 2, ',', ' ');
                }
                return '<span class="text-muted">N/A</span>';
            })
            ->editColumn('low_24h_usd', function ($item) {
                if ($item->low_24h_usd) {
                    return number_format((float)$item->low_24h_usd, 2, ',', ' ');
                }
                return '<span class="text-muted">N/A</span>';
            })
            ->editColumn('open_24h_usd', function ($item) {
                if ($item->open_24h_usd) {
                    return number_format((float)$item->open_24h_usd, 2, ',', ' ');
                }
                return '<span class="text-muted">N/A</span>';
            })
            ->editColumn('supply', function ($item) {
                if ($item->supply) {
                    return "<p class='danger'>".number_format((float)$item->supply, 2, ',', ' ')."</p>";
                }
                return '<span class="text-muted">N/A</span>';
            })
            ->editColumn('algorithm', function ($item) {
                return $item->algorithm ?? '<span class="text-muted">N/A</span>';
            })
            ->editColumn('proof_type', function ($item) {
                return $item->proof_type ?? '<span class="text-muted">N/A</span>';
            })
            ->editColumn('max_supply', function ($item) {
                if ($item->max_supply) {
                    return number_format((float)$item->max_supply, 2, ',', ' ');
                }
                return '<span class="text-muted">N/A</span>';
            })
            ->editColumn('total_coin_supply', function ($item) {
                if ($item->total_coin_supply) {
                    return number_format((float)$item->total_coin_supply, 2, ',', ' ');
                }
                return '<span class="text-muted">N/A</span>';
            })
            ->editColumn('is_trading', function ($item) {
                return $item->is_trading ? '<span class="badge badge-success">Yes</span>' : '<span class="badge badge-danger">No</span>';
            })
            ->editColumn('sponsored', function ($item) {
                return $item->sponsored ? '<span class="badge badge-warning">Sponsored</span>' : '<span class="badge badge-secondary">No</span>';
            })
            ->editColumn('internal', function ($item) {
                return $item->internal ? '<span class="badge badge-info">Internal</span>' : '<span class="badge badge-secondary">External</span>';
            })
            ->editColumn('last_update', function ($item) {
                return $item->last_update ? $item->last_update : '<span class="text-muted">N/A</span>';
            })
            ->rawColumns([
                'symbol',
                'name',
                'image_url',
                'price_usd',
                'market_cap_usd',
                'volume_24h_usd',
                'change_24h_usd',
                'change_pct_24h_usd',
                'high_24h_usd',
                'low_24h_usd',
                'open_24h_usd',
                'supply',
                'algorithm',
                'proof_type',
                'max_supply',
                'total_coin_supply',
                'is_trading',
                'sponsored',
                'internal',
                'last_update'
            ])
            ->make(true);
    }
} 