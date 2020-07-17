<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;

class BroadcastController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        try {
            $url = env('API_URL', 'https://dev.api.customerpay.me'). '/customer' ;
            $client = new Client();

            $headers = ['headers' => ['x-access-token' => Cookie::get('api_token')]];
            $user_response = $client->request('GET', $url, $headers);

            $statusCode = $user_response->getStatusCode();
            $users = json_decode($user_response->getBody());
            $dt = $users->data->customer;

            //dd($dt);

            

            if ( $statusCode == 200 ) {


                // $customerArray = [];
                // foreach($users->data as $key => $value) {
                //     array_push($customerArray, $users->data[$key]->customers);
                // }

                // $allCustomers = [];
                // foreach( $customerArray as $key => $value ) {
                //     foreach( $value as $key => $v ) {
                //         array_push($allCustomers, $v);
                //     }
                // }

                // // start pagination
                // $perPage = 5;
                // $page = $request->get('page', 1);
                // if ($page > count($allCustomers) or $page < 1) {
                //     $page = 1;
                // }
                // $offset = ($page * $perPage) - $perPage;
                // $articles = array_slice($allCustomers, $offset, $perPage);
                // $datas = new Paginator($articles, count($allCustomers), $perPage);

                return view('backend.broadcasts.create')->with('data', $dt);
            }

            if ( $statusCode == 500 ) {
                return view('errors.500');
            }
        } catch(\RequestException $e) {
            $statusCode = $e->getResponse()->getStatusCode();
            $data = json_decode($e->getResponse()->getBody()->getContents());
            if ( $statusCode == 401 ) { //401 is error code for invalid token
                return redirect()->route('logout');
            }

            return view('errors.500');
        } catch ( \Exception $e ) {
            $statusCode = $e->getResponse()->getStatusCode();
            $data = json_decode($e->getResponse()->getBody()->getContents());
            if ( $statusCode == 401 ) { //401 is error code for invalid token
                return redirect()->route('logout');
            }

            return view('errors.500');
        }
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.broadcasts.send');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $url = "https://api.sandbox.africastalking.com/version1/messaging";

        try{
            $client = new Client;
            $payload = [
                'headers' => [
                    'apiKey' => env('AT_KEY', "3f18b458d8d12b7fbdd7f85665e878f05d99c1f8c773dccc5ef21d3ea80cfb21"),
                    "Content-type" => "application/x-www-form-urlencoded",
                    "Accept" => "application/json"
                ],
                'form_params' => [
                   "username" => env('AT_USERNAME',"sandbox"),
                   "to" => $request->input('receiver'),
                   "message" => $request->input('message'),
                   "from" => env('AT_FROM',"AFRICASTKNG"),
                   "bulkSMSMode" => "1",
                   "enqueue" => "1",
                ]
            ];

            $response = $client->request("POST", $url, $payload);
            $data = json_decode($response->getBody());
            $status = $data->SMSMessageData->Recipients;
            $dt = [];
         
            for($i = 0; $i < count($status); $i++){
                foreach($status[$i] as $key){
                    array_push($dt, $key);
                }
            }           
                      
               
            if ($dt["0"] == 101 || $dt["0"] == 102){
               return redirect()->route('broadcast.index')->with('response', $dt["3"]);               
            }else {
               return redirect()->route('broadcast.create')->with('response', "Failed");     
            }

        }catch(\RequestException $e){
            $statusCode = $e->getResponse()->getStatusCode();
            $data = json_decode($e->getResponse()->getBody()->getContents());
            if ( $statusCode == 401 ) { //401 is error code for invalid token
                return redirect()->route('broadcast.create')->with('response', $data->message);
            }
        }catch(\Exception $e){
            return view("errors.500");
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
