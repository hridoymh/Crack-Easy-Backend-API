<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AnswerController extends Controller
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
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = json_decode($request->all()['data'])[0];
        $input = $request->all();
        $validator = Validator::make($input,[
            'qid'=>'required',
            'status'=>'required|integer|between:0,1'
        ]);
        if($validator->fails()){
            return response()->json($validator->messages(),400);
        }
        $data = [
            'userid'=>$user->id,
            'qid'=>$input['qid'],
            'status'=>$input['status'],
        ];
        Answer::create($data);

        return response()->json(['status'=>'success'],200);

    }

    /**
     * Display the specified resource.
     */
    public function show(Answer $answer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Answer $answer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Answer $answer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Answer $answer)
    {
        //
    }
}
