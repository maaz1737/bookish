<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Otp\OtpService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(private OtpService $otp) {}

    // POST /api/auth/send-otp
    public function sendOtp(Request $request)
    {
        $request->validate(['mobile' => ['required', 'string', 'max:50']]);
        $result = $this->otp->request($request->input('mobile'));

        return response()->json([
            'message' => 'OTP dispatched.',
            'channel' => $result['channel'],
        ]);
    }

    // POST /api/auth/verify-otp
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'mobile' => ['required', 'string', 'max:50'],
            'code'   => ['required', 'string', 'size:6'],
        ]);

        $user = $this->otp->verify($request->input('mobile'), $request->input('code'));

        if (! $user || $user->is_blocked) {
            return response()->json(['message' => 'Invalid or expired code.'], 422);
        }

        $token = $user->createToken('storefront')->plainTextToken;

        return response()->json([
            'token' => $token,
            'user'  => $user->only('id', 'name', 'mobile', 'role'),
        ]);
    }
}
