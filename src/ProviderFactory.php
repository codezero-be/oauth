<?php namespace CodeZero\OAuth; 

use CodeZero\OAuth\Contracts\Provider;
use CodeZero\OAuth\Contracts\ProviderFactory as ProviderFactoryContract;
use CodeZero\OAuth\Exceptions\MissingCredentialsException;
use CodeZero\OAuth\Exceptions\ProviderNotSupportedException;

class ProviderFactory implements ProviderFactoryContract
{
    /**
     * Configuration Array Keys
     */
    const KEY      = 'key';
    const SECRET   = 'secret';
    const SCOPE    = 'scope';
    const REQUEST  = 'request_uri';
    const CALLBACK = 'callback_url';
    const PROVIDER = 'provider_class';

    /**
     * Providers Configuration Array
     *
     * @var array
     */
    private $providers;

    /**
     * The Requested Provider
     *
     * @var string
     */
    private $provider;

    /**
     * Custom Provider Names
     *
     * @var array
     */
    private $providerNameMap = [
        'github' => 'GitHub'
    ];

    /**
     * Create a new provider factory instance.
     *
     * @param array $providers
     */
    public function __construct(array $providers)
    {
        $this->providers = $providers;
    }

    /**
     * Create a Provider.
     *
     * @param string $provider
     *
     * @return Provider
     * @throws MissingCredentialsException
     * @throws ProviderNotSupportedException
     */
    public function createProvider($provider)
    {
        $this->provider = $provider;
        $this->verifyCredentials();
        $className = $this->getProviderClassName();

        return new $className(
            $this->getKey(),
            $this->getSecret(),
            $this->getScope(),
            $this->getRequest(),
            $this->getCallback()
        );
    }

    /**
     * Verify that the credentials are provided.
     *
     * @throws MissingCredentialsException
     */
    private function verifyCredentials()
    {
        if ( ! isset($this->providers[$this->provider])
            || ! $this->getKey()
            || ! $this->getSecret()
        ) {
            throw new MissingCredentialsException(sprintf('Credentials for the %s provider are missing.', ucfirst($this->provider)));
        }
    }

    /**
     * Get the full class path of the provider.
     *
     * @return string
     * @throws ProviderNotSupportedException
     */
    private function getProviderClassName()
    {
        $className = $this->getConfigured(
            self::PROVIDER,
            $this->getDefaultProviderClassName()
        );

        if ( ! class_exists($className)) {
            throw new ProviderNotSupportedException(sprintf('Provider class [%s] does not exist.', $className));
        }

        return $className;
    }

    /**
     * Get the default class path of the provider.
     *
     * @return string
     */
    private function getDefaultProviderClassName()
    {
        $className = isset($this->providerNameMap[$this->provider])
            ? $this->providerNameMap[$this->provider]
            : ucfirst($this->provider);

        return __NAMESPACE__.'\Providers\\'.$className.'Provider';
    }

    /**
     * Get the app key from the configuration.
     *
     * @return string
     */
    private function getKey()
    {
        return $this->getConfigured(self::KEY);
    }

    /**
     * Get the app secret from the configuration.
     *
     * @return string
     */
    private function getSecret()
    {
        return $this->getConfigured(self::SECRET);
    }

    /**
     * Get any custom scopes from the configuration.
     *
     * @return array
     */
    private function getScope()
    {
        return $this->getConfigured(self::SCOPE, []);
    }

    /**
     * Get any request uri from the configuration.
     *
     * @return string
     */
    private function getRequest()
    {
        return $this->getConfigured(self::REQUEST, '');
    }

    /**
     * Get any callback url from the configuration.
     *
     * @return string
     */
    private function getCallback()
    {
        return $this->getConfigured(self::CALLBACK, '');
    }

    /**
     * Get a value from the configuration.
     *
     * @param string $key
     * @param mixed $default
     *
     * @return mixed
     */
    private function getConfigured($key, $default = null)
    {
        return $this->isConfigured($key)
            ? $this->providers[$this->provider][$key]
            : $default;
    }

    /**
     * Check if a key exists in the configuration.
     *
     * @param string $key
     *
     * @return bool
     */
    private function isConfigured($key)
    {
        return ! empty($this->providers[$this->provider][$key]);
    }
}
