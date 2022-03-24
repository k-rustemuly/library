<?php

namespace App\Domain\Main\Service;

use App\Helper\Language;
use App\Helper\Admin;

/**
 * Service.
 */
final class Read extends Admin{

    /**
     * The constructor.
     *
     */
    public function __construct() {
    }

    /**
     *
     * @param string $lang the language 
     * 
     * @return array<mixed> The result
     */
    public function get(string $lang): array{
        return array();
    }
}