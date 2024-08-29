<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ApiToken;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ApiTokenController extends Controller
{
    public function generate(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $token = Str::random(64);
        
        $apiToken = ApiToken::create([
            'token' => $token,
            'name' => $request->name,
        ]);

        return response()->json(['token' => $token], 201);
    }

    public function revoke(Request $request)
    {
        $request->validate([
            'token' => 'required|string|exists:api_tokens,token',
        ]);

        ApiToken::where('token', $request->token)->delete();

        return response()->json(['message' => 'Token revoked successfully'], 200);
    }
}