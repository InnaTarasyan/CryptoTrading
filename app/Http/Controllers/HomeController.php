<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables as Datatables;
use App\Models\Coinmarketcap;
use Validator;
use Mail;
use Config;
use Parsedown;
use Session;
use App\Models\LiveCoinWatch;

class HomeController extends Controller
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
        return view('livecoinwatch');

    }

    public function getLiveCoinData()
    {
        return Datatables::of(LiveCoinWatch::query()
            ->join('love_coin_histories', 'love_coin_histories.code', '=', 'live_coin_watches.code')
            ->where('rate', '>', 0)->get())
            ->make(true);
    }

    public function getCoinmarketcapData()
    {
        return Datatables::of(Coinmarketcap::all())
                     ->editColumn('percent_change_1h', function ($coin){
                         if(!isset($coin->percent_change_1h)){
                             return 'Not Set';
                         }
                         if($coin->percent_change_1h < 0){
                             return "<p class='danger'>$coin->percent_change_1h</p>";
                         } else {
                             return "<p class='success'>$coin->percent_change_1h</p>";
                         }
                     })
                     ->editColumn('percent_change_24h', function ($coin){
                        if(!isset($coin->percent_change_24h)){
                             return 'Not Set';
                        }
                        if($coin->percent_change_24h < 0){
                            return "<p class='danger'>$coin->percent_change_24h</p>";
                        } else {
                            return "<p class='success'>$coin->percent_change_24h</p>";
                        }
                     })
                    ->editColumn('percent_change_7d', function ($coin){
                        if(!isset($coin->percent_change_7d)){
                            return 'Not Set';
                        }
                        if($coin->percent_change_7d < 0){
                            return "<p class='danger'>$coin->percent_change_7d</p>";
                        } else {
                            return "<p class='success'>$coin->percent_change_7d</p>";
                        }
                    })

                     ->rawColumns(['percent_change_1h', 'percent_change_24h', 'percent_change_7d', 'last_updated'])
                     ->make(true);
    }

    public function about(Request $request){

        if($request->isMethod('post')){
            $input = $request->except('_token');

            $messages = [
                'required' => 'Field :attribute is required'
            ];

            $validator = Validator::make($input, [
                'name' => 'required|max:100',
                'email' => 'required|email|max:100',
                'text' => 'required|max:255'
            ], $messages);

            if($validator->fails()){
                return redirect()->route('about')->withErrors($validator)->withInput();
            }

            $data = $request->all();
            $data['text'] = (new Parsedown())->line($data['text']);

            $result = Mail::send('layouts.email', ['data' => $data], function ($message) use ($data){
                $mail_admin = Config::get('settings.mail_admin');
                $message->from($data['email'], $data['name']);
                $message->to($mail_admin)->subject('Feedback');
                Session::flash('status', 'Email is sent!');
            });
            if($result){
                return redirect()->route('home');
            }

        }

        if(view()->exists('about')){
            return view('about')->with([
                'key' =>  Config::get('settings.googleapis_key'),
                'title' => 'About Us']);
        }
        abort(404);

    }
}
