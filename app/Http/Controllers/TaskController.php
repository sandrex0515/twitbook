<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use App\table_user_post;

use Session;

use Illuminate\Foundation\Auth\AuthenticatesUsers;



class TaskController extends Controller
{
    use AuthenticatesUsers;

    public function __construct()
    {
        // $this->middleware('auth');
        
    }
    
    public function index(){
      
        // return User::all();
    }
    public function homes()
    {
        return view('home');
    }

    public function show(){

        $id = Auth::user()->id;


        return User::find($id);
    }

    public function login(Request $request){
      
       
        $credentials = $request->only('email', 'password');

     

        $credentials = [ 'email' => $request->email , 'password' => $request->password ];
  
         if(Auth::attempt($credentials,$request->remember)){ // login attempt


    //login successful, redirect the user to your preferred url/route...
                return redirect('/home');
         
            // return view('home');

         }else{
            return response()->view('errors.custom', [], 404);
        }
    }

    public function store(Request $request){
        
        $collection = collect($request->profilepath);
        $intersect = $collection->intersect($request->profilepath);
        
        $intersect->all();

        $exploded = explode(',', $intersect['image']);

        $decode = base64_decode($exploded[1]);

        if(str_contains($exploded[0], 'jpeg'))
            $extension = 'jpg';
        else
            $extension = 'png';

        $filename = str_random().'.'.$extension;

        $path = public_path().'/'.$filename;

        file_put_contents($path, $decode);
        
       
        
        

        return User::create([
            'name' => $request['names'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            'bday' => $request['bday'],
            'gender' => $request['gender'],
            'profilepath' => $intersect['name']
        ]);
      
        
    }

    public function update(Request $request, $id){
        $task = User::findorFail($id);
        $task->update($request->all());

        return $task;
    }

    public function delete(Request $request, $id){
        $task = User::findorFail($id);
        $task->delete();

        return 204;
    }

    public function home(){
        echo 'hello';
    }

    public function storePost(Request $request){

        $collection = collect($request->profilepath);
        $intersect = $collection->intersect($request->profilepath);
        
        $intersect->all();

        $exploded = explode(',', $intersect['image']);

        $decode = base64_decode($exploded[1]);

        if(str_contains($exploded[0], 'jpeg'))
            $extension = 'jpg';
        else
            $extension = 'png';

        $filename = str_random().'.'.$extension;

        $path = public_path().'/'.$filename;

        file_put_contents($path, $decode);
        
        $id = Auth::user()->id;

        return table_user_post::create([
            'id' => $id,
            'post' => $request['post'],
            'path' => $intersect['name']
        ]);

        
    }

    public function showPost(){
        $id = Auth::user()->id;
        return table_user_post::findMany($id);
    }
}
