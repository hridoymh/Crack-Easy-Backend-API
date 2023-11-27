<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request,$count=20,$page=1)
    {

        $ques = Question::with('categories')->skip(($page-1)*$count)->take($count)->get();
        // var_dump($ques[0]);
        return response()->json($ques,200); 
    }

    public function getByCat(Request $request,$cat,$count=20,$page=0)
    {
        $cats = Category::where('cat',$cat)->skip(($page-1)*$count)->take($count)->get();

        $ques = array();
        foreach ($cats as $cat) {
            array_push($ques,$cat->question);
        }
        
        // $ques = Question::orderBy('created_at', 'desc')->skip(($page-1)*$count)->take($count)->get();
        return response()->json($ques,200); 
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
        // echo $user->id;
        //
        // var_dump($request->all());
        $input = $request->all();
        // echo $input['cat'][0];
        $validator = Validator::make($input,[
            'question'=>'required|unique:questions,questionStatement',
            'a'=>'required',
            'b'=>'required',
            'c'=>'required',
            'd'=>'required',
            'ans'=>'required',
            'prevoc'=>'required'
            
        ]);
        if($validator->fails()){
            return response()->json($validator->messages(),400);
        }
        $data = [
            'ownerid'=>$user->id,
            'questionStatement'=> $input['question'],
            'a'=> $input['a'],
            'b'=> $input['b'],
            'c'=> $input['c'],
            'd'=> $input['d'],
            'ans'=> $input['ans'],
            'prevoc'=> $input['prevoc']
            
        ];

        DB::beginTransaction();
        try{
            $question = Question::create($data);
            DB::commit();
        } catch (\Exception $e){
            DB::rollBack();
            return response()->json(['status'=>'database error'],500);
        }

        
        $cats = $input['cat'];
        $prep = [];
        foreach($cats as $cat){
            $temp = [
                'qid'=>$question->id,
                'cat'=>$cat
            ];
            array_push($prep,$temp);
        }
        Category::insert($prep);
        

        return response()->json(['status'=>'succesfully question added']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Question $question)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Question $question)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Question $question)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Question $question)
    {
        //
    }
}
