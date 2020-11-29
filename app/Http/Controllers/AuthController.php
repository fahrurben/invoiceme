<?php
/**
 * Created by PhpStorm.
 * User: fahrur
 * Date: 29/11/20
 * Time: 15:24
 */

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        return view('login');
    }

    /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return Response
     */
    public function authenticate(Request $request)
    {
        $requestData = $request->json()->all();

        if (Auth::attempt($requestData)) {
            // Authentication passed...
            return response()->json([
                'message' => 'Success',
            ]);
        } else {
            return response()->json([
                'message' => 'Wrong email or password',
            ], 400);
        }
    }
}