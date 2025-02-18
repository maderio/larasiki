<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    protected $client;
    protected $apiUrl;

    public function __construct()
    {
        $this->client = new Client();
        $this->apiUrl = env('BASE_URL_API');
    }

    public function create(Request $request)
    {
        if (!$request->ajax()) {
            return redirect()->back();
        }

        $name = $request->name;
        $email = $request->email;

        $validator = Validator::make([
            'name' => $name,
            'email' => $email
        ], [
            'name' => 'required|string|max:255',
            'email' => 'required|email'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {

            $response = $this->client->request('POST', "{$this->apiUrl}/users/create", [
                'form_params' => [
                    'name' => $name,
                    'email' => $email,
                ]
            ]);

            $data = json_decode($response->getBody(), true);

            return response()->json([
                'status' => true,
                'message' => 'User berhasil ditambahkan!',
                'data' => $data
            ], 201);
        } catch (\Throwable $th) {

            return response()->json([
                'status' => false,
                'message' => 'Gagal menambahkan user',
                'error' => $th->getMessage()
            ], 500);
        }
    }
}
