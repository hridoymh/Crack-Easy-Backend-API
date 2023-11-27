<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\User;
use App\Models\Token;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $input = $request->all();

        // $validated = Validator::make($request->all(), [
        //     'google_token' => ['required']
        // ]);
        // if($validated->fails()){
        //     return response()->json($validated->messages(),400);
        // }
        // else{
        //     $data = gjwt_decode($input['google_token']);
        //     // var_dump( json_decode($data));
        //     // print_r($data);
        //     // $data = [
        //     //     'name' => $request->name,
        //     //     'email' => $request->email,
        //     //     'password' => Hash::make($request->password)
        //     // ];
        //     // DB::beginTransaction();
        //     // try{
        //     //     $user = User::create($data);
        //     //     DB::commit();
        //     // } catch (\Exception $e){
        //     //     DB::rollBack();
        //     // }
        // }
        // $jd = $data;
        $data = json_decode($input['data']);
        return $data->name;

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        $validated = Validator::make($request->all(), [
            'name' => ['required'],
            'email' => ['required','email','unique:users,email'],
            'password' => ['required','min:8','confirmed'],
            'password_confirmation' => ['required']
        ]);
        if($validated->fails()){
            return response()->json($validated->messages(),400);
        }
        else{
            $data = [
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password)
            ];
            DB::beginTransaction();
            try{
                $user = User::create($data);
                echo $user->id;
                DB::commit();
            } catch (\Exception $e){
                DB::rollBack();
            }
        }
        return(["status" => "successfuly registerd"]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
