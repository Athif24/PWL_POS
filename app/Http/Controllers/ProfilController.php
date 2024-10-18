<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfilController extends Controller
{
    public function index()
    {
        $user = UserModel::findOrFail(Auth::id());
        $breadcrumb = (object) [
            'title' => 'Data Profil',
            'list' => [
                ['name' => 'Home', 'url' => url('/')],
                ['name' => 'profil', 'url' => url('/profil')]
            ]
        ];
        $activeMenu = 'profil';
        return view('profil', compact('user'), [
            'breadcrumb' => $breadcrumb,
            'activeMenu' => $activeMenu
        ]);
    }
    public function update(Request $request, $id)
    {
        request()->validate([
            'username' => 'required|string|min:3|unique:m_user,username,' . $id . ',user_id',
            'nama'     => 'required|string|max:100',
            'old_password' => 'nullable|string',
            'password' => 'nullable|min:5',
        ]);
        $user = UserModel::find($id);
        $user->username = $request->username;
        $user->nama = $request->nama;
        if ($request->filled('old_password')) {
            if (Hash::check($request->old_password, $user->password)) {
                $user->update([
                    'password' => Hash::make($request->password)
                ]);
            } else {
                return back()
                    ->withErrors(['old_password' => __('Please enter the correct password')])
                    ->withInput();
            }
        }
        if (request()->hasFile('profile_image')) {
            if ($user->profile_image && file_exists(storage_path('app/public/photos/' . $user->profile_image))) {
                Storage::delete('app/public/photos/' . $user->profile_image);
            }
            $file = $request->file('profile_image');
            $fileName = $file->hashName() . '.' . $file->getClientOriginalExtension();
            $request->profile_image->move(storage_path('app/public/photos'), $fileName);
            $user->profile_image = $fileName;
        }
        $user->save();
        return back()->with('status', 'Profil Diperbarui');
    }
}
