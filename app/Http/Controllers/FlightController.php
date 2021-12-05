<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\ApiResponser;
use App\Models\Flight;

class FlightController extends Controller
{
    use ApiResponser;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try{
            if ($request->user()->cannot('viewAny', Flight::class)) {
                return $this->error('Forbidden',403);
            }
            return $this->success(Flight::with(['airline','departureAirport','destinationAirport'])->get());
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
            if ($request->user()->cannot('create', Flight::class)) {
                return $this->error('Forbidden',403);
            }
            $validator = \Validator::make($request->all(), [ 
                'code' => 'required|string',
                'type' => 'required|string|in:PASSENGER,FREIGHT',
                'departure_time' => 'required|date',
                'arrival_time' => 'required|date',
                'departure_id' => 'required|integer|exists:App\Models\Airport,id',
                'destination_id' => 'required|integer|exists:App\Models\Airport,id',
                'airline_id' => 'required|integer|exists:App\Models\Airline,id'
            ]);

            if ($validator->fails()) {
                return $this->error('Invalid input data',400);
            }

            $flight = Flight::create($validator->validated());
            return $this->success($flight);
        }catch(\Exception $e){
            var_dump($e);die;
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
            if ($request->user()->cannot('view', Flight::class)) {
                return $this->error('Forbidden',403);
            }

            if (!isset($id))
                return $this->error('Invalid input data',400);
            

            $flight = Flight::find($id);
            if(!$flight)
                return $this->error('Invalid input data',400);

            return $this->success($flight);
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
            if ($request->user()->cannot('update', Flight::class)) {
                return $this->error('Forbidden',403);
            }

            if (!isset($id))
                return $this->error('Invalid input data',400);

            $validator = \Validator::make($request->all(), [ 
                'code' => 'string',
                'type' => 'string|in:PASSENGER,FREIGHT',
                'departure_time' => 'date',
                'arrival_time' => 'date',
                'departure_id' => 'integer|exists:App\Models\Airport,id',
                'destination_id' => 'integer|exists:App\Models\Airport,id',
                'airline_id' => 'integer|exists:App\Models\Airline,id'
            ]);

            if ($validator->fails()) {
                return $this->error('Invalid input data',400);
            }

            $flight = Flight::find($id);
            $flight->update($validator->validated());
            return $this->success($flight);
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
            if (auth()->user()->cannot('delete', Flight::class)) {
                return $this->error('Forbidden',403);
            }

            if (!isset($id))
                return $this->error('Invalid input data',400);
            

            $flight = Flight::find($id);
            if(!$flight)
                return $this->error('Invalid input data',400);
            $ok = $flight->delete();

            return $this->success(["deleted"=>$ok]);
        }catch(\Exception $e){
            return $this->error('An error has ocurred',500);
        }
    }
}
