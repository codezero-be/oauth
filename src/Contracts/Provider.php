<?php namespace CodeZero\OAuth\Contracts;

interface Provider
{
    /**
     * Get the provider handle for internal use.
     *
     * @return string
     */
    public function getHandle();

    /**
     * Get the app key.
     *
     * @return string
     */
    public function getKey();

    /**
     * Get the app secret.
     *
     * @return string
     */
    public function getSecret();

    /**
     * Get the permission scopes needed to
     * obtain information from the user.
     *
     * @return array
     */
    public function getScope();

    /**
     * Get the request uri to query the service.
     *
     * @return string
     */
    public function getRequest();

    /**
     * Get the callback url.
     *
     * @return \League\Url\UrlInterface
     */
    public function getCallback();

    /**
     * Check if the provider was called and
     * we need to handle the callback.
     * If it was called but no token was returned,
     * the user canceled the request.
     *
     * @return bool
     */
    public function wasCalled();
}
