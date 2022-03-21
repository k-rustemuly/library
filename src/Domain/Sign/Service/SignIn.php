<?php

namespace App\Domain\Sign\Service;

use DomainException;

/**
 * Service.
 */
final class SignIn {


    /**
     * The constructor.
     *
     */
    public function __construct() {
    }

    /**
     * Sign in center admin by digital signature.
     *
     * @param array<mixed> $post fileds The post fields
     *
     * @throws DomainException
     * 
     * @return array<mixed> The result
     */
    public function pkcs(array $post): array{
        return array();
    }
}