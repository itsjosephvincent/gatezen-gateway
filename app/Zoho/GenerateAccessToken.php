<?php

namespace App\Zoho;

use Illuminate\Support\Facades\Http;

class GenerateAccessToken
{
    public function accessToken()
    {
        $response = Http::post('https://accounts.zoho.eu/oauth/v2/token?refresh_token='.config('zoho.refresh_token').'&client_id='.config('zoho.client_id').'&client_secret='.config('zoho.client_secret').'&redirect_uri='.config('zoho.redirect_uri').'&grant_type=refresh_token');

        $token = json_decode($response);

        return $token->access_token;
    }
}
