<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the users.
     */
    public function index(Request $request)
    {
        $query = User::query();

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('username', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Paginate users
        $users = $query->latest()
            ->paginate(10)
            ->appends($request->query());

        return view('admin.users.index', compact('users'));
    }

    /**
     * Toggle the user's role between admin and user.
     */
    public function toggleRole(User $user)
    {
        // Prevent self-toggle
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'Anda tidak dapat mengubah peran Anda sendiri.');
        }

        // Toggle admin status
        $user->role = $user->role === 'admin' ? 'user' : 'admin';
        $user->save();

        return redirect()->back()->with('success', "Peran untuk {$user->name} berhasil diubah menjadi " . strtoupper($user->role) . ".");
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(User $user)
    {
        // Prevent self-deletion
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        // Delete user 
        $user->delete();

        return redirect()->back()->with('success', "Pengguna {$user->name} berhasil dihapus.");
    }
}
