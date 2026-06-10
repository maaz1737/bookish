<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\Otp\OtpService;
use BcMath\Number;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class OtpAuthController extends Controller
{
    public function __construct(private OtpService $otp) {}

    public function showLogin()
    {
        return view('auth.login');
    }



    public function sendOtp(Request $request)
    {
        $request->validate(['mobile' => ['required', 'string', 'max:50']]);

        $result = $this->otp->request($request->input('mobile'));

        return back()->with([
            'otp_sent'   => true,
            'mobile'     => $request->input('mobile'),
            'channel'    => $result['channel'],
            'debug_code' => $result['debug_code'],
        ]);
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'mobile' => ['required', 'string', 'max:50'],
            'code'   => ['required', 'string', 'size:6'],
        ]);

        $user = $this->otp->verify($request->input('mobile'), $request->input('code'));

        if (! $user) {
            return back()->withErrors(['code' => 'Invalid or expired code.'])
                ->with(['otp_sent' => true, 'mobile' => $request->input('mobile')]);
        }

        if ($user->is_blocked) {
            return back()->withErrors(['mobile' => 'This account is blocked.']);
        }

        Auth::login($user, remember: true);
        $request->session()->regenerate();

        return redirect()->intended(route('home'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home');
    }
}
