<?php

declare(strict_types=1);

namespace SolubleTest\Wallit\Token\Provider;

use PHPUnit\Framework\TestCase;
use Soluble\Wallit\Token\Provider\ServerRequestCookieProvider;
use Zend\Diactoros\ServerRequest;

class ServerRequestCookieProviderTest extends TestCase
{
    protected function setUp(): void
    {
    }

    public function testConstructThrowsInvalidArgumentException(): void
    {
        $this->expectException(\InvalidArgumentException::class);

        new ServerRequestCookieProvider(new ServerRequest(), [
            'cookieName' => '',
        ]);
    }

    public function testValidToken(): void
    {
        $rawToken = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiYWRtaW4iOnRydWV9.TJVA95OrM7E2cBab30RMHrHDcEfxjoYZgeFONFh7HgQ';

        $cookieName = 'cookie_name_for_token_exists';

        $request = (new ServerRequest())->withCookieParams([
            $cookieName => $rawToken
        ]);
        $provider = new ServerRequestCookieProvider($request, ['cookieName' => $cookieName]);

        self::assertEquals($rawToken, $provider->getPlainToken());
        self::assertTrue($provider->hasToken());
    }

    public function testHasTokenReturnFalse(): void
    {
        $provider = new ServerRequestCookieProvider(new ServerRequest(), ['cookieName' => 'cookie_name_for_token_empty']);
        self::assertFalse($provider->hasToken());
    }

    public function testGetPlainTokenTokenReturnNull(): void
    {
        $provider = new ServerRequestCookieProvider(new ServerRequest(), ['cookieName' => 'cookie_name_for_token_empty']);
        self::assertNull($provider->getPlainToken());
    }
}
