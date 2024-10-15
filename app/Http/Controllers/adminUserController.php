<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;

class adminUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $users = User::with('roles')->get();
        return view('admin.users.index', compact('users'));
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $roleId = $request->role_id;
        $role = Role::findOrFail($roleId);
        if ($request->action === 'updateRole') {
            $user = User::findOrFail($id);
            $user->roles()->sync([$roleId]);
            $user->role = $role->name; 
            $user->save(); 
            return response()->json(['message' => 'Role updated successfully'], 200);
        }
    }


    /**
     * Remove the specified resource from storage.
     */

    public function destroy(string $id){
        $user = User::findOrFail($id);
        $user->roles()->detach();
        $user->delete();   
        return response()->json(['message' => 'User deleted successfully'], 200);
    }
}
