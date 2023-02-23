<?php


namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class ResetPasswordController extends Controller
{
    use ResetsPasswords;

    public function reset(Request $request)
    {
        try {
            $this->validate($request, $this->rules(), $this->validationErrorMessages());
        } catch (ValidationException $e) {
        }

        $response = $this->broker()->reset(
            $this->credentials($request),
            function ($user, $password) {
                $this->resetPassword($user, $password);
            }
        );

        if (Password::PASSWORD_RESET === $response) {
            return $this->sendResetResponse($response);
        }

        return $this->sendResetFailedResponse($response);
    }

    protected function sendResetResponse($response)
    {
        return response()->json(['message' => 'Password has been reset'], 200);
    }

    protected function sendResetFailedResponse($response)
    {
        return response()->json(['message' => 'Invalid token'], 500);
    }

    protected function resetPassword($user, $password)
    {
        $user->forceFill([
            'password' => Hash::make($password),
            'remember_token' => Str::random(60),
        ])->save();
    }
}
