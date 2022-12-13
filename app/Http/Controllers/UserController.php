<?php

namespace App\Http\Controllers;

use App\Models\ContactInfo;
use App\Models\Person;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::latest()->paginate(10);
        return [
            "status" => true,
            "message" => "Successful query",
            "data" => $users
        ];
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

        $contactInfo = new ContactInfo();
        $contactInfo->street = $request->street;
        $contactInfo->number = $request->number;
        $contactInfo->colony = $request->colony;
        $contactInfo->city = $request->city;
        $contactInfo->save();

        $person = new Person();
        $person->name = $request->name;
        $person->surname = $request->surname;
        $person->second_surname = $request->second_surname;
        $person->contactInfo()->associate($contactInfo);
        $person->save();

        $user = new User();
        $user->username = $request->username;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->role_id = $request->role_id;
        $user->status_id = $request->status_id;
        $user->person()->associate($person);
        $user->save();

        // $user = User::create($request->except(["person"]));
        // $person = new Person($request->get('person'));
        // $user->person()->save($person);
        // $person = Person::create($request->except(["contact_info"]));
        // $contactInfo = new ContactInfo($request->get('contact_info'));
        // $person->contact_info()->save($contactInfo);

        return [
            "status" => true,
            "message" => "Your user has been created!",
            "data" => $user
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
