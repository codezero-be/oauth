<?php namespace CodeZero\OAuth\Providers; 

use CodeZero\OAuth\BaseProvider;
use OAuth\OAuth2\Service\Facebook;

class FacebookProvider extends BaseProvider
{
    /**
     * Internal Provider Handle
     *
     * @var string
     */
    protected $handle = 'facebook';

    /**
     * Default Scope
     *
     * @var array
     */
    protected $defaultScope = [ Facebook::SCOPE_EMAIL ];

    /**
     * Default Request Uri
     *
     * @var string
     */
    protected $defaultRequest = '/me';
}
