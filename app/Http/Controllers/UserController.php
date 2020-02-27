<?php

namespace App\Http\Controllers;

USE Illuminate\Support\Facades\Crypt;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void 
     */
    public function __construct()
    {
        //
    }
    // funcion para consultar todos los usuarios
    public function index(Request $request)
    {
        if($request->json())
        {
            $User = User::all('first_name', 'last_name', 'email', 'password');
            return response()->json($User,200);
        }
        return response()->json(['error' => "Request should have header 'Accept' with the value : ' Application/json'"], 403);
    }
     
    // funcion para generar el token 
    function str_random($length = 32)
    {
        return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
    }
     
    // funcion para crear un usuario 
    public function CreateUser(Request $request)
    {
        if ($request->json()) 
        {
            $Data = $request->json()->all();
            $Data['password']=Hash::make($request->password);
            $User = User::Create
            ([
                'id' => $request['id'],
                'first_name' => $request['first_name'],
                'last_name' => $request['last_name'],
                'email' => $request['email'],
                'password' => $Data['password'],
                'token' => $this->str_random(32),
                'update_at' => $request['updated_at']
            ]);
            return response()->json([],201);
        }
        return response()->json(['error' => "Request should have header 'Accept' with the value : ' Application/json'"], 403);
    }
       
    //funcion para consultar usuario por id
    
   public function ConsultId($id,Request $request){

    dd($request);
       if ($request->json())
     {
       $User = User::find($id);
       return response()->json($User);
     }
     return response()->json(['error' => "Request should have header 'Accept' with the value : ' Application/json'"], 403);
    }
    // funcion para eliminar por id
    public function DeleteUser(Request $request,$id)
     {
         if($request->json()){
        $User = User::find($id)->delete();
        return response()->json($User, 200);
     }
    return response()->json(['error' => "Request should have header 'Accept' with the value : ' Application/json'"], 403);
    } 

    // funcion de modificar el usuario

    public function ActualizarUser($id, Request $request)
    {
        if($request->json())
        {
            $User = User::find($id);
            $User->update($request->all());
            return response()->json([],204);
        }
        return response()->json(['error' => "Request should have header 'Accept' with the value : ' Application/json'"], 403);
    
    }

    // funcion de login
    public function login(Request $request)
    {  
 
            try{

             
               dd($request);
               
                $User = User::where('email', $request['email'])->first();
           
                if($User && Hash::check($request['password'], $User->password)){
                    return response()->json($User, 200);
                }else{
                    return response()->json(['error' => 'Error in user or password'], 401);
                }
            }catch(ModelNotFoundException $e){
                return response()->json(['error' => 'Error in user or password'], 401);
            }
      
    }
}
        
       

     
      

        
         
 


          

    
 
   
 

   



