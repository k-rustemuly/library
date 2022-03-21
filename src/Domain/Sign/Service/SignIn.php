<?php

namespace App\Domain\Sign\Service;

use DomainException;
use App\Helper\Language;
/**
 * Service.
 */
final class SignIn {

    
    /**
     * @var Language language
     *
     */
    private $language;

    /**
     * The constructor.
     *
     */
    public function __construct() {
        $this->language = new Language();
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
        $this->language->locale($lang);
        return array(
            "title" => $this->language->getTitle("sign_in"),
        );
    }
}