<?php namespace CodeZero\OAuth\Providers;

use CodeZero\OAuth\BaseProvider;
use OAuth\OAuth2\Service\Google;

class GoogleProvider extends BaseProvider
{
    /**
     * Internal Provider Handle
     *
     * @var string
     */
    protected $handle = 'google';

    /**
     * Default Scope
     *
     * @var array
     */
    protected $defaultScope = [ Google::SCOPE_USERINFO_EMAIL, Google::SCOPE_USERINFO_PROFILE ];

    /**
     * Default Request Uri
     *
     * @var string
     */
    protected $defaultRequest = 'https://www.googleapis.com/oauth2/v1/userinfo';
}
