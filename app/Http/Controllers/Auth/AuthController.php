<?php
namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\ApiController;

class AuthController extends ApiController
{
    public function register(Request $request)
    {
        $reglas=[
          'nombre'=>'required',
          'email' => 'required|email|unique:users',
          'password'  => 'required|min:6',
        ];

        $this->validate($request,$reglas);

        $user= User::create([
            'nombre' => $request->nombre,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $credentials = $request->only('email', 'password');
        //dd($credentials);

        if ($token = $this->guard()->attempt($credentials) ) {

            return $this->success(['usuario'=>$user,'acces_token'=>"Bearer ".$token],200);
        }
        return $this->showOne($user);
    }

    public function login(Request $request)
    {
        //return $request->all();
        $credentials = $request->only('email', 'password');

        if ($token = $this->guard()->attempt($credentials)) {
            //return response()->json(['status' => 'success'], 200)->header('Authorization', $token);
            return $this->success(['access_token'=>$token,'usuario'=>$this->user()],200)->header('Authorization', $token);
        }
        return $this->errorResponse('Usuario o contraseña incorrecta, intene nuevamente', 401);
    }

    public function logout()
    {
        $this->guard()->logout();
        return $this->success('Sesión finalizada');
    }

    public function user()
    {
        $user = User::find(Auth::user()->id);
        $permisos=$user->getAllPermissions();
        $user->toArray();

        $user['permisos']=$permisos;

        return $user;
    }

    public function refresh()
    {
        if ($token = $this->guard()->refresh()) {
            return $this->success(['acces_token'=>$token]);
        }
        return $this->errorResponse('Access Token, no actualizado',401);
    }

    public function userPermisos()
    {
        $user = User::find(Auth::user()->id);
        $permisos=$user->getAllPermissions();
        return $this->success($permisos,200);

    }

    private function guard()
    {
        return Auth::guard();
    }
}
