<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables as Datatables;
use App\Models\TwitterAccount;
use App\Models\LiveCoinWatch\LiveCoinHistory;

class TwitterController extends Controller
{
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
        $account = TwitterAccount::where('id' ,$id)->first();
        $coingeckoCoin = LiveCoinHistory::find($account->coin);
        $relatedCoinIds = explode(',', $account->rel_coins);
        $related = [];
        if(!empty($relatedCoinIds)) {
            $live = LiveCoinHistory::whereIn('id', $relatedCoinIds)->get();
            foreach ($live as $datum) {
                $related[] = [
                    'id' => $datum->id,
                    'name' => $datum->name,
                    'code' => $datum->code,
                ];
            }
        }

        if($account){
            $status = 'ok';
            $data['account'] = $account->account;
            $data['account_id'] = $account->id;
            $data['id'] = $coingeckoCoin->id;
            $data['coin'] = $coingeckoCoin->code;
            $data['rel_coins'] = $related;
        }
        return response()->json(['status' => $status, 'data' => $data]);
    }

    public function index()
    {
        return view('twitter')
            ->with(['coins' => LiveCoinHistory::all(),
                'title' => 'Twitter']);
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
            'rel_coins' => $request->rel_coins,
            'account' => $request->account
        ];

        $account = TwitterAccount::where('id', $request->id)->first();

        if($account) {
            $account
                ->update($data);
            $status = 'ok';
        }

        return response()->json(['status' => $status]);

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
        $account = TwitterAccount::where('id', $id)->first();
        if($account){
            $account->delete();
            $status = 'ok';
        }
        return response()->json(['status' => $status]);
    }


    public function getMessages(){
        return Datatables::of(TwitterAccount::all())
            ->editColumn('coin', function($coin){
                $currentCoin = LiveCoinHistory::find($coin->coin);
                return $currentCoin ? $currentCoin->name : ' - ';
            })
            ->editColumn('rel_coins', function($coin){
                $relCoinNames = explode(',', $coin->rel_coins);
                $currentCoin = LiveCoinHistory::whereIn('id', $relCoinNames)->pluck('code')->toArray();
                return $currentCoin ? implode(', ', $currentCoin) : ' - ';
            })
            ->editColumn('action', function ($account){
                return '<button type="button" class="btn m-btn--pill btn-outline-success m-btn m-btn--custom edit" data-toggle="modal" data-target="#m_modal_1" data-url="'.$account->id.'">
							Edit
						</button>
                        <button type="button" class="btn m-btn--pill btn-outline-info m-btn m-btn--custom delete" data-url="'.$account->id.'">
							Delete
						</button>
						 ';
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

        $exists = TwitterAccount::where('coin', $request->coin)->first();
        if(!$exists){
            $data = [
                'coin' => $request->coin,
                'rel_coins' => $request->rel_coins,
                'account' => $request->account
            ];

            $account = TwitterAccount::create($data);
            if ($account->exists){
                $status = 'ok';
            }
        }

        return response()->json(['status' => $status]);

    }

}


