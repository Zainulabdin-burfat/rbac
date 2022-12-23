<?php

namespace Zainburfat\rbac;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Http;


class SanctumAdapter extends Authenticatable implements AuthInterface
{
    use HasApiTokens;

    public function _createToken(string $name, array $abilities = ['*'])
    {
        return $this->createToken($name, $abilities);
    }

    public function _token()
    {
        return $this->currentAccessToken();
    }

    public function _withAccessToken($accessToken)
    {
        $this->withAccessToken($accessToken);
    }

    public function _refreshToken($url, $grantType, $refreshToken, $clientId, $clientSecret, $scope = '')
    {
        $response = Http::asForm()->post($url, [
            'grant_type' => $grantType,
            'refresh_token' => $refreshToken,
            'client_id' => $clientId,
            'client_secret' => $clientSecret,
            'scope' => $scope,
        ]);

        return $response->json();
    }

    public function _tokenCan($scope)
    {
        return $this->tokenCan($scope);
    }

    public function _tokensCan()
    {
        return $this->tokensCan();
    }
}
