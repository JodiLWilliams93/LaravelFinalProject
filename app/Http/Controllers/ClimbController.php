<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Climb;
use App\User;
use Auth;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class ClimbController extends Controller
{   
    public function __construct()
    {
        $this->middleware('auth:api', ['only' => ['store', 'update', 'destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $climbs = Climb::all();
        foreach ($climbs as $climb) {
            $climb->view_climb = [
                'href' => '/api/v1/climbs/' . $climb->id,
                'method' => 'GET'
            ];
        }

        $response = [
            'msg' => 'List of all climbs',
            'climbs' => $climbs
        ];

        return response()->json($response, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'description' => 'required',
            'length' => 'nullable|integer',
            'rating' => 'required|string',
            'type' => ['required', Rule::in(['Top Rope', 'Trad', 'Sport', 'Boulder'])],
            'gear_needed' => 'nullable|string',
            'location' => 'required|string',
            'public' => ['required', Rule::in(['1', '0'])]
        ]);

        
        if (!$user = JWTAuth::parseToken()->authenticate()) {
            return response()->json(['msg' => 'User not found'], 404);
        }

        $name = $request->input( 'name');
        $description = $request->input('description');
        $length = $request->input('length');
        $rating = $request->input('rating');
        $type = $request->input('type');
        $gear_needed = $request->input( 'gear_needed');
        $added_by = $user->email;
        $location = $request->input( 'location');
        $public = $request->input( 'public');
        

        $climb = new Climb([
            'name' => $name,
            'description' => $description,
            'length' => $length,
            'rating' => $rating,
            'type' => $type,
            'gear_needed' => $gear_needed,
            'location' => $location,
            'added_by' => $added_by,
            'public' => $public
        ]);

        if ( $climb->save()) {
           
            $climb->view_climb = [
                'href' => '/api/v1/climbs/' . $climb->id,
                'method' => 'GET'
            ];
            $response = ['msg' => 'The climb "' . $climb->name . '" was created', 'climb' => $climb];
            return response()->json($response, 201);
        }

        $response = ['msg' => 'An error occured.'];
        return response()->json($response, 400);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!$climb = Climb::where('id', $id)->first()) {
            return response()->json(['msg' => 'Climb not found. Check URL and try again.'], 404);

        }
        $climb->view_climb = [
            'href' => '/api/v1/climbs/' . $climb->id,
            'method' => 'GET'
        ];

        $response = ['msg' => 'Climb information', 'climb' => $climb];

        return response()->json($response, 200);        
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
        $this->validate($request, [
            'name' => 'max:255',
            'length' => 'nullable|integer',
            'rating' => 'string',
            'type' => Rule::in(['Top Rope', 'Trad', 'Sport', 'Boulder']),
            'gear_needed' => 'nullable|string',
            'added_by' => 'string',
            'location' => 'string',
            'public' => Rule::in(['1', '0'])
        ]);
        try {
            
            $user = JWTAuth::parseToken()->authenticate();
            
        } catch (JWTException $e) {

            return response()->json(['msg' => 'User not found'], 401);

        }
                
        
        if (!$climb = Climb::where('id', $id)->first()) {
            return response()->json(['msg' => 'Climb not found. Check URL and try again.'], 404);

        } else {

            
            
            if ($user->email == $climb->added_by || $climb->public) {
                
                $climb->name = $request->input('name') ?? $climb->name;
                $climb->length = $request->input('length') ?? $climb->length;
                $climb->description = $request->input('description') ?? $climb->description;
                $climb->rating = $request->input('rating') ?? $climb->rating;
                $climb->gear_needed = $request->input('gear_needed') ?? $climb->gear_needed;
                $climb->type = $request->input('type') ?? $climb->type;
                $climb->location = $request->input('location') ?? $climb->location;
                $climb->added_by = $user->email ?? $climb->added_by;
        
                if ($climb->save()) {
        
                    $climb->view_climb = [
                        'href' => '/api/v1/climbs/' . $climb->id,
                        'method' => 'GET'
                    ];
                    
                    $response = ['msg' => 'The climb "' . $climb->name . '" was updated', 'climb' => $climb];
                    return response()->json($response, 201);
                    
                } else {
                
                    $response = ['msg' => 'An error occured.'];
                    return response()->json($response, 400);
                } 
            } else {
                $response = ['msg' => 'User does not have sufficient permissions to edit "' . $climb->name . '"'];
                return response()->json($response, 403);        
            }
        }
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {

            $user = JWTAuth::parseToken()->authenticate();
        } catch (JWTException $e) {

            return response()->json(['msg' => 'User not found'], 401);
        }

        if (!$climb = Climb::where('id', $id)->first()) {
            return response()->json(['msg' => 'Climb not found. Check URL and try again.'], 404);
        }
        if ($user->email == $climb->added_by && !$climb->public) {
            if ($climb->delete()) {
                $msg = 'The climb "' . $climb->name . '" was deleted.'; 
                $response = [
                    'msg' => $msg,
                    'create' => [
                        'href' => '/api/v1/climb',
                        'method' => 'POST',
                        'params' => 'name, description, length, location, added_by, gear_needed, rating, type'
                    ]
                ];

                return response()->json($response, 200);
            }      
        } else {
            $response = ['msg' => 'User does not have sufficient permissions to delete "' . $climb->name . '"'];
            return response()->json($response, 403);
        }
        $response = ['msg' => 'Something went wrong.'];
        return response()->json($response, 400);
        
    }
}
