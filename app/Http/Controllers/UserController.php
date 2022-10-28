<?php

namespace App\Http\Controllers;

use App\User;
use App\Company;
use App\Department;
use App\Role;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //
    //
    public function users()
    {
        $users = User::with('department', 'company', 'role', 'approver')->orderBy('status')->get();
        // dd($users); 
        // dd($users);
        $companies = Company::get();
        $departments = Department::get();
        $roles = Role::get();
        return view(
            'users',
            array(
                'subheader' => 'Users',
                'header' => "Settings",
                'users' => $users,
                'companies' => $companies,
                'departments' => $departments,
                'roles' => $roles,
            )
        );
    }

    public function new_account(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:3|max:50',
            'email' => 'email|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);

        $new_account = new User;
        $new_account->name = $request->name;
        $new_account->email = $request->email;
        $new_account->company_id = $request->company;
        $new_account->department_id = $request->department;
        $new_account->role_id = $request->role;
        // $new_account->role = 1;
        $new_account->password = bcrypt($request->password);
        $new_account->save();
        $request->session()->flash('status', 'Successfully created');
        return back();
    }
    public function delete_account(Request $request)
    {

        DB::table('Users')
            ->where('id', $request->id)

            ->delete();

        echo "Success";
    }
    public function changepassword(Request $request, $id)
    {
        $this->validate($request, [
            'password' => 'required|confirmed|min:6',
        ]);

        $user = User::where('id', $id)->first();
        $user->password = bcrypt($request->password);
        $user->save();
        $request->session()->flash('status', 'Successfully change password');
        return back();
    }

    public function deactivate_user(Request $request)
    {
        $user = User::where('id', $request->id)->first();
        $user->status = 1;
        $user->password = "";
        $user->save();

        return "success";
    }
    public function activate_user(Request $request)
    {
        $user = User::where('id', $request->id)->first();
        $user->status = "";
        $user->password = "";
        $user->save();

        return "success";
    }
    public function edit_user(Request $request, $id)
    {
        dd($request);

        $this->validate($request, [
            'email' => 'unique:users,email,' . $id,
        ]);

        $account = User::where('id', $id)->first();
        $account->name = $request->name;
        $account->email = $request->email;
        $account->company_id = $request->company;
        $account->approver_id = $request->approver;
        $account->department_id = $request->department;
        $account->role_id = $request->role;
        // $new_account->role = 1;
        $account->save();
        $request->session()->flash('status', 'Successfully updated');
        return back();
    }
}
