<?php

namespace Autoznetwork\AutoCheck;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use kamermans\OAuth2\GrantType\ClientCredentials;
use kamermans\OAuth2\OAuth2Middleware;

class AutoCheck
{
    protected array $credentials;

    /**
     * @var Client
     */
    protected Client $client;

    public function __construct(array $credentials)
    {
        $this->credentials = $credentials;

        // Authorization client - this is used to request OAuth access tokens
        $reauth_client = new Client([
            // URL for access_token request
            'base_uri' => 'https://sandbox-us-api.experian.com/oauth2/v1/token',
            'defaults' => [
                'headers' => ['content-type' => 'application/json', 'Accept' => 'application/json'],
            ],
        ]);
        $reauth_config = [
            'client_id' => 'your client id',
            'client_secret' => 'your client secret',
            'username' => 'username',
            'password' => 'password',
            // "scope" => "your scope(s)", // optional
            // "state" => time(), // optional
        ];
        $grant_type = new ClientCredentials($reauth_client, $reauth_config);
        $oauth = new OAuth2Middleware($grant_type);

        $stack = HandlerStack::create();
        $stack->push($oauth);

        $this->client = new Client([
            'handler' => $stack,
            'auth' => 'oauth',
            'base_uri' => 'https://sandbox-us-api.experian.com',
            'defaults' => [
                'headers' => ['content-type' => 'application/json', 'Accept' => 'application/json'],
            ],
        ]);




//        $stack = HandlerStack::create();
//
//        $middleware = new Oauth1([
//            'consumer_key' => 'my_key',
//            'consumer_secret' => 'my_secret',
//            'token' => 'my_token',
//            'token_secret' => 'my_token_secret',
//        ]);
//        $stack->push($middleware);
//
//        $this->client = new Client([
//            'base_uri' => 'https://sandbox-us-api.experian.com/',
//            'handler' => $stack,
//            'defaults' => [
//                'headers' => ['content-type' => 'application/json', 'Accept' => 'application/json'],
//            ],
//        ]);

        // /automotive/accuselect
    }

    public function getOpenIdConfig()
    {
        //https://us-api.experian.com/.well-known/openid-configuration
    }

    public function getToken()
    {
    }

    public function saveToken()
    {
    }
}
