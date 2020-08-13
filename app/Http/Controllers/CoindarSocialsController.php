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
            ->select('coindar2_coins.symbol', 'coindar2_coins.name as coin_id', 'website', 'bitcointalk', 'twitter', 'reddit', 'telegram',
                'facebook', 'github', 'explorer',
                'youtube', 'twitter_count', 'reddit_count', 'telegram_count', 'facebook_count')
            ->get();

        return Datatables::of($coins)
            ->editColumn('symbol', function ($coin){
                if(empty($coin->symbol)){
                    return 'Not Set';
                }

                return $coin->symbol;
            })
            ->editColumn('website', function ($coin){
                if(empty($coin->website)){
                    return 'Not Set';
                }

                $substr = substr($coin->website, 0, 12).'...';
                return '<a href="'.$coin->website.'">'.$substr.'</a>';
            })
            ->editColumn('bitcointalk', function ($coin){
                if(empty($coin->bitcointalk)){
                    return 'Not Set';
                }
                $substr = substr($coin->bitcointalk, 0, 12).'...';
                return '<a href="'.$coin->bitcointalk.'">'.$substr.'</a>';
            })
            ->editColumn('twitter', function ($coin){
                if(empty($coin->twitter)){
                    return 'Not Set';
                }
                $substr = substr($coin->twitter, 0, 12).'...';
                return '<a href="'.$coin->twitter.'">'.$substr.'</a>';
            })
            ->editColumn('reddit', function ($coin){
                if(empty($coin->reddit)){
                    return 'Not Set';
                }
                $substr = substr($coin->reddit, 0, 12).'...';
                return '<a href="'.$coin->reddit.'">'.$substr.'</a>';
            })
            ->editColumn('telegram', function ($coin){
                if(empty($coin->telegram)){
                    return 'Not Set';
                }
                $substr = substr($coin->telegram, 0, 12).'...';
                return '<a href="'.$coin->telegram.'">'.$substr.'</a>';
            })
            ->editColumn('facebook', function ($coin){
                if(empty($coin->facebook)){
                    return 'Not Set';
                }
                $substr = substr($coin->facebook, 0, 12).'...';
                return '<a href="'.$coin->facebook.'">'.$substr.'</a>';
            })
            ->editColumn('github', function ($coin){
                if(empty($coin->github)){
                    return 'Not Set';
                }
                $substr = substr($coin->github, 0, 12).'...';
                return '<a href="'.$coin->github.'">'.$substr.'</a>';
            })
            ->editColumn('explorer', function ($coin){
                if(empty($coin->github)){
                    return 'Not Set';
                }
                $substr = substr($coin->explorer, 0, 12).'...';
                return '<a href="'.$coin->explorer.'">'.$substr.'</a>';
            })
            ->editColumn('youtube', function ($coin){
                if(empty($coin->youtube)){
                    return 'Not Set';
                }
                $substr = substr($coin->youtube, 0, 12).'...';
                return '<a href="'.$coin->youtube.'">'.$substr.'</a>';
            })
            ->rawColumns(['website', 'bitcointalk', 'twitter', 'reddit', 'telegram',
                'facebook', 'github', 'explorer', 'youtube'])
            ->make(true);
    }
}
