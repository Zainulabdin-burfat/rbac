<?php

namespace Zainburfat\rbac;

use Illuminate\Support\Str;
use Zainburfat\rbac\NewAccessToken;

trait HasApiTokens
{
    protected $accessToken;

    public function tokens()
    {
        return $this->morphMany(PersonalAccessToken::class, 'tokenable');
    }

    public function tokenCan(string $ability)
    {
        dd($this->accessToken->can($ability));
        return $this->accessToken && $this->accessToken->can($ability);
    }

    public function createToken(string $name, array $abilities = ['-'])
    {
        $token = $this->tokens()->create([
            'name' => $name,
            'token' => hash('sha256', $plainTextToken = Str::random(60)),
            'abilities' => $abilities,
        ]);

        $this->accessToken = $token->getKey() . '|' . $plainTextToken;

        return new NewAccessToken($token, $token->getKey() . '|' . $plainTextToken);
    }

    public function token()
    {
        return $this->accessToken;
    }
}
