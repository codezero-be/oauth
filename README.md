# OAuth

[![GitHub release](https://img.shields.io/github/release/codezero-be/oauth.svg)]()
[![License](https://img.shields.io/packagist/l/codezero/oauth.svg)]()
[![Total Downloads](https://img.shields.io/packagist/dt/codezero/oauth.svg)](https://packagist.org/packages/codezero/oauth)

### Social authentication without the headaches!

This package is a wrapper around [logical-and/php-oauth](https://github.com/logical-and/php-oauth) and aims to make it even easier to authenticate users via third party providers. Supports vanilla PHP and [Laravel 5](http://laravel.com/).

## Installation

Install this package through Composer:

    composer require codezero/oauth

## Register Apps

You will need to create an App with each of the providers that you wish to support. They will give you an App ID (or key) and an App secret.

## Vanilla PHP Implementation

### Create a Configuration File

Create a `providers.php` configuration file and store your keys in it:

    <?php

    return [
        'facebook' => [
            'key'    => '123',
            'secret' => '456',
        ],
        'google' => [
            'key'    => '123',
            'secret' => '456',
        ],
        // ...
    ];

### Create a Script

Create a `.php` file and autoload the vendor classes:

    require_once 'vendor/autoload.php'; // Path may vary

Next, import and new up the classes:

    use CodeZero\OAuth\Authenticator;
    use CodeZero\OAuth\ProviderFactory;
    
    $credentials = include __DIR__.'/path/to/providers.php';
    $providerFactory = new ProviderFactory($credentials);
    $auth = new Authenticator($providerFactory);

Now you have `$auth` to work with. Jump to [#usage](#usage) to see how easy it is... ;) 

## Laravel 5 Implementation

Add the ServiceProvider to the providers array in `config/app.php`:

    'providers' => [
        'CodeZero\OAuth\Laravel5\OAuthServiceProvider'
    ]

Create `oauth-providers.php` to the `config` folder and add your configuration array, or simply publish and edit it:
 
    php artisan config:publish codezero/oauth
    
Then you can "make" (or inject) a `Authenticator` instance anywhere in your app:

    $auth = \App::make('CodeZero\OAuth\Contracts\Authenticator');

Now you have `$auth` to work with. Jump to [#usage](#usage) to see how easy it is... ;) 

## Usage

### Redirect... Enjoy the ride!

With the `Authenticator` instance (`$auth`) you can call... Facebook (or Google, or...):

    $details = $auth->request('facebook'); //=> Lower case!

When you run `$auth->request('provider')` you will first be redirected to the provider. You will need to grant or deny access to your personal information and then you will be redirected back to the page where you came from.

**IMPORTANT:** You need to set your page as a valid callback URL in your App!

> Also note that this script will always append `?run=1` to the URL when you are redirected back. Depending on the provider, they are touchy about this. At least for Google this is very important, so make sure you include it in the callback URL in your App settings if needed!

### Check the response...

Now you can handle the `$details` that were returned by the provider:

    if ($details) {
        $email = $details->getEmail();
        $firstName = $details->getFirstName();
        $lastName = $details->getLastName();
        // ...
    } else {
        // User canceled!
    }

If the user declines, `$details` will be `false` and you can do whatever is needed.

If access is granted, `$details` will be an instance of `ExtractorInterface` from the [logical-and/php-oauth](https://github.com/logical-and/php-oauth) package, which has several handy methods to fetch specific user data. Please refer to [https://github.com/logical-and/php-oauth#userdata](https://github.com/logical-and/php-oauth#userdata) for more information on this or take a look at the [`interface`](https://github.com/logical-and/php-oauth/blob/master/src/UserData/Extractor/ExtractorInterface.php).

### Redirect the users...

When you get redirected back to your site after a successful request, you will notice that there is a token in the URL. This token can't be used twice, so if you would refresh the page an exception would be thrown...

Therefor, it might be wise to redirect your users somewhere after you're done.

## Available Providers

`logical-and/php-oauth` supports [ALOT of different services](https://github.com/logical-and/php-oauth#service-support).

Each of those can work with this package, as long as you add the nescessary keys to your configuration and there is a [Provider class](https://github.com/codezero-be/oauth/blob/master/src/Providers) available.

### Create a Provider

If I didn't include a [supported](https://github.com/logical-and/php-oauth#service-support) provider yet, you can make one yourself: 

    use CodeZero\OAuth\BaseProvider;
    
    class ExampleProvider extends BaseProvider
    {
        /**
         * Internal Provider Handle
         *
         * @var string
         */
        protected $handle = 'example';
    
        /**
         * Default Scope
         *
         * @var array
         */
        protected $defaultScope = [ 'example.scope' ];
    
        /**
         * Default Request Uri
         *
         * @var string
         */
        protected $defaultRequest = 'example/uri';
    }

The handle needs to match the ones that are used in [php-oauth's examples](https://github.com/logical-and/php-oauth/tree/master/examples). Also the basic scope and request URI can be found there.

Just save your class somewhere, make sure it's being (auto)loaded and then reference it in your configuration array like so:

    'example' => [
        'key'    => '123',
        'secret' => '456',
        'scope'          => [], // Optional: overrule default
        'request_uri'    => '', // Optional: overrule default
        'callback_url'   => '', // Optional: overrule default
        'provider_class' => 'ExampleProvider', //=> Your custom provider
    ],

## Examples

Take a look at [examples](https://github.com/codezero-be/oauth/blob/master/examples).

## ToDo

- Add tests...
- Add more providers...
- Create storage driver for Laravel's Session...
- Fix bugs (maybe... probably...) :)

## Testing

    $ vendor/bin/phpspec run

## Security

If you discover any security related issues, please [e-mail me](mailto:ivan@codezero.be) instead of using the issue tracker.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

---
[![Analytics](https://ga-beacon.appspot.com/UA-58876018-1/codezero-be/oauth)](https://github.com/igrigorik/ga-beacon)
