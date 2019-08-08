<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Climb;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class HomeController extends Controller
{

    protected $base_url = 'http://127.23.23.5';
    protected $api_version = '/api/v1/';
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
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $client = new Client;
        $response = $client->get($this->base_url . $this->api_version . 'climbs');
        $body = $response->getBody();
        $climbs = json_decode($body, true);
        return view('home.index', ['climbs' => $climbs]);
    
    }
    public function getClimb($id) {
        $client = new Client;
        $url = $this->base_url . $this->api_version . 'climbs/' . $id;
        try {

            $response = $client->get($url);
        } catch (ClientException $e) {

            $body = json_decode($e->getResponse()->getBody(), true);
            return redirect()->route('home.index')->withError($body['msg'])->withInput();
        } 

        $body = $response->getBody();
        $climb = json_decode($body, true);
        return view('home.climb', ['climb' => $climb['climb']]);
    }
}
