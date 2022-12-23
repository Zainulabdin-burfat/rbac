<?php

namespace Zainburfat\rbac;

interface AuthInterface
{
    function _createToken(string $name, array $abilities = ['*']);
    function _refreshToken($url, $grantType, $refreshToken, $clientId, $clientSecret, $scope = '');
    function _token();
    function _tokenCan($scope);
    function _tokensCan();
    function _withAccessToken($accessToken);
}
