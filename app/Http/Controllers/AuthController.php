<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use Illuminate\Http\Response;
use App\Services\ParentService;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\ParentResource;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;

class AuthController extends Controller
{
    use ResponseTrait;


    private $parentService;

    /**
     * Constructor
     *
     * @param ParentService $userSparentServiceervice
     */
    public function __construct(ParentService $parentService ) {
        $this->parentService = $parentService;
    }


    /**
     * register function
     *
     * @param Request $request
     *  @return \Illuminate\Http\JsonResponse
    */
    public function login(LoginRequest $request)
    {
        try{
            $parent = $this->parentService->authenticateCredentials($request);
            $data['parent'] = ParentResource::make($parent);
            $data['token'] = $parent->createToken('login_token')->plainTextToken;
            Auth::login($parent);
            return $this->success('Logged in successfully', Response::HTTP_OK, $data);
        } catch (Exception $ex) {
            return $this->error($ex->getMessage() ,$ex->getCode());
        }
    }

    /**
     * login function
     *
     * @param Request $request
     *  @return \Illuminate\Http\JsonResponse
    */
    public function register(RegisterRequest $request)
    {
        $parent = $this->parentService->createParent($request->validated());
        $data['parent'] = ParentResource::make($parent);
        $data['token'] = $parent->createToken('register_token')->plainTextToken;
        return $this->success('Account created successfully', Response::HTTP_OK, $data);
    }

    /**
     * Logout
     *
     * @return \Illuminate\Http\JsonResponse
    */
    public function logout()
    {
        try{
            Auth::user()->tokens()->delete();
            return $this->success('Logged out successfully', Response::HTTP_OK);
        } catch (Exception $ex) {
            return $this->error($ex->getMessage() ,$ex->getCode());
        }
    }
}
