<?php namespace CodeZero\OAuth\Providers;

use CodeZero\OAuth\BaseProvider;

class TwitterProvider extends BaseProvider
{
    /**
     * Internal Provider Handle
     *
     * @var string
     */
    protected $handle = 'twitter';

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
    protected $defaultRequest = 'account/verify_credentials.json';
}
