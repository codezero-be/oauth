<?php namespace CodeZero\OAuth;

use CodeZero\OAuth\Contracts\ServiceFactory as ServiceFactoryContract;
use OAuth\Common\Consumer\CredentialsInterface;
use OAuth\Common\Http\Url;
use OAuth\Common\Storage\TokenStorageInterface;
use OAuth\ServiceFactory as OAuthServiceFactory;

class ServiceFactory implements ServiceFactoryContract
{
    /**
     * OAuth Service Factory
     *
     * @var OAuthServiceFactory
     */
    private $serviceFactory;

    /**
     * Create a new service factory instance.
     */
    public function __construct()
    {
        $this->serviceFactory = new OAuthServiceFactory();
    }

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
    ) {
        return $this->serviceFactory->createService(
            $handle,
            $credentials,
            $storage,
            $scope,
            $baseApiUri,
            $apiVersion
        );
    }
}
