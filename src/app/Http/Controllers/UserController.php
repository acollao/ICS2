<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules;
use PhpParser\Node\Stmt\TryCatch;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin'); // or any other middleware you have.
    }

    public function index()
    {
        $users = DB::table('users')
            ->join('roles', 'users.role_id', '=', 'roles.id')
            ->select('users.*', 'roles.id as roleId', 'roles.role')->get();
        return view('pages.user.index', [
            'users' => $users
        ]);
    }

    public function add()
    {
        $roles = Role::all();
        return view('pages.user.add',[
            'roles' => $roles
        ]);
    }

    public function store(Request $request)
    {
        $rules = [
            'username' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'role' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->route('user.add')->withInput()->withErrors($validator);
        } else {
            $data = $request->input();
            try {
                //code...
                $user = new User;
                $user->username = $data['username'];
                $user->name = $data['name'];
                $user->email = $data['email'];
                $user->role_id = $data['role'];
                $user->password = Hash::make($data['password']);
                $user->save();
                return redirect()->route('user.index')->with('status', 'User has been created successfully');
            } catch (\Exception  $e) {
                //throw $th;
                //DD($e);
                return redirect()->route('user.add')->with('failed', $e->getMessage());
            }
        }



        // User::create([
        //     'username' => $request->username,
        //     'name' => $request->name,
        //     'email' => $request->email,
        //     'password' => Hash::make($request->password),
        //     'role_id' => $request->role_id,
        // ]);

        return redirect()->route('user.index')->with('status', 'User has been created successfully');
    }

    public function createUser()
    {
        return view('pages.user.create');
    }

    public function editUser($id)
    {
        $user = DB::table('users')->where('id', '=', $id)->get();

        return view('pages.user.edit', [
            'user' =>  $user,
        ]);
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'username' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'role' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors(['status' => 'Unable to update due to validatio rules.']);
        } else {
            $data = $request->input();
            try {
                //code...
                $res = DB::table('users')
                    ->where('id', $id)
                    ->update(
                        [
                            'username' => $data['username'],
                            'name' => $data['name'],
                            'email' => $data['email'],
                            'role_id' => $data['role']
                        ]
                    );

                if ($res) {
                    return redirect()->route('user.index')->with('status', 'User has been updated successfully');
                } else {
                    return redirect()->back()->withErrors(['status' => 'Unable to update.']);
                }
            } catch (\Exception  $e) {
                //throw $th;
                //DD($e);
                return redirect()->route('user.add')->with('failed', $e->getMessage());
            }
        }

        return $this->success('status', 'Profile updated successfully!');
    }

    public function delete(Request $request)
    {

        $id = $request->input('id');
        $res = User::find($id)->delete();
        if ($res) {
            //return redirect()->route('user.index')->with('status', 200);
            return response()->json([
                'message' => "Deleted successfully.",
                'status' => 200,
            ]);
        }
        return response()->json(['status' => 'false', 'message' => 'Error in deleting records'], 400);
    }
}
