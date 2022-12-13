<?php

namespace App\Http\Controllers;

use App\Models\Observation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ObservationController extends Controller
{
    public function store(Request $request)
    {

        $observation = new Observation();

        $observation->date = $request->date;
        $observation->description = $request->description;
        $observation->rooms_id = $request->room['id'];
        $observation->picture = $request->picture;
        $observation->users_id = $request->users_id;

        $observation->save();
        return $this->getResponse201("Observation","created",$observation);
    }
}
