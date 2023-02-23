<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Carbon\Carbon;
use App\Mail\WelcomeMail;
use Illuminate\Http\Request;
use App\Mail\PasswordResetMail;
use Illuminate\Http\JsonResponse;
use App\Mail\WelcomeUnknowingMail;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Carbon\Exceptions\InvalidFormatException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;

class AuthController extends Controller
{
    /**
     * Authenticate admin users
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function loginAdmin(Request $request)
    {
        $credentials = $request->only(['email', 'password']);

        // Quick check if admin user is active
        $user = User::where('email', $request->email)->first();
        if ($user && $user->status == 'inactive') {
            return response()->json(['error' => 'Account deactivated'], 401);
        }

        if (!$token = Auth::attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return response()->json([
            'access_token' => $token,
            'user' => Auth::user()
        ]);
    }

    /**
     * Authenticate users
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function login(Request $request)
    {
        $credentials = $request->only(['email', 'password']);

        if (!$token = Auth::attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return response()->json([
            'access_token' => $token,
            'user' => Auth::user()
        ]);
    }

    /**
     * Register users
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function register(Request $request)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Bad Request',
                'errors' => $validator->errors(),
            ], 400);
        }

        // Get correct special date from carbon
        try {
            $request->special_date = $request->special_date ? Carbon::parse($request->special_date) : Carbon::now();
        } catch (InvalidFormatException $e) {
            $request->special_date = Carbon::now();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'special_date' => $request->special_date,
            'piggyvest_id' => $request->piggyvest_id,
            'address' => $request->address,
            'address_2' => $request->address_2,
            'location_id' => $request->location_id,
            'password' => Hash::make($request->password),
        ]);

        if (!$token = Auth::attempt($request->only(['email', 'password']))) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        Mail::to(Auth::user())->send(new WelcomeMail($user));

        return response()->json([
            'access_token' => $token,
            'user' => Auth::user()
        ]);
    }

    /**
     * Register Admin
     *
     * @param Request $request
     * @return void
     */
    public function registerAdmin(Request $request)
    {
        Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'admin_role' => 'required'
        ])->validate();

        $user = User::create($request->all());

        return  response()->json($user, 201);
    }

    /**
     * Register users unknowing
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function registerUnknowing(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if ($user){
            return response()->json([
                'user' => $user
            ]);
        }
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Bad Request',
                'errors' => $validator->errors(),
            ], 400);
        }

        // Get correct special date from carbon
        try {
            $request->special_date = $request->special_date ? Carbon::parse($request->special_date) : Carbon::now();
        } catch (InvalidFormatException $e) {
            $request->special_date = Carbon::now();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'special_date' => $request->special_date,
            'piggyvest_id' => $request->piggyvest_id,
            'address' => $request->address,
            'address_2' => $request->address_2,
            'location_id' => $request->location_id,
            'password' => Hash::make($request->password),
        ]);

        if (!$token = Auth::attempt($request->only(['email', 'password']))) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        Mail::to(Auth::user())->send(new WelcomeUnknowingMail($user, $token));

        return response()->json([
            'access_token' => $token,
            'user' => Auth::user()
        ]);
    }

    /**
     * Generate a new token for user
     *
     * @return JsonResponse
     */
    public function refreshToken()
    {
        return response()->json([
            'access_token' => Auth::refresh()
        ]);
    }

    /**
     * Confirms Token
     *
     * @param [type] $token
     * @return void
     */
    public function confirmResetToken($token)
    {
        $user = JWTAuth::parseToken()->authenticate();
        return $user;
    }

    /**
     * Resets Password
     *
     * @param Request $request
     * @return void
     */
    public function resetPassword(Request $request)
    {
        $user = User::find($request->userID);
        $user->password = Hash::make($request->password);
        $user->save();

        $credentials = $request->only(['email', 'password']);

        if (!$token = Auth::attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return response()->json([
            'access_token' => $token,
            'user' => Auth::user()
        ]);
    }

    /**
     * Send Reset Token
     *
     * @param Request $request
     * @return void
     */
    public function sendResetToken(Request $request)
    {
        if ($user = User::where('email', $request->email)->first()) {
            $user->password = Hash::make('$password');
            $user->save();

            $request->request->add(['password' => '$password']);

            $credentials = $request->only(['email', 'password']);
            $token = Auth::attempt($credentials);

            Mail::to(Auth::user())->send(new PasswordResetMail($user, $token));

            return response()->json(['message', 'Reset Mail Sent']);
        } else {
            return response()->json(['error' => 'Email doesn\'t exist'], 400);
        }
    }

    /**
     * Blacklist token
     *
     * @return JsonResponse
     */
    public function logout()
    {
        try {
            Auth::logout();
            return response()->json(['message' => 'Successfully logged out']);
        } catch (TokenExpiredException $e) {
            return response()->json(['token_expired'], $e->getStatusCode());
        }
    }

    /**
     * Update user
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function updateUser(Request $request)
    {
        $user = User::find($request->id);
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'special_date' => $request->special_date,
            'piggyvest_id' => $request->piggyvest_id,
            'address' => $request->address,
            'address_2' => $request->address_2,
            'location_id' => $request->location_id,
            'password' => Hash::make($request->password),
        ]);

        return response()->json($user);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6'],
            'phone' => ['required'],
            'location_id' => ['required'],
        ]);
    }
}
