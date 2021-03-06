<?php

use Soluble\Wallit\Token\Jwt\SignatureAlgos;
use Soluble\Wallit\Token\Jwt\JwtClaims;
use Soluble\Wallit\Token\Provider as TokenProvider;

return [
    'soluble_wallit' => [
        /*
        |----------------------------------------------------------------------
        | token-auth-middleware configuration
        |----------------------------------------------------------------------
        */

        'token_auth_middleware' => [
            /*
            |--------------------------------------------------------------------------
            | Providers
            |--------------------------------------------------------------------------
            |
            | Specify the token provider(s)
            |
            | they will be added to ServerRequestLazyChainProvider and will
            | be executed in order of appearance.
            |
            | @see \Soluble\Wallit\Token\Provider\ServerRequestLazyChainProvider
            | @var array
            */

            'token_providers' => [
                /*
                 * The ServerRequestAuthBearerProvider try to get
                 * the token from request header: 'Authentication: Bearer xxx'
                 */
                [TokenProvider\ServerRequestAuthBearerProvider::class => [
                    'httpHeader'       => TokenProvider\ServerRequestAuthBearerProvider::DEFAULT_OPTIONS['httpHeader'],
                    'httpHeaderPrefix' => TokenProvider\ServerRequestAuthBearerProvider::DEFAULT_OPTIONS['httpHeaderPrefix'],
                ]],

                /*
                 * The ServerRequestCookieProvider try to get
                 * the token from a cookie (default name: jwt_token')
                 */
                [TokenProvider\ServerRequestCookieProvider::class => [
                    'cookieName' => TokenProvider\ServerRequestCookieProvider::DEFAULT_OPTIONS['cookieName']
                ]]
            ],

            /*
            |--------------------------------------------------------------------------
            | HTTPS protocol checks
            |--------------------------------------------------------------------------
            | To prevent security issues the auth middleware requires
            | the use of secured 'https' connections.
            |
            | For development only, you may want to disable this check, see also
            | the 'relaxed_hosts' configuration option to enable non-secure
            | communication with some hosts.
            |
            | By default: false.
            | @var boolean
             */
            'allow_insecure_http' => false,

            /*
            |--------------------------------------------------------------------------
            | Relaxed hosts for HTTPS protocol checks
            |--------------------------------------------------------------------------
            |
            |
            | @var array
             */
            'relaxed_hosts' => [
                'localhost',
            ],
        ],

        /*
        |----------------------------------------------------------------------
        | token-service configuration
        |----------------------------------------------------------------------
        */

        'token_service' => [
                /*
                |----------------------------------------------------------------------
                | JWT authentication secret (aka verification key)
                |----------------------------------------------------------------------
                |
                | Secret key used for symmetric algorithms (HMAC)
                |
                | @var string|false
                |
                */

                'secret' => 'token_for_tests_change_me_if_you_want_to_be_secure',

                /*
                |--------------------------------------------------------------------------
                | JWT time to live
                |--------------------------------------------------------------------------
                |
                | Token time to live in minutes.
                |
                | Defaults to one hour.
                |
                | Can be set to null for never expiring token. This is not a recommended
                | behaviour, be sure to understand the risks and be sure to be able to
                | revoke such tokens.
                |
                | @see refresh_ttl
                | @var int|null ttl in minutes
                |
                */

                'ttl' => 60,

                /*
                |--------------------------------------------------------------------------
                | Refresh time to live
                |--------------------------------------------------------------------------
                |
                | Set the grace period that the token can be refreshed.
                |
                | Default to two weeks.
                |
                | Can be set to null for never expiring token. This is not a recommended
                | behaviour, be sure to understand the risks and be sure to be able to
                | revoke such tokens.
                |
                | @see ttl
                | @var int|null ttl in minutes
                */

                'refresh_ttl' => 20160,

                /*
                |--------------------------------------------------------------------------
                | JWT hashing algorithm
                |--------------------------------------------------------------------------
                |
                | Specify the hashing algorithm that will be used to sign the token.
                |
                | @var string
                */

                'algo' => SignatureAlgos::HS256,

                /*
                |--------------------------------------------------------------------------
                | Required Claims
                |--------------------------------------------------------------------------
                |
                | Specify the required claims that must exist in any token.
                | A TokenInvalidException will be thrown if any of these claims are not
                | present in the payload.
                |
                | @var string[]
                */
                'required_claims' => [
                    JwtClaims::ISSUER,              // iss
                    JwtClaims::ISSUED_AT,           // iat
                    JwtClaims::EXPIRATION_TIME,     // exp
                    JwtClaims::NOT_BEFORE,          // nbf
                    JwtClaims::SUBJECT,             // sub
                    JwtClaims::ID,                  // jti
                ]
        ]
    ]
];
