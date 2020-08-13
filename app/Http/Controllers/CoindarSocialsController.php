<?php

namespace App\Http\Controllers;

use App\CoindarSocials;
use Yajra\DataTables\Facades\DataTables as Datatables;

class CoindarSocialsController extends Controller
{

    /**
     * Show the solume dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('coindar_socials');
    }

    public function getCoindarSocialsData()
    {
        $coins = CoindarSocials::query()
            ->join('coindar2_coins', 'coindar2_coins.id', '=', 'coindar_socials.coin_id')
            ->select('coindar2_coins.name as coin_id', 'website', 'bitcointalk', 'twitter', 'reddit', 'telegram',
                'facebook', 'github', 'explorer',
                'youtube', 'twitter_count', 'reddit_count', 'telegram_count', 'facebook_count')
            ->get();

        return Datatables::of($coins)
            ->editColumn('website', function ($coin){
                if(empty($coin->website)){
                    return 'Not Set';
                }
                return '<a href="'.$coin->website.'">'.$coin->website.'</a>';
            })
            ->editColumn('bitcointalk', function ($coin){
                if(empty($coin->bitcointalk)){
                    return 'Not Set';
                }
                return '<a href="'.$coin->bitcointalk.'">'.$coin->bitcointalk.'</a>';
            })
            ->editColumn('twitter', function ($coin){
                if(empty($coin->twitter)){
                    return 'Not Set';
                }
                return '<a href="'.$coin->twitter.'">'.$coin->twitter.'</a>';
            })
            ->editColumn('reddit', function ($coin){
                if(empty($coin->reddit)){
                    return 'Not Set';
                }
                return '<a href="'.$coin->reddit.'">'.$coin->reddit.'</a>';
            })
            ->editColumn('telegram', function ($coin){
                if(empty($coin->telegram)){
                    return 'Not Set';
                }
                return '<a href="'.$coin->telegram.'">'.$coin->telegram.'</a>';
            })
            ->editColumn('facebook', function ($coin){
                if(empty($coin->facebook)){
                    return 'Not Set';
                }
                return '<a href="'.$coin->facebook.'">'.$coin->facebook.'</a>';
            })
            ->editColumn('github', function ($coin){
                if(empty($coin->github)){
                    return 'Not Set';
                }
                return '<a href="'.$coin->github.'">'.$coin->github.'</a>';
            })
            ->editColumn('explorer', function ($coin){
                if(empty($coin->github)){
                    return 'Not Set';
                }
                return '<a href="'.$coin->explorer.'">'.$coin->explorer.'</a>';
            })
            ->editColumn('youtube', function ($coin){
                if(empty($coin->youtube)){
                    return 'Not Set';
                }
                return '<a href="'.$coin->youtube.'">'.$coin->youtube.'</a>';
            })
            ->rawColumns(['website', 'bitcointalk', 'twitter', 'reddit', 'telegram',
                'facebook', 'github', 'explorer', 'youtube'])
            ->make(true);
    }
}
