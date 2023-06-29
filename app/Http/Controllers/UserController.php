<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use JWTAuth;

class UserController extends Controller
{
    //

    public function __construct(){
        $this->middleware('auth:api', ['except'=>['login','register']]);
    }

    public function login(Request $request){

        $user_login = [
            "tel"=>$request->tel,
            "password"=>$request->password
        ];

        $token = JWTAUTH::attempt($user_login);
        $user = Auth::user();

        if(!$token){
            return response()->json([
                'success' => false,
                'message' => 'ເບີໂທ ຫລື ລະຫັດຜ່ານບໍ່ຖຶກຕ້ອງ'
            ], 401);
        } else {
            return response()->json([
                'success' => true,
                'message' => 'ສຳເລັດ',
                'user' => $user,
                'authorisation' => [
                    'token' => $token,
                    'type' => 'bearer'
                ]
            ]);
        }

    }

    public function logout(){
        $token = Auth::getToken();
        $invalidate = Auth::invalidate($token);

        if($invalidate){
            return response()->json([
                'success' => true,
                'message' => 'ອອກຈາກລະບົບສຳເລັດ',
            ]);
        }

    }


    public function register(Request $request){

        try{

            $check_user = User::all();

            if($check_user->count()==0){
                $user_type = 'admin';
            } else {
                $user_type = 'user';
            }

            if($request->file('image')){
                $upload_path = "img";
                $generate_new_name = time().'.'.$request->image->getClientOriginalExtension();
                $request->image->move(public_path($upload_path),$generate_new_name);

                $user = new User();
                $user->name = $request->name;
                $user->last_name = $request->last_name;
                $user->gender = $request->gender;
                $user->image = $generate_new_name;
                $user->tel = $request->tel;
                $user->birth_day = $request->birth_day;
                $user->add_village = $request->add_village;
                $user->add_city = $request->add_city;
                $user->add_province = $request->add_province;
                $user->web = $request->web;
                $user->job = $request->job;
                $user->job_type = $request->job_type;
                $user->user_type = $user_type;
                $user->email = $request->email;
                $user->password = hash::make($request->password);
                $user->save();

            } else {
                $generate_new_name = '';
                $user = new User();
                $user->name = $request->name;
                $user->last_name = $request->last_name;
                $user->gender = $request->gender;
                $user->image = $generate_new_name;
                $user->tel = $request->tel;
                $user->birth_day = $request->birth_day;
                $user->add_village = $request->add_village;
                $user->add_city = $request->add_city;
                $user->add_province = $request->add_province;
                $user->web = $request->web;
                $user->job = $request->job;
                $user->job_type = $request->job_type;
                $user->user_type = $user_type;
                $user->email = $request->email;
                $user->password = hash::make($request->password);
                $user->save();
            }

           

            $success = true;
            $message = "ລົງທະບຽນສຳເລັດ";

        } catch (\Illuminate\Database\QueryException $ex) {
            $success = false;
            $message = $ex->getMessage();
        }

        $response = [
            'success' => $success,
            'message' => $message,
        ];
        return response()->json($response);

    }

    public function check_user(){

            $user = Auth::user(); // Auth::user()
            $user_all = User::all();

            $response = [
                'user'=> $user,
                'user_all'=> $user_all,
            ];
            return response()->json($response);
    }

    public function index(){
        $user = User::all();
        // return $user;

        $response = [
            'user' => $user,
        ];
        return response()->json($response);
    }

    public function user($id){
            $user = User::find($id);
            return $user;
    }

    public function add_user(Request $request){

        try{

            $user = new User();
            $user->name = $request->name;
            $user->last_name = $request->last_name;
            $user->gender = $request->gender;
            $user->image = $request->image;
            $user->tel = $request->tel;
            $user->birth_day = $request->birth_day;
            $user->add_village = $request->add_village;
            $user->add_city = $request->add_city;
            $user->add_province = $request->add_province;
            $user->add_detail = $request->add_detail;
            $user->web = $request->web;
            $user->job = $request->job;
            $user->job_type = $request->job_type;
            $user->user_type = $request->user_type;
            $user->email = $request->email;
            $user->password = $request->password;
            $user->save();

            $success = true;
            $message = "ເພີ່ມຂໍ້ມູນຜູ້ໃຊ້ສຳເລັດ";

        } catch (\Illuminate\Database\QueryException $ex) {
            $success = false;
            $message = $ex->getMessage();
        }

        $response = [
            'success' => $success,
            'message' => $message,
        ];
        return response()->json($response);

    }

    public function update_user($id,Request $request){

        try{

           $user = User::find($id);

        //    return $request->image->getClientOriginalExtension();

           if($request->file('image')){


                $upload_path = "img";

                // ກວດຊອບຮູບເກົ່າໃຫ້ທຳການລຶບອອກ
                if($user->image!='' && $user->image!=null){
                    if(file_exists('img/'.$user->image)){
                        unlink('img/'.$user->image);
                    }
                }


                $generated_new_name = time().'.'.$request->image->getClientOriginalExtension();
                $request->image->move(public_path($upload_path),$generated_new_name);


            if($request->password){
                $user->update([
                    'name' => $request->name,
                    'last_name' => $request->last_name,
                    'gender' => $request->gender,
                    'password' => Hash::make($request->password),
                    'image' => $generated_new_name,
                    'tel' => $request->tel,
                    'birth_day' => $request->birth_day,
                    'add_village' => $request->add_village,
                    'add_city' => $request->add_city,
                    'add_province' => $request->add_province,
                    'add_detail' => $request->add_detail,
                    'email' => $request->email,
                    'web' => $request->web,
                    'job' => $request->job,
                    'job_type' => $request->job_type,
                ]);
        
    
               }else{
                
                $user->update([
                    'name' => $request->name,
                    'last_name' => $request->last_name,
                    'gender' => $request->gender,
                    // 'password' => Hash::make($request->password),
                    'image' => $generated_new_name,
                    'tel' => $request->tel,
                    'birth_day' => $request->birth_day,
                    'add_village' => $request->add_village,
                    'add_city' => $request->add_city,
                    'add_province' => $request->add_province,
                    'add_detail' => $request->add_detail,
                    'email' => $request->email,
                    'web' => $request->web,
                    'job' => $request->job,
                    'job_type' => $request->job_type,
                ]);
        
               }

           
        } else {
            if($request->password){
                $user->update([
                    'name' => $request->name,
                    'last_name' => $request->last_name,
                    'gender' => $request->gender,
                    'password' => Hash::make($request->password),
                    // 'image' => $generated_new_name,
                    'tel' => $request->tel,
                    'birth_day' => $request->birth_day,
                    'add_village' => $request->add_village,
                    'add_city' => $request->add_city,
                    'add_province' => $request->add_province,
                    'add_detail' => $request->add_detail,
                    'email' => $request->email,
                    'web' => $request->web,
                    'job' => $request->job,
                    'job_type' => $request->job_type,
                ]);
        
    
               }else{
                
                $user->update([
                    'name' => $request->name,
                    'last_name' => $request->last_name,
                    'gender' => $request->gender,
                    // 'password' => Hash::make($request->password),
                    // 'image' => $generated_new_name,
                    'tel' => $request->tel,
                    'birth_day' => $request->birth_day,
                    'add_village' => $request->add_village,
                    'add_city' => $request->add_city,
                    'add_province' => $request->add_province,
                    'add_detail' => $request->add_detail,
                    'email' => $request->email,
                    'web' => $request->web,
                    'job' => $request->job,
                    'job_type' => $request->job_type,
                ]);
        
               }
        }

          

          

            $success = true;
            $message = "ອັບເດດຂໍ້ມູນສຳເລັດ";

        } catch (\Illuminate\Database\QueryException $ex) {
            $success = false;
            $message = $ex->getMessage();
        }

        $response = [
            'success' => $success,
            'message' => $message,
        ];
        return response()->json($response);

    }

    public function delete_user($id){
        try{

            $user = User::find($id);
            $user->delete();

           

            $success = true;
            $message = "ລຶບຂໍ້ມູນສຳເລັດ";

        } catch (\Illuminate\Database\QueryException $ex) {
            $success = false;
            $message = $ex->getMessage();
        }

        $response = [
            'success' => $success,
            'message' => $message,
        ];
        return response()->json($response);
    }
}
