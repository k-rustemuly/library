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
     * Sign in
     *
     * @param string $lang the language 
     *
     * @throws DomainException
     * 
     * @return array<mixed> The result
     */
    public function get(string $lang): array{
        return array();
    }
}