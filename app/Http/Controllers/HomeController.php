<?php

namespace App\Http\Controllers;

use App\Library\Services\CoinMarketCalService;
use App\Library\Services\LiveCoinWatch;
use Illuminate\Http\Request;
use Validator;
use Mail;
use Config;
use Parsedown;
use Session;


class HomeController extends Controller
{
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
                Session::flash('status', 'Email sent successfully!');
            });
            if($result){
                return redirect()->route('about')->with('status', 'Email sent successfully!');
            }

        }

        if(view()->exists('about')){
            return view('about')->with([
                'key' =>  Config::get('settings.googleapis_key'),
                'title' => 'About Us']);
        }
        abort(404);

    }

    public function reloadData()
    {
        $status = 'success';

        try {
            CoinMarketCalService::getEvents();
            LiveCoinWatch::getCoins();
        } catch (\Exception $exception) {
            $status = 'fail';
        }

        return $status;
    }
}
