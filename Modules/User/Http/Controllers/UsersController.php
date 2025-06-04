<?php

namespace Modules\User\Http\Controllers;

use Modules\User\DataTables\UsersDataTable;
use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Modules\Upload\Entities\Upload;

class UsersController extends Controller
{
    public function index(UsersDataTable $dataTable) {
        abort_if(Gate::denies('access_user_management'), 403);

        return $dataTable->render('user::users.index');
    }

    public function create() {
        abort_if(Gate::denies('access_user_management'), 403);

        return view('user::users.create');
    }

    public function store(Request $request) {
        abort_if(Gate::denies('access_user_management'), 403);

        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|max:255|confirmed',
        ]);

        $user = User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
            'is_active' => $request->has('is_active'),
        ]);

        $user->assignRole($request->role);

        // Handle avatar image
        if ($request->has('image')) {
            $tempFile = Upload::where('folder', $request->image)->first();
            $filePath = 'public/temp/' . $request->image . '/' . ($tempFile->filename ?? null);

            if ($tempFile && Storage::exists($filePath)) {
                $user->addMedia(Storage::path($filePath))->toMediaCollection('avatars');

                Storage::deleteDirectory('public/temp/' . $request->image);
                $tempFile->delete();
            } else {
                toast('Temp image file not found or already deleted.', 'error');
            }
        }

        toast("User Created & Assigned '$request->role' Role!", 'success');

        return redirect()->route('users.index');
    }

    public function edit(User $user) {
        abort_if(Gate::denies('access_user_management'), 403);

        return view('user::users.edit', compact('user'));
    }

    public function update(Request $request, User $user) {
        abort_if(Gate::denies('access_user_management'), 403);

        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
        ]);

        $user->update([
            'name'      => $request->name,
            'email'     => $request->email,
            'is_active' => $request->has('is_active'),
        ]);

        $user->syncRoles($request->role);

        // Handle avatar update
        if ($request->has('image')) {
            $tempFile = Upload::where('folder', $request->image)->first();
            $filePath = 'public/temp/' . $request->image . '/' . ($tempFile->filename ?? null);

            // Delete existing avatar
            if ($user->getFirstMedia('avatars')) {
                $user->getFirstMedia('avatars')->delete();
            }

            if ($tempFile && Storage::exists($filePath)) {
                $user->addMedia(Storage::path($filePath))->toMediaCollection('avatars');

                Storage::deleteDirectory('public/temp/' . $request->image);
                $tempFile->delete();
            } else {
                toast('Temp image file not found or already deleted.', 'error');
            }
        }

        toast("User Updated & Assigned '$request->role' Role!", 'info');

        return redirect()->route('users.index');
    }

    public function destroy(User $user) {
        abort_if(Gate::denies('access_user_management'), 403);

        $user->delete();

        toast('User Deleted!', 'warning');

        return redirect()->route('users.index');
    }
}
