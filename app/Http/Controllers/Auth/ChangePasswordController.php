<?php


namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ChangePasswordController extends Controller
{
    public function change(Request $request)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Bad Request',
                'errors' => $validator->errors(),
            ], 400);
        }

        $user = User::find($request->loggedInUser)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            $user->password = Hash::make($request->newpassword);
            $user->save();

            return response()->json($user);
        }

        return response()->json([
            'message' => 'Invalid user',
        ], 404);
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'password' => 'required|string|min:6',
            'newpassword' => 'required|string|min:6|confirmed',
        ]);
    }
}
