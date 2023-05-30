<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Requests\User\StoreRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['users'] = User::where('id', '!=', Auth::user()->id)->orderBy('id', 'desc')->get();
        
        return response()->view('user.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return response()->view('user.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request): RedirectResponse
    {
        $validated = $request->validated();        

        $user = User::create($validated);

        if($user) {
            // Alert flash for the success notification
            session()->flash('notif.success', 'User Added successfully!');
            return redirect()->route('users.index');
        }

        return abort(500);
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit($id)
    {
        $data['user'] = User::findOrFail($id);
        return response()->view('user.edit', $data);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $user = User::findOrFail($id);
        $data = $request->all();

        $update = $user->update($data);

        return Redirect::route('users.edit', $id)->with('status', 'profile-updated');
    }
    /**
     * Delete the user's account.
     */
    public function destroy(Request $request, $id): RedirectResponse
    {
        $user = User::findOrFail($id);

        $delete = $user->delete($id);

        if($delete) {
            session()->flash('notif.success', 'User deleted successfully!');
            return redirect()->route('users.index');
        }

        return abort(500);
    }
}
