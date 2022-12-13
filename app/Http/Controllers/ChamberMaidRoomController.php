<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChamberMaidRoomController extends Controller
{

    public function show($id)
    {
        $rooms = DB::select('SELECT rooms.* FROM rooms JOIN chamber_maid_rooms ON rooms.id = chamber_maid_rooms.rooms_id WHERE users_id = ?', [$id]);

        return $this->getResponse200($rooms);

    }

}
