<?php namespace CodeZero\OAuth;

use CodeZero\OAuth\Contracts\Provider;
use League\Url\Url;

abstract class BaseProvider implements Provider
{
    /**
     * Internal Provider Handle
     *
     * @var string
     */
    protected $handle;

    /**
     * Default Scope
     *
     * @var array
     */
    protected $defaultScope = [];

    /**
     * Default Request Uri
     *
     * @var string
     */
    protected $defaultRequest = '';

    /**
     * App Key
     *
     * @var string
     */
    private $key;

    /**
     * App Secret
     *
     * @var string
     */
    private $secret;

    /**
     * Custom Scope
     *
     * @var array
     */
    private $scope;

    /**
     * Custom Request Uri
     *
     * @var string
     */
    private $request;

    /**
     * Callback Url
     *
     * @var string
     */
    private $callback;

    /**
     * Create a new provider instance.
     *
     * @param string $key
     * @param string $secret
     * @param array $scope
     * @param string $request
     * @param string $callback
     */
    public function __construct($key, $secret, $scope = [], $request = '', $callback = '')
    {
        $this->key = $key;
        $this->secret = $secret;
        $this->scope = $scope;
        $this->request = $request;
        $this->callback = $callback;
    }

    /**
     * Get the provider handle for internal use.
     *
     * @return string
     */
    public function getHandle()
    {
        return $this->handle;
    }

    /**
     * Get the app key.
     *
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * Get the app secret.
     *
     * @return string
     */
    public function getSecret()
    {
        return $this->secret;
    }

    /**
     * Get the permission scopes needed to
     * obtain information from the user.
     *
     * @return array
     */
    public function getScope()
    {
        return empty($this->scope)
            ? $this->defaultScope
            : $this->scope;
    }

    /**
     * Get the request uri to query the service.
     *
     * @return string
     */
    public function getRequest()
    {
        return empty($this->request)
            ? $this->defaultRequest
            : $this->request;
    }

    /**
     * Get the callback url.
     *
     * @return \League\Url\UrlInterface
     */
    public function getCallback()
    {
        $url = empty($this->callback)
            ? Url::createFromServer($_SERVER)
            : Url::createFromUrl($this->callback);

        return $url->setQuery(['run' => 1]);
    }

    /**
     * Check if the provider was called and
     * we need to handle the callback.
     * If it was called but no token was returned,
     * the user canceled the request.
     *
     * @return bool
     */
    public function wasCalled()
    {
        return isset($_GET['run']);
    }
}
