<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Airport;
use App\Models\Airline;

class Flight extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'type',
        'departure_time',
        'arrival_time',
        'departure_id',
        'destination_id',
        'airline_id'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'departure_time' => 'datetime',
    ];

    /**
     * Get the departure airport that owns the flight.
     */
    public function departureAirport()
    {
        return $this->belongsTo(Airport::class,'departure_id');
    }

    /**
     * Get the destination airport that owns the flight.
     */
    public function destinationAirport()
    {
        return $this->belongsTo(Airport::class,'destination_id');
    }

    /**
     * Get the airline that owns the flight.
     */
    public function airline()
    {
        return $this->belongsTo(Airline::class,'airline_id');
    }
}
