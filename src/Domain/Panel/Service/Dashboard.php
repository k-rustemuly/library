<?php

namespace App\Domain\Panel\Service;

use DomainException;
use App\Helper\Language;
use SlimSession\Helper as Session;
use App\Helper\Admin;

/**
 * Service.
 */
final class Dashboard extends Admin{

    /**
     * @var Language language
     *
     */
    private $language;

    /**
     * @var Session 
     *
     */
    private $session;

    /**
     * The constructor.
     *
     */
    public function __construct() {
        $this->language = new Language();
        $this->session = new Session();
    }

    /**
     * Sign in
     *
     * @param string $lang the language 
     * 
     * @return array<mixed> The result
     */
    public function get(string $lang): array{
        $l = $this->language;
        $l->locale($lang);
        $base = $this->getBase($lang);
        $array = array(
            "title" => $l->getTitle("dashboard"),
        );
        return array_merge($array, $base);
    }
}