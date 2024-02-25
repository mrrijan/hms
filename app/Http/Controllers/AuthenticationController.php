<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use App\Traits\Messages;
class AuthenticationController extends Controller
{
    use Messages;
    public function login(LoginRequest $request)
    {
        if (!Auth::attempt(['email' => $request->email, 'password' => $request->password]))
            return response()->json($this->getErrorMessage('Credentials did not match'), Response::HTTP_FORBIDDEN);
        $data = [
            'name' => Auth::user()->name,
            'id' => Auth::id()
        ];
        return response()->json($data);
    }
    public function logout(Request $request)
    {
        try {
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return response()->json($this->getMessage('Logged Out'));
        } catch (\Exception $exp) {
            return response()->json($this->getErrorMessage('Cannot logout'), Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

}
