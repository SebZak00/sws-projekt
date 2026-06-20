<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    public function updateRole(Request $request, User $user)
    {
        $request->validate(['role' => 'required|in:admin,organizator,uzytkownik']);
        $user->update(['role' => $request->role]);
        return back()->with('success', 'Rola użytkownika została zaktualizowana.');
    }
}