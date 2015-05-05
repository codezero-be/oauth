<?php namespace CodeZero\OAuth;

use CodeZero\OAuth\Contracts\Authenticator as AuthenticatorContract;
use CodeZero\OAuth\Contracts\Provider;
use CodeZero\OAuth\Contracts\ProviderFactory as ProviderFactoryContract;
use CodeZero\OAuth\Contracts\ServiceFactory as ServiceFactoryContract;
use OAuth\Common\Storage\Session;
use OAuth\Common\Storage\TokenStorageInterface as StorageContract;
use OAuth\Common\Consumer\Credentials;

class Authenticator implements AuthenticatorContract
{
    /**
     * Provider Factory
     *
     * @var ProviderFactoryContract
     */
    private $providerFactory;

    /**
     * Service Factory
     *
     * @var ServiceFactoryContract
     */
    private $serviceFactory;

    /**
     * Storage Driver
     *
     * @var StorageContract
     */
    private $storage;

    /**
     * Create a new Authenticator instance.
     *
     * @param ProviderFactoryContract $providerFactory
     * @param ServiceFactoryContract $serviceFactory
     * @param StorageContract $storage
     */
    public function __construct(
        ProviderFactoryContract $providerFactory,
        ServiceFactoryContract $serviceFactory = null,
        StorageContract $storage = null
    ) {
        $this->providerFactory = $providerFactory;
        $this->serviceFactory = $serviceFactory ?: new ServiceFactory();
        $this->storage = $storage ?: new Session();
    }

    /**
     * Request permission and fetch user information.
     *
     * @param string $provider
     * @param bool $raw
     *
     * @return \OAuth\UserData\Extractor\ExtractorInterface|array|bool
     * @throws \CodeZero\OAuth\Exceptions\MissingCredentialsException
     * @throws \CodeZero\OAuth\Exceptions\ProviderNotSupportedException
     */
    public function request($provider, $raw = false)
    {
        $provider = $this->providerFactory->createProvider($provider);
        $service = $this->createService($provider);

        if ( ! $service->isGlobalRequestArgumentsPassed()) {
            if ($provider->wasCalled()) {
                return false; // User canceled
            }

            $service->redirectToAuthorizationUri();
            exit; // Avoid "double headers" exception after redirect header
        }

        $result = $service->retrieveAccessTokenByGlobReqArgs()
            ->requestJSON($provider->getRequest());

        return $raw ? $result : $service->constructExtractor();
    }

    /**
     * Create a service.
     *
     * @param Provider $provider
     *
     * @return \OAuth\OAuth1\Service\ServiceInterface|\OAuth\OAuth2\Service\ServiceInterface
     */
    private function createService(Provider $provider)
    {
        return $this->serviceFactory->createService(
            $provider->getHandle(),
            $this->getCredentials($provider),
            $this->storage,
            $provider->getScope()
        );
    }

    /**
     * Get provider credentials.
     *
     * @param Provider $provider
     *
     * @return Credentials
     */
    private function getCredentials(Provider $provider)
    {
        return new Credentials(
            $provider->getKey(),
            $provider->getSecret(),
            $provider->getCallback()
        );
    }
}
