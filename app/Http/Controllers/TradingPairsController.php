<?php

namespace App\Http\Controllers;

use App\Models\CoinGecko\CoinGeckoCoin;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables as Datatables;
use App\Models\TradingPair;

class TradingPairsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('trading_pairs')
                ->with(['coins' => CoinGeckoCoin::all(),
                        'title' => 'Trading Pair']);
    }

    public function getTradingPairsData(){
        return Datatables::of(TradingPair::all())
            ->addColumn('action', function ($coin){
                return '<button type="button" class="btn m-btn--pill btn-outline-success m-btn m-btn--custom edit" data-toggle="modal" data-target="#m_modal_1" data-url="'.$coin->id.'">
							Edit
						</button>
                        <button type="button" class="btn m-btn--pill btn-outline-info m-btn m-btn--custom delete" data-url="'.$coin->id.'">
							Delete
						</button>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        $status = 'fail';

        $exists = TradingPair::where('coin', $request->coin)->first();
        if(!$exists){
            $data = [
                'coin' => $request->coin,
                'trading_pair' => $request->trading_pair
            ];

            $account = TradingPair::create($data);
            if ($account->exists){
                $status = 'ok';
            }
        }

        return response()->json(['status' => $status]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $status = 'fail';
        $data = [];
        $tradingPair = TradingPair::where('id' ,$id)->first();
        if($tradingPair){
            $status = 'ok';
            $data['id'] = $tradingPair->id;
            $data['coin'] = $tradingPair->coin;
            $data['trading_pair'] = $tradingPair->trading_pair;
        }
        return response()->json(['status' => $status, 'data' => $data]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $status = 'fail';
        $tradingPair = TradingPair::where('id', $id)->first();
        if($tradingPair){
            $tradingPair->delete();
            $status = 'ok';
        }
        return response()->json(['status' => $status]);
    }

    /**
     * Update the specified resource
     *
     * @param  Request  $request
     * @param  string  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $status = 'fail';

        $data = [
            'coin' => $request->coin,
            'trading_pair' => $request->trading_pair,
        ];

        $tradingPair = TradingPair::where('id', $request->id)->first();
        if($tradingPair) {
            $tradingPair
                ->update($data);
            $status = 'ok';
        }

        return response()->json(['status' => $status]);

    }
}
