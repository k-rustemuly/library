<?php 
declare(strict_types=1);

namespace App\Helper;
use App\Helper\Language;
use SlimSession\Helper as Session;

class Admin{


    /**
     * Admin is center organization
     *
     * @param array       $data
     *
     * @return boolean
     */
    public function getInfo(string $lang) :array{
        $session = new Session();
        $data = $session->get('admin');
        return array(
            "email" => $data['email'],
            "full_name" => $data['full_name'],
            "organization_name" => $data['name_'.$lang]
        );
    }

    public function getBase(string $lang) :array{
        $l = new Language();
        $l->locale($lang);
        $languageList = $l->get("language");
        return array(
            "admin" => $this->getInfo($lang),
            "lang" => $lang,
            "language" => $l->getString("language"),
            "lang_name" => $languageList[$lang],
            "languages" => $languageList,
            "sign_out" => $l->getString("sign_out"),
            "menu" => $l->get("menu")
        );
    }
}