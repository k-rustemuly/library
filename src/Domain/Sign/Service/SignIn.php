<?php

namespace App\Domain\Sign\Service;

use DomainException;
use App\Helper\Language;
use App\Domain\Admin\Repository\AdminFinderRepository as ReadRepository;
use App\Domain\Admin\Repository\AdminUpdaterRepository as UpdateRepository;
use SlimSession\Helper as Session;

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
     * @var ReadRepository 
     *
     */
    private $readRepository;

    /**
     * @var UpdateRepository 
     *
     */
    private $updateRepository;
    
    /**
     * @var Session 
     *
     */
    private $session;

    /**
     * The constructor.
     *
     */
    public function __construct(ReadRepository $readRepository, UpdateRepository $updateRepository) {
        $this->readRepository = $readRepository;
        $this->updateRepository = $updateRepository;
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

    /**
     * Sign in post
     * 
     * @param array<mixed> $data
     * @throws DomainException
     * 
     * @return array<mixed>
     */
    public function post(array $data) :array{
        $email = isset($data['email']) ? $data['email'] : "";
        $password = isset($data['password']) ? $data['password'] : "";
        $adminInfo = $this->readRepository->findByEmail($email);
        if(empty($adminInfo)) {
            // || !password_verify($password, $adminInfo["password"])
            throw new DomainException("Email or password is incorrect");
        }
        if(!$adminInfo["is_active"]) {
            throw new DomainException("Account is not active");
        }
        if(!$adminInfo["org_is_active"]) {
            throw new DomainException("Organization is not active");
        }
        $this->updateRepository->updateLastVisitById((int)$adminInfo["id"]);
        $this->session->set("admin", $adminInfo);
        return array(
            "email" => $adminInfo["email"],
            "full_name" => $adminInfo["full_name"],
            "organization" => [
                "ru" => $adminInfo["name_ru"],
                "kk" => $adminInfo["name_kk"],
            ]
        );
    }
}