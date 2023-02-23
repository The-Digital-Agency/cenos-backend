<?php


namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    use SendsPasswordResetEmails;

    public function forgotPassword(Request $request)
    {
        $this->validate($request, ['email' => 'required|email']);

        try {
            $response = $this->broker()->sendResetLink(
                $request->only('email')
            );
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 500);
        }

        if (Password::RESET_LINK_SENT === $response) {
            return $this->sendResetLinkResponse($response);
        }

        return $this->sendResetLinkFailedResponse($response);
    }

    /**
     * Get the broker to be used during password reset.
     *
     * @return PasswordBroker
     */
    public function broker()
    {
        return Password::broker();
    }

    /**
     * Get the response for a successful password reset link.
     *
     * @param string $response
     *
     * @return JsonResponse
     */
    protected function sendResetLinkResponse($response)
    {
        return response()->json(['message' => $response], 200);
    }

    /**
     * @param $response
     *
     * @return JsonResponse
     */
    protected function sendResetLinkFailedResponse($response)
    {
        return response()->json(['message' => $response], 500);
    }
}
