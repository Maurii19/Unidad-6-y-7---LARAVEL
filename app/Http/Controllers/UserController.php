<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Spatie\Permission\Models\Role;
use DB;
use Hash;
use Response;
use Cookie;
use Auth;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * 
     */
    function __construct()
    {
         $this->middleware('permission:Listar usuario');
         $this->middleware('permission:Crear usuario', ['only' => ['create','store']]);
         $this->middleware('permission:Editar usuario', ['only' => ['edit','update']]);
         $this->middleware('permission:Eliminar usuario', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $users = User::orderBy('id','DESC')->paginate(5);
        $email = cookie('email',Auth::user()->email, 6);
        $request->session()->put('id', Auth::user()->id);
        return response(view('users.index',compact('users'))->with('i', ($request->input('page', 1) - 1) * 5))->cookie($email);
            
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::pluck('name','name')->all();
        return view('users.create',compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'roles' => 'required'
        ],[
            'name.required' => 'Introduce un nombre.',
            'email.required' => 'Introduce un email.',
            'email.email' => 'Introduce un email valido.',
            'email.unique' => 'El email ya existe.',
            'password.required' => 'Introduce una contraseña',
            'password.same' => 'Las contraseñas no coinciden',
            'roles.required' => 'Elige uno o varios roles'



        ]);


        $input = $request->all();
        $input['password'] = Hash::make($input['password']);


        $user = User::create($input);
        $user->assignRole($request->input('roles'));


        return redirect()->route('users.index')
                        ->with('success','El usuario ha sido creado!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        return view('users.show',compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::pluck('name','name')->all();
        $userRole = $user->roles->pluck('name','name')->all();


        return view('users.edit',compact('user','roles','userRole'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'same:confirm-password',
            'roles' => 'required'
        ],
        [

            'name.required' => 'Introduce un nombre.',
            'email.required' => 'Introduce un email.',
            'email.email' => 'Introduce un email valido.',
            'email.unique' => 'El email ya existe.',
            'password.required' => 'Introduce una contraseña',
            'password.same' => 'Las contraseñas no coinciden',
            'roles.required' => 'Elige uno o varios roles'
        ]);


        $input = $request->all();
        if(!empty($input['password'])){ 
            $input['password'] = Hash::make($input['password']);
        }else{
            $input = array_except($input,array('password'));    
        }


        $user = User::find($id);
        $user->update($input);
        DB::table('model_has_roles')->where('model_id',$id)->delete();


        $user->assignRole($request->input('roles'));


        return redirect()->route('users.index')
                        ->with('success','El usuario ha sido actualizado!!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->delete();
        return redirect()->route('users.index')
                        ->with('success','El usuario ha sido eliminado');
    }
}
