<?php namespace CodeZero\OAuth\Contracts;

use CodeZero\OAuth\Exceptions\MissingCredentialsException;
use CodeZero\OAuth\Exceptions\ProviderNotSupportedException;

interface ProviderFactory
{
    /**
     * Create a Provider.
     *
     * @param string $provider
     *
     * @return Provider
     * @throws MissingCredentialsException
     * @throws ProviderNotSupportedException
     */
    public function createProvider($provider);
}
