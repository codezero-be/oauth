<?php namespace CodeZero\OAuth\Contracts;

use OAuth\Common\Consumer\CredentialsInterface;
use OAuth\Common\Http\Url;
use OAuth\Common\Storage\TokenStorageInterface;

interface ServiceFactory
{
    /**
     * Create a service.
     *
     * @param string $handle
     * @param CredentialsInterface $credentials
     * @param TokenStorageInterface $storage
     * @param array $scope
     * @param Url $baseApiUri
     * @param string $apiVersion
     *
     * @return \OAuth\OAuth1\Service\ServiceInterface|\OAuth\OAuth2\Service\ServiceInterface
     */
    public function createService(
        $handle,
        CredentialsInterface $credentials,
        TokenStorageInterface $storage,
        $scope = [],
        Url $baseApiUri = null,
        $apiVersion = ""
    );
}
