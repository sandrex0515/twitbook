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
use DB;
use App\like_user;
use App\comment_user;

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
    
    public function logout(){
        return redirect('/home')->with(Auth::logout());

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
            'profilepath' => $filename
        ]);
      
        
    }

    public function update(Request $request, $id){
        $task = User::findorFail($id);
        $task->update($request->all());

        return $task;
    }
    public function updatePost(Request $request){
      

        $table = \DB::table('table_user_posts')->where('post_id', '=', $request->id)->update([
            'post' => $request['post']

        ]);
        return $table;
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
    if($intersect['image'] != ""){
            
        
        $exploded = explode(',', $intersect['image']);

        $decode = base64_decode($exploded[1]);

        if(str_contains($exploded[0], 'jpeg'))
            $extension = 'jpg';
        else
            $extension = 'png';
        
        $filename = str_random().'.'.$extension;

        $path = public_path().'/'.$filename;

        file_put_contents($path, $decode);
    }else{
        $filename = '';
    }
        $id = Auth::user()->id;
        Auth::id();
        
    
        $lastId = new table_user_post();
        $lastId->id = $id;
        $lastId->post = $request['post'];
        $lastId->path = $filename;
        $lastId->save();
        
        $last = DB::getPdo()->lastInsertId();;

        return  
         like_user::create([
            'like_id' => $last
        ]);

        
    }

    public function showPost(){
        $id = Auth::user()->id;
        $id_auth = $id;
        return array(table_user_post::orderBy('created_at', 'desc')->with('user','like_user','comment_user')->get(), json_encode($id_auth),
                        like_user::orderBy('created_at', 'desc')->get()
    );
        
    }

    public function likePost(Request $request){
        $table = \DB::table('like_users')->where('like_id', '=', $request->id)->update(['count_like' =>  DB::raw('count_like + 1'), 'status' => 1]);  
        return $table;
    }

    public function deletePost(Request $request){
        $post_id =  $request->id;
        
        $delete = \DB::table('table_user_posts')->where('post_id', '=', $post_id)->delete();
        // $delete = table_user_post::findOrFail($post_id);

        
    }
}
