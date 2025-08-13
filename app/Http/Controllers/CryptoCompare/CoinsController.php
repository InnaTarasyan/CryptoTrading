<?php

namespace App\Http\Controllers\CryptoCompare;

use App\Http\Controllers\Controller;
use App\Models\CryptoCompare\CryptoCompareCoins;
use Yajra\DataTables\Facades\DataTables as Datatables;

class CoinsController extends Controller
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('cryptocompare.coins');
    }

    public function getData()
    {
        return Datatables::of(CryptoCompareCoins::all())
            ->editColumn('symbol', function ($item){
                return "<span style='font-size: 18px;'>
                         <input type='hidden' class='id' value='".$item->symbol."'/>
                          $item->symbol
                        </span>";
            })
            ->editColumn('name', function ($item) {
                return "<p class='success'>".$item->name."</p>";
            })
            ->editColumn('full_name', function ($item) {
                return "<p class='warning'>".$item->full_name."</p>";
            })
            ->editColumn('image_url', function ($item) {
                if ($item->image_url) {
                    return '<img src="https://www.cryptocompare.com/'.$item->image_url.'" height=50 width=50 class="previewable-img">';
                }
                return '<span class="text-muted">No image</span>';
            })
            ->editColumn('algorithm', function ($item) {
                return $item->algorithm ?? '<span class="text-muted">N/A</span>';
            })
            ->editColumn('proof_type', function ($item) {
                return $item->proof_type ?? '<span class="text-muted">N/A</span>';
            })
            ->editColumn('block_number', function ($item) {
                return $item->block_number ? number_format($item->block_number, 0, ',', ' ') : '<span class="text-muted">N/A</span>';
            })
            ->editColumn('block_time', function ($item) {
                return $item->block_time ? number_format($item->block_time, 0, ',', ' ') : '<span class="text-muted">N/A</span>';
            })
            ->editColumn('block_reward', function ($item) {
                return $item->block_reward ? number_format((float)$item->block_reward, 8, ',', ' ') : '<span class="text-muted">N/A</span>';
            })
            ->editColumn('max_supply', function ($item) {
                return $item->max_supply ? number_format((float)$item->max_supply, 2, ',', ' ') : '<span class="text-muted">N/A</span>';
            })
            ->editColumn('total_coin_supply', function ($item) {
                return $item->total_coin_supply ? number_format((float)$item->total_coin_supply, 2, ',', ' ') : '<span class="text-muted">N/A</span>';
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
            ->editColumn('sort_order', function ($item) {
                return $item->sort_order ? number_format($item->sort_order, 0, ',', ' ') : '<span class="text-muted">N/A</span>';
            })
            ->rawColumns([
                'symbol',
                'name',
                'full_name',
                'image_url',
                'algorithm',
                'proof_type',
                'block_number',
                'block_time',
                'block_reward',
                'max_supply',
                'total_coin_supply',
                'is_trading',
                'sponsored',
                'internal',
                'sort_order'
            ])
            ->make(true);
    }
} 