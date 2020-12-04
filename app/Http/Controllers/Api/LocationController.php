<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Api;
use App\Helpers\Location;
use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LocationController extends Controller
{
    public function nearbyNurses(Request $request){
        $user = Auth::guard('api')->user();
        $nurses = User::where('genre','2')->with('category')->with('qualifications')->with('specifications')->get();
        
        foreach($nurses as $key => $nurse){
            $distance = Location::diatance($nurse->location, $user->location);
            if(!$distance)
                $nurses->forget($key);
            else
                $nurse->distance = $distance;
        }

        $sorted = $nurses->sort(function($a, $b) {
            if ($a->distance == $b->distance) {
                return 0;
            }
        
            return ($a->distance < $b->distance) ? -1 : 1;
        });

        return Api::setResponse('nearby_nurses', 'fdsf');
        return Api::setResponse('nearby_nurses', $sorted->toArray());
    }
    
    public function nearbyHospitals(Request $request){
        $user = Auth::guard('api')->user();
        $hospitals = User::where('type','2')->get();
        
        foreach($hospitals as $key => $nurse){
            $distance = Location::diatance($nurse->location, $user->location);
            if(!$distance)
                $hospitals->forget($key);
            else
                $nurse->distance = $distance;
        }

        $sorted = $hospitals->sort(function($a, $b) {
            if ($a->distance == $b->distance) {
                return 0;
            }
        
            return ($a->distance < $b->distance) ? -1 : 1;
        });

        return Api::setResponse('nearby_hospitals', $sorted);
    }



    public function sortByDistance($a, $b)
    {
        return $a->distance - $b->distance;
    }


    
}
