<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // Show users with pagination
    public function index(Request $request)
    {
        $query = User::query();

        // Sorting
        if ($request->has('sort')) {
            $direction = $request->input('direction', 'asc');
            $query->orderBy($request->input('sort'), $direction);
        }
    
        // Searching (if you have existing search logic)
        if ($request->filled('search_field') && $request->filled('search_value')) {
            $query->where($request->search_field, 'like', '%' . $request->search_value . '%');
        }
    
        $users = $query->paginate(10);
    
        return view('users.index', compact('users'));
    }

    // Show the form to create a new user
    public function create()
    {
        return view('users.create');
    }

    // Store a new user
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|max:15',
            'password' => 'required|min:8|confirmed',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'password' => bcrypt($validated['password']),
        ]);

        return redirect()->route('users')->with('success', 'User created successfully!');
    }

    // Show user data for editing
    public function edit($id)
    {
        
        $user = User::findOrFail($id);
        return view('users.edit', compact('user'));
    }

    // Update user data
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'phone' => 'required|max:15',
            'password' => 'nullable|min:8|confirmed',
        ]);

        $user = User::findOrFail($id);
        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'password' => $validated['password'] ? bcrypt($validated['password']) : $user->password,
        ]);

        return redirect()->route('users')->with('success', 'User updated successfully!');
    }
    // Show the user details
    public function show($id)
    {
    $user = User::findOrFail($id);
    return view('users.show', compact('user'));
    }


    // Delete user
    public function destroy($id)
    {
        User::destroy($id);
        return redirect()->route('users')->with('success', 'User deleted successfully!');
    }
}
