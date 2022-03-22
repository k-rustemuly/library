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
        $languageList = $l->get("language");
        return array(
            "admin" => $this->getInfo($lang),
            "lang" => $lang,
            "title" => $l->getTitle("dashboard"),
            "language" => $l->getString("language"),
            "lang_name" => $languageList[$lang],
            "languages" => $languageList,
            "sign_out" => $l->getString("sign_out"),
        );
    }
}