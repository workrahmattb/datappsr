<?php

namespace App\Http\Responses;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{
    /**
     * Redirect user based on their role after login.
     * Gunakan redirect()->to() untuk menghindari intended URL
     * yang mungkin mengarah ke /admin (403 untuk non-admin).
     */
    public function toResponse($request)
    {
        $user = $request->user();

        if ($user && $user->hasRole('admin')) {
            return redirect()->to('/admin');
        }

        if ($user && $user->hasRole('mtsputra')) {
            return redirect()->to('/admin/mtsputras');
        }

        if ($user && $user->hasRole('mtsputri')) {
            return redirect()->to('/admin/mtsputris');
        }

        if ($user && $user->hasRole('maputra')) {
            return redirect()->to('/admin/maputras');
        }

        if ($user && $user->hasRole('maputri')) {
            return redirect()->to('/admin/maputris');
        }

        return redirect()->to('/admin');
    }
}
