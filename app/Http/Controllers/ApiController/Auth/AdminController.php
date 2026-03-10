<?php

namespace App\Http\Controllers\ApiController\Auth;

use App\DTOs\Auth\AdminDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AdminRequest;
use App\Services\AuthService;
use Exception;

class AdminController extends Controller
{
    public function __construct(protected AuthService $service){}

    public function login(AdminRequest $request){

        // We extract which data we are going to use from the request
        $data = AdminDTO::fromRequest($request);

        try{
            $response = $this->service->loginAsAdmin($data);

            return response()->json([
                "type" => "Admin Login",
                "message" => "Utilisateur connecté avec succès",
                "data" => $response
            ]);
        }catch(Exception $e){
            return response()->json([
                "message" => $e->getMessage()
            ], 400);
        }


    }
}
