<?php

namespace App\Http\Controllers;

use App\Contracts\Repositories\TradingPairRepositoryInterface;
use App\Http\Requests\StoreTradingPairRequest;
use App\Http\Requests\UpdateTradingPairRequest;
use App\Models\LiveCoinWatch\LiveCoinHistory;
use App\Models\TradingPair;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables as Datatables;

class TradingPairsController extends Controller
{
    public function __construct(
        private readonly TradingPairRepositoryInterface $tradingPairs
    ) {
    }

    public function index()
    {
        return view('trading_pairs')
            ->with([
                'coins' => LiveCoinHistory::all(),
                'title' => 'Trading Pair',
            ]);
    }

    public function getTradingPairsData()
    {
        return Datatables::of($this->tradingPairs->all())
            ->editColumn('coin', function ($coin) {
                $currentCoin = LiveCoinHistory::find($coin->coin);

                return $currentCoin ? $currentCoin->name : ' - ';
            })
            ->addColumn('action', function ($coin) {
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
     */
    public function store(StoreTradingPairRequest $request)
    {
        $status = 'fail';
        $validated = $request->validated();

        $created = $this->tradingPairs->createPair((int) $validated['coin'], $validated['trading_pair']);
        if ($created !== null && $created->exists) {
            $status = 'ok';
        }

        return response()->json(['status' => $status]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $status = 'fail';
        $data = [];
        $tradingPair = $this->tradingPairs->find((int) $id);
        if ($tradingPair) {
            $coingeckoCoin = LiveCoinHistory::find($tradingPair->coin);
            if ($coingeckoCoin) {
                $status = 'ok';
                $data['trading_pair_id'] = $tradingPair->id;
                $data['id'] = $coingeckoCoin->id;
                $data['coin'] = $coingeckoCoin->name;
                $data['trading_pair'] = $tradingPair->trading_pair;
            }
        }

        return response()->json(['status' => $status, 'data' => $data]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TradingPair $tradingPair)
    {
        $status = $this->tradingPairs->deletePair($tradingPair) ? 'ok' : 'fail';

        return response()->json(['status' => $status]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTradingPairRequest $request, TradingPair $tradingPair)
    {
        $validated = $request->validated();
        $status = $this->tradingPairs->updatePair(
            $tradingPair,
            (int) $validated['coin'],
            $validated['trading_pair']
        ) ? 'ok' : 'fail';

        return response()->json(['status' => $status]);
    }

    public function ajaxGetCoins(Request $request)
    {
        $search = $request->get('q');
        $coins = LiveCoinHistory::query();
        if ($search) {
            $coins = $coins->where('name', 'like', '%'.$search.'%')
                ->orWhere('code', 'like', '%'.$search.'%');
        }

        return response()->json($coins->orderBy('rank')
            ->get());
    }
}
