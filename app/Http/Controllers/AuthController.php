<?php
/**
 * Created by PhpStorm.
 * User: fahrur
 * Date: 29/11/20
 * Time: 15:24
 */

namespace App\Http\Controllers;


use App\Domain\Auth\Models\RegisterUserDto;
use App\Domain\Auth\Services\UserService;
use App\Domain\ValidationException;
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

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

    public function register(Request $request)
    {
        return view('register');
    }

    public function registerSubmit(Request $request, UserService $userService)
    {
        try {
            $data = $request->json()->all();
            $userDto = new RegisterUserDto();
            $userDto->fromArray($data);


            $userService->register($userDto);

            return response()->json(['message' => 'Register success']);
        } catch (ValidationException $exception) {
            return response()->json(['validation' => $exception->getArrError()], 500);
        } catch (\Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], 500);
        }
    }
}