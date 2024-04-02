<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class UserManagementController extends Controller
{
    public function view_users(){
        //get all users from users tb
        $users = User::where('role_id' , 2)->get();
        return response()->json(['succces' => true, 'users' => $users] , 200);
    }
    /**
     * Create a new user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create_user(Request $request): JsonResponse
    {
        $validateData = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6'
        ]);
        //storing new user to db
        $roleId = $request->input('role_id' , 2);
        $user = new user();
        $user->name = $validateData['name'];
        $user->email = $validateData['email'];
        $user->password = Hash::make($validateData['password']);
        $user->role_id = $roleId;
        $user->save();
        return response()->json(['success' => true, 'message'=> 'Admin added user successfully', 'user'=>$user] ,201);
    }
    //edit functionality
    /**
     * Edit an existing user (retrieve user data for editing).
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit_user(Request $request , $id): JsonResponse
    {
        $edit = User::findOrFail($id);
        return response()->json(['edit' => $edit], 200);
    }
    /**
     * Update an existing user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request , $id): JsonResponse
    {
        $validation = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users,email,'.$id,
        ]);
        $user = User::findOrFail($id);
        $user->name = $validation['name'];
        $user->email = $validation['email'];
        $user->save();
        return response()->json(['success' => true, 'message' , 'User updated successfully' , 'user'=>$user] , 200);
    }
    //delete functionality
    /**
     * Delete an existing user.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete_user(Request $request , $id): JsonResponse
    {
        $del_user = User::findOrFail($id);
        $del_user->delete();
        return response()->json(['success' => true, 'message', 'user deleted successfully' , 'user'=>$del_user], 200);
    }
}
