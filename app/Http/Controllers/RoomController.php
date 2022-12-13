<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\Room;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoomController extends Controller
{
    public function index()
    {
        $rooms = Room::orderBy('id', 'asc')->get();
        return $this->getResponse200($rooms);
    }


    public function store(Request $request)
    {
            $room = new Room();
            $room->building_id = $request->building_id;
            $room->status_id = $request->status_id;
            $room->floor = $request->floor;
            $room->number = $request->number;
            $room->save();
            return $this->getResponse201("Room","created",$room);
    }


    public function show($id)
    {
        $room = Room::find($id);
        if($room){
            return $this->getResponse200($room);
        }else{
            return $this->getResponse404();
        }
    }



    public function update(Request $request, $id)
    {
        //DB::beginTransaction();


        try{
        $room = Room::find($id);
        if ($room) {
            $room->status_id = $request->room['status_id'];
            $room->update();

            $log = new Log();
            $log->status = $request->log['status'];
            $log->date_and_hour = $request->log['dataAndHour'];
            $log->user_id = $request->log['userId'];
            $log->room_id = $id;

            $log->save();

            return $this->getResponse201("Room","updated",$room);

        } else {
            return $this->getResponse404();
        }
        //DB::commit();
        }catch(Exception $e){
            return $this->getResponse500($e->getMessage());
          //  DB::rollBack();
        }
    }

    public function destroy($id)
    {
        $room = Room::find($id);
        if($room){
            $room->delete();
            return $this->getResponseDelete200($room);
        }else{
            return $this->getResponse404();
        }
    }

    public function showInformation($id)
    {
        $logs = DB::select('SELECT * FROM logs JOIN users ON users.id = logs.user_id JOIN people ON people.id = users.person_id WHERE room_id = ?', [$id]);

        return $this->getResponse200($logs);

    }

}
