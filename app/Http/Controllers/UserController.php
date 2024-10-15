<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{

    public function index()
    {
        $users = User::select('id', 'name', 'lastname', 'telephone', 'email')
            ->get();
        return response()->json(['success' => true, 'data' => $users], 200);
    }

    public function signup(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|min:2|max:20',
            'lastname' => 'required|min:2|max:20',
            'telephone' => 'required|min:10|max:30',
            'email' => 'required|email|unique:users'
        ]);
        if ($validated) {
           $reg = DB::table('users')->insert([
                'name' => $request->input('name'),
                'lastname' => $request->input('lastname'),
                'telephone' => $request->input('telephone'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password')),
            ]);
            if ($reg) {
                return response()->json(['success' => true], 200);
            } else {
                return response()->json(['success' => false, 'error' => 'Failed to insert data'], 500);
            }
            
        }
    }

    public function login(Request $request){        
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $token = $request->user()->createToken('Login Token')->accessToken;
            return response()->json(['success' => true, 'token' => $token,'user' => $request->user(),'message' => 'Login Sucessfully.'], 200);
        }else{
            return response()->json(['success' => false, 'message' => 'Login Fail, no matches in our database']);
        }
    }

    public function logout()
    {
        session()->flush();
        Auth::logout();
        return response()->json(['message' => 'Logout successful']);
    }

    public function updateProfile(Request $request, $user_id)
    {
        $user = User::find($user_id);
        
        $validated = $request->validate([
            'name' => 'required|min:2|max:20',
            'lastname' => 'required|min:2|max:20',
            'telephone' => 'required|min:10|max:30',
        ]);
        DB::table('users')->where('id', $user_id)->update([
            'name' => $request->name,
            'lastname' => $request->lastname,
            'telephone' => $request->telephone,
        ]);
        $user = User::find($user_id);
        return response()->json(['success' => true, 'message' => 'Profile updated successfully', 'data' => $user]);
        
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'required',
            'lastname' => 'required',
            'telephone' => 'required',
            'email' => 'required',
        ]);

        DB::table('users')->where('id', $id)->update([
            'name' => $request->name,
            'lastname' => $request->lastname,
            'telephone' => $request->telephone,
            'email' => $request->email,
        ]);

        return response()->json([
            'data' => $user,
            'message' => 'User updated successfully',
        ]);
    }

    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['success' => false, 'message' => 'User not found'], 404);
        }

        $user->delete();

        return response()->json(['success' => true, 'message' => 'User deleted successfully']);
    }

}