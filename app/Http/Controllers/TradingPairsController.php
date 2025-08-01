<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables as Datatables;
use App\Models\TradingPair;
use App\Models\LiveCoinWatch\LiveCoinHistory;

class TradingPairsController extends Controller
{

    public function index()
    {
        return view('trading_pairs')
                ->with([
                    'coins' => LiveCoinHistory::all(),
                    'title' => 'Trading Pair',
                ]);
    }

    public function getTradingPairsData(){
        return Datatables::of(TradingPair::all())
            ->editColumn('coin', function($coin){
                $currentCoin = LiveCoinHistory::find($coin->coin);
                return $currentCoin ? $currentCoin->name : ' - ';
            })
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
        $tradingPair = TradingPair::where('id',$id)->first();
        $coingeckoCoin = LiveCoinHistory::find($tradingPair->coin);
        if($tradingPair && $coingeckoCoin){
            $status = 'ok';
            $data['trading_pair_id'] = $tradingPair->id;
            $data['id'] = $coingeckoCoin->id;
            $data['coin'] = $coingeckoCoin->name;
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

    public function ajaxGetCoins(Request $request)
    {
        $search = $request->get('q');
        $coins = LiveCoinHistory::query();
        if($search) {
            $coins = $coins->where('name', 'like', '%'.$search.'%')
               ->orWhere('code', 'like', '%'.$search.'%');
        }

        return response()->json($coins->orderBy('rank')
            ->get());
    }
}
