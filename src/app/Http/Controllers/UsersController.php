<?php

namespace App\Http\Controllers;

use Gate;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\User;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', [
            'except' => ['show', 'create', 'store', 'index']
        ]);
    }

    public function create()
    {
        return view('users.create');
    }

    public function show(User $users)
    {
        // $user = User::findOrFail($users);
        // var_dump($users);
//         $user = User::first();
        // var_dump(config('database.connections.mysql'));
        // var_dump($user->name);
        // var_dump(compact('user'));
        // $this->authorize('show', $users);
        $this->authorize($users);
        $user = $users;
        return view('users.show', compact('user'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:50',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|confirmed|min:6'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
        session()->flash('success', '欢迎，您将在这里开启一段新的旅程~');
        return redirect()->route('users.show', [$user]);
    }

    public function edit(User $users)
    {
        $user = $users;
        $this->authorize('update', $user);
        return view('users.edit', compact('user'));
    }

    public function update(User $users, Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:50',
            'password' => 'required|confirmed|min:6'
        ]);
      
        $this->authorize('update', $users);

        $user = $users;
        
        $user->update([
            'name' => $request->name,
            'password' => bcrypt($request->password),
        ]);

        return redirect()->route('users.show', $user->id);
    }

    public function index()
    {
        $users = User::paginate(10);
        return view('users.index', compact('users'));
    }

    public function destroy(User $user)
    {
        $this->authorize('destroy', $user);
        $user->delete();
        session()->flash('success', '成功删除用户！');
        return back();
    }
}