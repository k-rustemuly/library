<?php

namespace App\Domain\Author\Service;

use DomainException;
use App\Helper\Language;
use App\Helper\Admin;
use App\Domain\Author\Repository\AuthorFinderRepository as ReadRepository;
use App\Domain\Author\Repository\AuthorCreatorRepository as CreateRepository;

/**
 * Service.
 */
final class Get extends Admin{

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
     * @var CreateRepository 
     *
     */
    private $createRepository;

    /**
     * The constructor.
     *
     */
    public function __construct(ReadRepository $readRepository, CreateRepository $createRepository) {
        $this->language = new Language();
        $this->readRepository = $readRepository;
        $this->createRepository = $createRepository;
    }

    /**
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
            "title" => $l->getTitle("author"),
            "h1" => $l->getString("author_h1"),
            "all" => $l->getString("all"),
            "search" => $l->getString("search"),
            "add_new_author" => $l->getString("add_new_author"),
            "avatar" => $l->getString("avatar"),
            "change_avatar" => $l->getString("change_avatar"),
            "cancel_avatar" => $l->getString("cancel_avatar"),
            "remove_avatar" => $l->getString("remove_avatar"),
            "full_name" => $l->getField("full_name"),
            "cancel" => $l->getButton("cancel"),
            "add" => $l->getButton("add"),
            "please_wait" => $l->getString("please_wait"),
            "authors_list" => $this->readRepository->getAll()
        );
        return array_merge($array, $base);
    }

    /**
     * 
     * @return array<mixed> The result
     */
    public function list(): array{
        return $this->readRepository->getAllWithoutHash();
    }

    /**
     * Add new author
     * 
     * @param array<mixed> $data
     * 
     */
    public function add(array $data) {
        $full_name = isset($data["full_name"]) ? $data["full_name"] : "";
        $this->createRepository->insert(["name" => $full_name, "hash" => $this->generateHash(3)]);
    }

    /**
     *  Generating new hash
     *
     * @return string The new hash
     */
    private function generateHash(int $length = 36, int $attempt = 1) :string{
        $randomStr = $this->base64url_encode(substr(hash("sha512", mt_rand()), 0, $length));
        if($this->readRepository->existsbyHash($randomStr)) {
            if($attempt > 10) {
                $attempt = 1;
                $length++;
            }
            return $this->generateHash($length, $attempt);
        }
        return $randomStr;
    }

    /**
     *
     * @param string $data The data
     *
     * @return string The cleaned string
     */
    public function base64url_encode(string $data) :string{ 
        return rtrim(strtr(base64_encode($data), "+/", "-_"), "="); 
    }
}