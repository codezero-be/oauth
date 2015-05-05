<?php namespace CodeZero\OAuth\Contracts;

interface Authenticator
{
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
    public function request($provider, $raw = false);
}
