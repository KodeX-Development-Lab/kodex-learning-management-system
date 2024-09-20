<?php

namespace App\Modules\Auth\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Modules\Auth\Http\Requests\ChangePasswordRequest;
use App\Modules\Auth\Http\Requests\LoginRequest;
use App\Modules\Auth\Http\Requests\RegisterRequest;
use App\Modules\Storage\Classes\ObjectStorage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    private $storage;

    public function login(LoginRequest $request)
    {
        $request->validated($request->only(['email', 'password']));

        if (!Auth::attempt($request->only(['email', 'password']))) {
            return response()->json([
                "status"  => false,
                "data"    => null,
                "message" => "Incorrect Email and/or Password",
            ], 401);
        }

        $user = User::where('email', $request->email)->first();

        $token = $request->user()->createToken("LARAVEL_TOKEN");

        return response()->json([
            "status"  => true,
            "data"    => [
                'user'  => $user,
                'token' => $token->plainTextToken,
            ],
            "message" => "Login successful",
        ], 200);
    }

    public function getAuthUser()
    {
        $user = Auth::user();

        if ($user) {
            return response()->json([
                "status"  => true,
                'data'    => [
                    'user' => $user,
                ],
                'message' => 'Success',
            ], 200);
        } else {
            return response()->json([
                'status'  => false,
                'message' => "Session expired or Invalid Credentials",
            ], 401);
        }
    }

    //change password
    public function changePassword(ChangePasswordRequest $request)
    {
        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                "status"  => false,
                "data"    => null,
                "message" => "Current password is incorrect.",
            ], 401);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        $user->currentAccessToken()->delete();

        return response()->json([
            "status"  => true,
            "message" => "Password Changed Successfully. Login again",
        ], 200);
    }

    public function register(RegisterRequest $request)
    {
        $request->validated($request->only(['name', 'email', 'password']));

        $this->storage = new ObjectStorage();
        $profile_image = $this->storage->store('profile_images', $request->file('profile_image'));

        $user = User::create([
            'name'          => $request->name,
            'slug'          => Str::slug($request->name),
            'email'         => $request->email,
            'profile_image' => $profile_image,
            'password'      => Hash::make($request->password),
        ]);

        $user->assignRole('Student');

        $token = $user->createToken('API Token')->plainTextToken;

        return response()->json([
            "status"  => 200,
            "data"    => [
                "user"  => $user,
                "token" => $token,
            ],
            "message" => "Registration successful",
        ], 200);

    }

    public function logout()
    {
        auth()->user()->currentAccessToken()->delete();

        return response()->json([], 204);
    }
}
