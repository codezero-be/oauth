<?php namespace CodeZero\OAuth\Providers;

use CodeZero\OAuth\BaseProvider;
use OAuth\OAuth2\Service\GitHub;

class GitHubProvider extends BaseProvider
{
    /**
     * Internal Provider Handle
     *
     * @var string
     */
    protected $handle = 'github';

    /**
     * Default Scope
     *
     * @var array
     */
    protected $defaultScope = [ GitHub::SCOPE_USER ];

    /**
     * Default Request Uri
     *
     * @var string
     */
    protected $defaultRequest = 'user/emails';
}
