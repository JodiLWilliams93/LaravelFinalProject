<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Climb;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\View;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
 
    public function getAdminIndex() {
        $client = new Client;
        $response = $client->get('http://127.23.23.5/api/v1/climbs');
        $body = $response->getBody();
        // Implicitly cast the body to a string and echo it
        // echo $body;
        $climbs = json_decode($body, true);
        return view('admin.index', ['climbs' => $climbs]);
    }

    public function getAdminClimb($id) {
        $client = new Client;
        $url = 'http://127.23.23.5/api/v1/climbs/' . $id;
        $response = $client->get($url);
        $body = $response->getBody();
        $climb = json_decode($body, true);
        return view('admin.climb', ['climb'=> $climb['climb']]);
    }

    public function getAdminClimbEdit($id) {
        $client = new Client;
        $url = 'http://127.23.23.5/api/v1/climbs/' . $id;
        $response = $client->get($url);
        $body = $response->getBody();
        $climb = json_decode($body, true);
        return view('admin.edit',['climb' => $climb['climb']]);
    }

    public function postAdminClimbUpdate($id) {
        $climb = $_POST['climb'];
        $body = json_encode($climb);
        $client = new Client;
        $url = 'http://127.23.23.5/api/v1/climbs/' . $id;
        $response = $client->patch($url, ['body' => $body, 'headers' => [
            'Content-Type' => 'application/json',
            'X-Requested-With' => 'XMLHttpRequest'
        ]]);
        $edited = $response->getBody();
        $climb2 = json_decode($edited, true);
        return view('admin.edit', ['climb' => $climb2['climb']]);
    }

    public function getAdminClimbDelete($id) {
        
    }

   
}
