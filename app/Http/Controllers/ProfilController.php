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
            'nama' => 'required|string|max:100',
            'old_password' => 'nullable|string',
            'password' => 'nullable|min:5',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);
    
        $user = UserModel::find($id);
    
        $user->username = $request->username;
        $user->nama = $request->nama;
    
        // Handle password update
        if ($request->filled('old_password')) {
            if (Hash::check($request->old_password, $user->password)) {
                if ($request->filled('password')) {
                    $user->password = Hash::make($request->password);
                }
            } else {
                return back()
                    ->withErrors(['old_password' => __('Please enter the correct password')])
                    ->withInput();
            }
        }
    
        // Handle profile image update
        if ($request->hasFile('profile_image')) {
            // Delete old image if exists
            if ($user->profile_image) {
                $oldImagePath = public_path('photos/' . $user->profile_image);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
    
            // Generate unique filename
            $fileName = time() . '_' . $request->file('profile_image')->getClientOriginalName();
            
            // Move file to public/photos directory
            $request->file('profile_image')->move(public_path('photos'), $fileName);
            
            // Update database with new filename
            $user->profile_image = $fileName;
        }
    
        $user->save();
    
        return back()->with('status', 'Profil Diperbarui');
    }
}
