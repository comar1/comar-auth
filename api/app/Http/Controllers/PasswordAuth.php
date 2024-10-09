<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Cache;

class PasswordAuth extends Controller
{
    //
    //Helper functions
    private static function generateRandomChars($length) {
        $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        $saltArray = [];
        for ($i = 0; $i < $length; $i++) {
            $saltArray[] = $chars[rand(0, strlen($chars) - 1)];
        }
        $generatedSalt = implode('', $saltArray);
        return $generatedSalt;
    }

    public function getHash(Request $request)
    {
        $data = $request->all();
        $salt = self::generateRandomChars(5);

        // $csrfToken = Cache::get('csrf_token');

        // if ($request->header('X-CSRF-TOKEN') !== $csrfToken) {
        //     // Request is invalid
        //     return response()->json(['error' => 'Invalid CSRF token'], 401);
        // }
        //dd($csrfToken);
        
        $data['password'] = $request->password . $salt;

        // For example, you can return a success message
        return response()->json([
            'server_message' => 'Authentication successful!',
            'message' => 'You have been authenticated successfully.',
            'data' => $data,
            'token' => $csrfToken,
        ], 200);
    }

    public function checkCsrf(Request $request){
        $csrfToken = Cache::get('csrf_token');

        if ($request->header('X-CSRF-TOKEN') !== $csrfToken) {
            // Request is invalid
            return response()->json(['error' => 'Invalid CSRF token'], 401);
        }
    }
}
