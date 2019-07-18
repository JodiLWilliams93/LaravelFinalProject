<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Climb;
use Gate;

class ClimbController extends Controller
{
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
        $name = $request->input( 'name');
        $description = $request->input('description');
        $length = $request->input('length');
        $rating = $request->input('rating');
        $type = $request->input('type');
        $gear_needed = $request->input( 'gear_needed');
        $added_by = $request->input( 'added_by');
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
            $response = ['msg' => 'climb created', 'climb' => $climb];
            return response()->json($response, 201);
        }

        $response = ['msg' => 'An error occured.'];
        return response()->json($response, 404);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $climb = Climb::where('id', $id)->firstOrFail();
        $climb->view_climb = [
            'href' => '/api/v1/climbs/' . $climb->id,
            'method' => 'GET'
        ];

        $response = ['msg' => 'Climb information', 'climb' => $climb];

        return response()->json($response, 200);        
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
        $climb = Climb::where('id', $id)->first();

        // if (Gate::denies('manipulate-climb', $climb)) {
        //     $response = ['msg' => 'User is not authorized to edit climb.'];
        //     return response()->json($response, 404);
        // }
        $climb->name = $request->input('name') ?? $climb->name;
        $climb->length = $request->input('length') ?? $climb->length;
        $climb->description = $request->input('description') ?? $climb->description;
        $climb->rating = $request->input('rating') ?? $climb->rating;
        $climb->gear_needed = $request->input('gear_needed') ?? $climb->gear_needed;
        $climb->type = $request->input('type') ?? $climb->type;
        $climb->location = $request->input('location') ?? $climb->location;
        $climb->added_by = $request->input('added_by') ?? $climb->added_by;


        

        if ($climb->save()) {

            $climb->view_climb = [
                'href' => '/api/v1/climbs/' . $climb->id,
                'method' => 'GET'
            ];
            $response = ['msg' => $climb->name . ' updated', 'climb' => $climb];
            return response()->json($response, 201);
        }


        $response = ['msg' => 'An error occured.'];
        return response()->json($response, 404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $climb = Climb::where('id', $id)->firstOrFail();
        if ($climb->delete()) {
            $response = [
                'msg' => 'Climb Deleted',
                'create' => [
                    'href' => '/api/v1/climb',
                    'method' => 'POST',
                    'params' => 'name, description, length, location, added_by, gear_needed, rating, type'
                ]
            ];

            return response()->json($response, 200);      
        }
    }
}
