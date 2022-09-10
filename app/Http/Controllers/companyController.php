<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Mail;
use App\Mail\NotifyMail;

class companyController extends Controller
{
    function getData(Request $req){

        // form validation
        $validatedData = $req->validate([
            'companySymbol' => 'required|regex:/^[a-zA-Z ]+$/|max:6|min:2',
            'startDate'     => 'required|date',
            'endDate'       => 'required|date|after_or_equal:startDate',
            'email'         => 'required|max:50|regex:/(.+)@(.+)\.(.+)/i'
        ]);

        // Getting company details for submitted symbol
        $url = 'https://pkgstore.datahub.io/core/nasdaq-listings/nasdaq-listed_json/data/a5bc7580d6176d60ac0b2142ca8d7df6/nasdaq-listed_json.json';
        $datos = file_get_contents($url);
        $data = json_decode($datos, true);
        $data = array_filter($data);
        $data['companyDetails'] = (array) current(json_decode(collect($data)->filter(function ($data) use ($req) {

               // return $data['Symbol'] == $req->input(['companySymbol']);
                if($data['Symbol'] == $req->input(['companySymbol'])){
                    return $data;
                }
        })));

        //Calling API to get conpany history
        $apiUrl = 'Insert API URL here';
        $data['data'] = Http::withHeaders([
            "X-RapidAPI-Key" => "Insert API key Here"
        ])->get($apiUrl)->json();

        // Sending Mail
        $this->sendMail($data);

        return view('company',['data'=>$data]);
    }
    public function sendMail($data)
    {
       // print_r($data);
        Mail::to('priyasoran190392@gmail.com')->send(new NotifyMail($data));

        if (Mail::failures()) {
            return response()->Fail('Sorry! Please try again latter');
        }else{
            return 'Great! Successfully send in your mail';
        }
    } 
}
