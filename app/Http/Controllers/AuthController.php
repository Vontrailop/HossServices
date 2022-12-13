<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed'
        ]);

        if(!$validator->fails()){
            DB::beginTransaction();
            try {
                //Validate request data
                $request->validate([
                    'name' => 'required',
                    'email' => 'required|email|unique:users',
                    'password' => 'required|confirmed'
                ]);
                //Set data
                $user = new User();
                $user->name = $request->name;
                $user->email = $this->removeWhiteSpace($request->email);
                $user->password = Hash::make($request->password);
                $user->save();
                DB::commit();
                return $this->getResponse201('user account', 'created', $user);
            } catch (Exception $e) {
                DB::rollBack();
                return $this->getResponse500([$e->getMessage()]);
            }
        }else{
            return $this->getResponse500([$validator->errors()]);
        }
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);
        if (!$validator->fails()) {
            $user = User::where('email', '=', $request->email)->first();
            if (isset($user->id)) {
                if (Hash::check($request->password, $user->password)) {
                    // foreach ($user->tokens as $token) { //Revoke all previous tokens
                    //     $token->delete();
                    // }
                    //Create new token
                    $token = $user->createToken('auth_token')->plainTextToken;
                    return response()->json([
                        'message' => "Successful authentication",
                        'access_token' => $token,
                    ], 200);
                } else { //Invalid credentials
                    return $this->getResponse401();
                }
            } else { //User not found
                return $this->getResponse401();
            }
        } else {
            return $this->getResponse500([$validator->errors()]);
        }
    }

    public function userProfile()
    {
        // $user = DB::select('SELECT * FROM users WHERE id = ?', [$id]);

        // return $this->getResponse200($user);


        return $this->getResponse200( auth()->user() );
    }


    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required',
            'password_confirmation' => 'required'
        ]);
        if (!$validator->fails()) {
            DB::beginTransaction();
            try {
                $user = User::where('id', '=', $request->user()->currentAccessToken()->tokenable_id)->first();
                if (isset($user->id)) {
                    if ($request->password == $request->password_confirmation) {
                        //Set data
                        $user->password = Hash::make($request->password); //encrypt password

                        $request->user()->tokens()->delete();
                        //Create token

                        $user->save();
                        DB::commit();

                        return $this->getResponse201(
                            "password",
                            "updated",
                            $user
                        );
                    } else {
                        return $this->getResponse500("Incorrect passwords");
                    }
                } else { //User not found

                    return $this->getResponse401();
                }
            } catch (Exception $e) {
                DB::rollBack();
                return $this->getResponse500([$e->getMessage()]);
            }
        } else {
            return $this->getResponse500([$validator->errors()]);
        }
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'message' => "Logout successful"
        ], 200);
    }
}
