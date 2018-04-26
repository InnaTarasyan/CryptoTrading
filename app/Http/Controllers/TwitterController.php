<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Thujohn\Twitter\Twitter;
use Yajra\DataTables\Facades\DataTables as Datatables;
use App\TwitterAccount;
use App\Coinmarketcap;

class TwitterController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
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
        $account = TwitterAccount::where('id' ,$id)->first();
        if($account){
            $status = 'ok';
            $data['id'] = $account->id;
            $data['coin'] = $account->coin;
            $data['account'] = $account->account;
            $data['rel_coins'] = $account->rel_coins;
        }
        return response()->json(['status' => $status, 'data' => $data]);
    }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('twitter')
            ->with(['coins' => Coinmarketcap::all()]);
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


    public function getTweets(){
        return Datatables::of(TwitterAccount::all())
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


