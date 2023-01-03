<?php

return [
    'tokensExpireIn' => now()->addDays(10),
    'refreshTokensExpireIn' => now()->addDays(10),
    'personalAccessTokensExpireIn' => now()->addDays(15),
];