<?php

namespace App\Tests\Support;

use Symfony\Component\Security\Csrf\CsrfToken;

trait CsrfTokenManager
{
    /**
     * @param string $tokenId
     * @return CsrfToken
     */
    private function generateCsrfToken(string $tokenId): CsrfToken
    {
        return static::$container
            ->get('security.csrf.token_manager')
            ->getToken($tokenId);
    }
}
