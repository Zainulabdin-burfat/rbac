<?php

return [
    'tokensExpireIn' => now()->seconds(20),
    'refreshTokensExpireIn' => now()->addDays(10),
    'personalAccessTokensExpireIn' => now()->addDays(15),
];