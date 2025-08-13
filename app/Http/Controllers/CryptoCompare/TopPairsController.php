<?php

namespace App\Http\Controllers\CryptoCompare;

use App\Http\Controllers\Controller;
use App\Models\CryptoCompare\CryptoCompareTopPairs;
use Yajra\DataTables\Facades\DataTables as Datatables;

class TopPairsController extends Controller
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('cryptocompare.top-pairs');
    }

    public function getData()
    {
        return Datatables::of(CryptoCompareTopPairs::all())
            ->editColumn('exchange', function ($item){
                return "<span style='font-size: 16px;'>
                           <input type='hidden' class='id' value='".$item->exchange."'/>
                           <p class='success'>".$item->exchange ."</p>
                        </span>";
            })
            ->editColumn('from_symbol', function ($item) {
                return "<p class='warning'>".$item->from_symbol."</p>";
            })
            ->editColumn('to_symbol', function ($item) {
                return "<p class='info'>".$item->to_symbol."</p>";
            })
            ->editColumn('volume_24h', function ($item) {
                if ($item->volume_24h) {
                    return "<p class='success'>".number_format((float)$item->volume_24h, 2, ',', ' ')."</p>";
                }
                return '<span class="text-muted">N/A</span>';
            })
            ->editColumn('volume_24h_to', function ($item) {
                if ($item->volume_24h_to) {
                    return "<p class='warning'>".number_format((float)$item->volume_24h_to, 2, ',', ' ')."</p>";
                }
                return '<span class="text-muted">N/A</span>';
            })
            ->editColumn('open_24h', function ($item) {
                if ($item->open_24h) {
                    return number_format((float)$item->open_24h, 2, ',', ' ');
                }
                return '<span class="text-muted">N/A</span>';
            })
            ->editColumn('high_24h', function ($item) {
                if ($item->high_24h) {
                    return number_format((float)$item->high_24h, 2, ',', ' ');
                }
                return '<span class="text-muted">N/A</span>';
            })
            ->editColumn('low_24h', function ($item) {
                if ($item->low_24h) {
                    return number_format((float)$item->low_24h, 2, ',', ' ');
                }
                return '<span class="text-muted">N/A</span>';
            })
            ->editColumn('change_24h', function ($item) {
                if ($item->change_24h) {
                    $class = (float)$item->change_24h >= 0 ? 'success' : 'danger';
                    return "<p class='$class'>".number_format((float)$item->change_24h, 2, ',', ' ')."</p>";
                }
                return '<span class="text-muted">N/A</span>';
            })
            ->editColumn('change_pct_24h', function ($item) {
                if ($item->change_pct_24h) {
                    $class = (float)$item->change_pct_24h >= 0 ? 'success' : 'danger';
                    return "<p class='$class'>".number_format((float)$item->change_pct_24h, 2, ',', ' ')."%</p>";
                }
                return '<span class="text-muted">N/A</span>';
            })
            ->editColumn('from_display_name', function ($item) {
                return $item->from_display_name ?? '<span class="text-muted">N/A</span>';
            })
            ->editColumn('to_display_name', function ($item) {
                return $item->to_display_name ?? '<span class="text-muted">N/A</span>';
            })
            ->editColumn('flags', function ($item) {
                if ($item->flags) {
                    $flags = explode(',', $item->flags);
                    $short = implode(', ', array_slice($flags, 0, 2));
                    if (count($flags) > 2) {
                        $short .= '...';
                    }
                    return '<span title="'.$item->flags.'">'.$short.'</span>';
                }
                return '<span class="text-muted">N/A</span>';
            })
            ->editColumn('last_update', function ($item) {
                return $item->last_update ? $item->last_update->format('Y-m-d H:i:s') : '<span class="text-muted">N/A</span>';
            })
            ->rawColumns([
                'exchange',
                'from_symbol',
                'to_symbol',
                'volume_24h',
                'volume_24h_to',
                'open_24h',
                'high_24h',
                'low_24h',
                'change_24h',
                'change_pct_24h',
                'from_display_name',
                'to_display_name',
                'flags',
                'last_update'
            ])
            ->make(true);
    }
} 