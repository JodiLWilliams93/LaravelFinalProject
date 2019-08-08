<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Auth;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Validation\Rule;
use App\Climb;

class AdminController extends Controller
{
    protected $base_url = 'http://127.23.23.5';
    protected $api_version = '/api/v1/';
    public function __construct()
    {
        $this->middleware('auth');
    }
 
    public function getAdminIndex() {
        $client = new Client;
        $response = $client->get($this->base_url . $this->api_version . 'climbs');
        $body = $response->getBody();
        $climbs = json_decode($body, true);
        return view('admin.index', ['climbs' => $climbs]);
    }

    public function getAdminClimb($id) {
        $client = new Client;
        $url = $this->base_url . $this->api_version . 'climbs/' . $id;
        try {

            $response = $client->get($url);
        } catch (ClientException $e) {

            $body = json_decode($e->getResponse()->getBody(), true);
            return redirect()->route('admin.index')->withError($body['msg'])->withInput();
        }
        
        $body = $response->getBody();
        $climb = json_decode($body, true);
        return view('admin.climb', ['climb'=> $climb['climb']]);
    }

    public function getAdminClimbEdit($id) {
        $client = new Client;
        $url = $this->base_url . $this->api_version . 'climbs/' . $id;
        try {

            $response = $client->get($url);
            
        } catch (ClientException $e) {

            $body = json_decode($e->getResponse()->getBody(), true);
            return redirect()->route('admin.index')->withError($body['msg'])->withInput();
        }

        $body = $response->getBody();
        $climb = json_decode($body, true);
        return view('admin.edit',['climb' => $climb['climb']]);
    }

    public function getAdminCreate() {
        $climb = new Climb();
        return view('admin.create', ['climb' => $climb]);
    }

    public function postAdminCreate(Request $request) {
        $climb = $request->validate([
            'name' => 'required|max:255',
            'description' => 'required|max:255',
            'length' => 'nullable|integer',
            'rating' => 'required|string',
            'type' => ['required', Rule::in(['Top Rope', 'Trad', 'Sport', 'Boulder'])],
            'gear_needed' => 'nullable|string',
            'location' => 'required|string',
            'public' => [Rule::in(['1', '0']), 'required']
        ]);
        
        $body = json_encode($climb);
        $client = new Client;
        $url = $this->base_url . $this->api_version . 'climbs?token=' . Auth::user()->jwtoken;
        try {
            
            $response = $client->post($url, ['body' => $body, 'headers' => [
                'Content-Type' => 'application/json',
                'X-Requested-With' => 'XMLHttpRequest'
                ]]);
            } catch (ClientException $e) {

                $body = json_decode($e->getResponse()->getBody(), true);
                // $body = $e->getResponse()->getBody(true);
                return redirect()->route('admin.index')->withError($body['msg'])->withInput();

            }
            
            
            $edited = $response->getBody();
            $climb2 = json_decode($edited, true);
            return redirect()->route('admin.index')->withMessage($climb2['msg']);
        
    }
    public function postAdminClimbUpdate(Request $request, $id) {
        $validated_data = $request->validate([
            'name' => 'required|max:255',
            'description' => 'required|max:255',
            'length' => 'nullable|integer',
            'rating' => 'string',
            'type' => Rule::in(['Top Rope', 'Trad', 'Sport', 'Boulder']),
            'gear_needed' => 'nullable|string',
            'added_by' => 'string',
            'location' => 'string',
            'public' => Rule::in(['1', '0'])
        ]);
        
        $body = json_encode($validated_data);
        $client = new Client;
        $url = $this->base_url . $this->api_version . 'climbs/' . $id . '?token=' . Auth::user()->jwtoken;
        try {
            
            $response = $client->patch($url, ['body' => $body, 'headers' => [
                'Content-Type' => 'application/json',
                'X-Requested-With' => 'XMLHttpRequest'
                ]]);
            } catch (ClientException $e) {

                $body = json_decode($e->getResponse()->getBody(), true);
                return redirect()->route('admin.index')->withError(implode(" ,", $body))->withInput();

            }
            
            
            $edited = $response->getBody();
            $climb2 = json_decode($edited, true);
            return redirect()->route('admin.index')->withMessage($climb2['msg']);
        
    }

    public function getAdminClimbDelete($id) {
        $client = new Client;
        $url = $this->base_url . $this->api_version . 'climbs/' . $id . '?token=' . Auth::user()->jwtoken;
        try {
            $response = $client->delete($url);
            $body = $response->getBody();
            $msg = json_decode($body, true);
            return back()->withMessage($msg['msg']);
        } catch (ClientException $e) {
            $body = json_decode($e->getResponse()->getBody(), true);
            return back()->withError($body['msg'])->withInput();

        }

    }

   
}
