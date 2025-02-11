<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules;
use App\Providers\RouteServiceProvider; 

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:update,user')->only(['edit', 'update']);
        $this->middleware('can:delete,user')->only(['destroy']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::orderBy('created_at', 'desc')->paginate(10);
        return view('admins.users.index', compact('users'));
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
    public function store(StoreUserRequest $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
    
        $role = $request->input('role', 'customer');
    
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $role,
        ]);
    
        Auth::login($user);
    
        return redirect(RouteServiceProvider::HOME);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return view('admins.users.show', compact('user'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('admins.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        // Validation cho các trường cần thiết
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,customer',
            'password' => 'nullable|min:3|confirmed',
        ]);

        $data = $request->only(['name', 'email', 'role']);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);
        if (Auth::user()->id === $user->id && $request->role !== 'admin') {
            Auth::logout(); // Đăng xuất nếu tự hạ cấp quyền
            return redirect()->route('login')->with('warning', 'Quyền của bạn đã thay đổi. Vui lòng đăng nhập lại!');
        }
        return redirect()->route('users.index')->with('success', 'Cập nhật thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'Người dùng đã bị xóa.');
    }
}
