<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class Gauth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // $request->bearerToken();
        $input = $request->all();
        $validator = Validator::make(['Bearer'=>$request->bearerToken()], [
            'Bearer' => ['required']
            
        ]);
        if($validator->fails())
        {
            return response($validator->messages(),400);
        }
        $data = gjwt_decode($request->bearerToken());
        if($data['status']=='error'){
            return response(['status'=>'token error']);
        }
        $dbv = Validator::make(['email'=>$data['data']->email],[
            'email'=>['email','unique:users,email']
        ]);
        if(!$dbv->fails()){
            $userinfo = $data['data'];
            $uf = [
                'name' => $userinfo->name,
                'email' => $userinfo->email,
                'password' => 'varified by google',
                'picture' => $userinfo->picture
            ];
            DB::beginTransaction();
            try{
                $user = User::create($uf);
                DB::commit();
            } catch (\Exception $e){
                DB::rollBack();
            }
        }
        else{
            $useremail = $data['data']->email;
            $user = User::where('email',$useremail)->get();
            // var_dump(gettype($user));
        }
        $request->query->add(['data'=>json_encode($user)]);
        return $next($request);
    }
}
