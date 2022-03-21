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
        $l = $this->language;
        $l->locale($lang);
        return array(
            "lang" => $lang,
            "title" => $l->getTitle("sign_in"),
            "h1" => $l->getString("sign_in_h1"),
            "email" => $l->getField("email"),
            "password" => $l->getField("password"),
            "forgot_password" => $l->getString("forgot_password"),
            "sign_in" => $l->getButton("sign_in"),
            "please_wait" => $l->getString("please_wait"),
        );
    }
}