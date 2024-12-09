<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function loginProses(Request $request){
        $request->validate([
            'email' => 'required|email:dns',
            'password' => 'required',
        ]);

        $user = $request->only(['email', 'password']);

        if(Auth::attempt($user)){
            return redirect()->route('landing_page');
        } else {
            return redirect()->back()->with('failed', 'Gagal Login! Silahkan Coba Lagi.');
        }
    }

    public function logoutProses(){
        Auth::logout();
        return redirect()->route('login')->with('logout', 'Berhasil Logout!');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $users = User::where('name', 'LIKE', '%' . $request->cari_user . '%')
        ->simplePaginate(5);
        return view('pages.data_user', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('user.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users',
            'role' => 'required',
        ], [
            'name.required' => 'Nama User Harus Diisi!',
            'name.min' => 'Nama User Minimal 3 Karakter!',
            'email.required' => 'Email User Harus Diisi!',
            'email.email' => 'Email User Tidak Valid!',
            'email.unique' => 'Email User Sudah Terdaftar!',
            'role.required' => 'Role User Harus Diisi!',
        ]);

        $password = substr($request->name, 0, 3) . substr($request->email, 0, 3);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($password),
            'role' => $request->role,
        ]);
        
        return redirect()->back()->with('success', 'Berhasil Menambah Data User!');
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
    public function edit($id)
    {
        $user = User::find($id);
        return view('user.edit' , compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email',
            'role' => 'required',
            'password' => 'nullable',
        ], [
            'name.required' => 'Nama User Harus Diisi!',
            'name.min' => 'Nama User Minimal 3 Karakter!',
            'email.required' => 'Email User Harus Diisi!',
            'email.email' => 'Email User Tidak Valid!',
            'email.unique' => 'Email User Sudah Terdaftar!',
            'role.required' => 'Role User Harus Diisi!',
        ]);

        $user = User::find($id);
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => $request->password ?? $user->password,
        ]);

        return redirect()->back()->with('success', 'Berhasil Mengubah Data User!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect()->back()->with('success', 'Berhasil Menghapus Data User!');
    }
}
