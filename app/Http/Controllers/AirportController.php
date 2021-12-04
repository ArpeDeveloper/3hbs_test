<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\ApiResponser;
use App\Models\Airport;

class AirportController extends Controller
{
    use ApiResponser;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            return $this->success(Airport::all());
        }catch(\Exception $e){
            return $this->error('An error has ocurred',500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            $validator = \Validator::make($request->all(), [ 
                'name' => 'required|string',
                'code' => 'required|string',
                'city' => 'required|string'
            ]);

            if ($validator->fails()) {
                return $this->error('Invalid input data',400);
            }

            $airport = new Airport();
            $airport->name = $request->name;
            $airport->code = $request->code;
            $airport->city = $request->city;
            $airport->save();
            return $this->success($airport);
        }catch(\Exception $e){
            return $this->error('An error has ocurred',500);
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
        try{

            if (!isset($id))
                return $this->error('Invalid input data',400);
            

            $airport = Airport::find($id);
            if(!$airport)
                return $this->error('Invalid input data',400);

            return $this->success($airport);
        }catch(\Exception $e){
            return $this->error('An error has ocurred',500);
        }
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
        try{
            if (!isset($id))
                return $this->error('Invalid input data',400);

            $validator = \Validator::make($request->all(), [ 
                'name' => 'string',
                'code' => 'string',
                'city' => 'string'
            ]);

            if ($validator->fails()) {
                return $this->error('Invalid input data',400);
            }

            $airport = Airport::find($id);
            $airport->update($validator->validated());
            return $this->success($airport);
        }catch(\Exception $e){
            return $this->error('An error has ocurred',500);
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
        try{
            if (!isset($id))
                return $this->error('Invalid input data',400);
            

            $airport = Airport::find($id);
            if(!$airport)
                return $this->error('Invalid input data',400);
            $ok = $airport->delete();

            return $this->success(["deleted"=>$ok]);
        }catch(\Exception $e){
            return $this->error('An error has ocurred',500);
        }
    }
}
