<?php

namespace App\Http\Controllers;

use App\Models\Building;
use Exception;
use Illuminate\Http\Request;

class BuildingController extends Controller
{
    public function index()
    {
        $buildings = Building::orderBy('id', 'asc')->get();
        return $this->getResponse200($buildings);
    }


    public function store(Request $request)
    {
            $building = new Building();
            $building->phone_number = $request->phone_number;
            $building->save();
            return $this->getResponse201("Building","created",$building);
    }


    public function show($id)
    {
        $building = Building::find($id);
        if($building){
            return $this->getResponse200($building);
        }else{
            return $this->getResponse404();
        }
    }



    public function update(Request $request, $id)
    {
        //DB::beginTransaction();
        try{
        $building = Building::find($id);
        if ($building) {
            $building->phone_number = $request->phone_number;
            $building->update();
            return $this->getResponse201("Building","updated",$building);

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
        $building = Building::find($id);
        if($building){
            $building->delete();
            return $this->getResponseDelete200($building);
        }else{
            return $this->getResponse404();
        }
    }
}
