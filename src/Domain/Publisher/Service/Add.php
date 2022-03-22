<?php

namespace App\Domain\Publisher\Service;

use App\Helper\Language;
use App\Helper\Admin;
use App\Domain\Publisher\Repository\PublisherFinderRepository as ReadRepository;
use App\Domain\Publisher\Repository\PublisherCreatorRepository as CreateRepository;

/**
 * Service.
 */
final class Add extends Admin{

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
     * Add new
     * 
     * @param array<mixed> $data
     * 
     */
    public function add(array $data) {
        $name_ru = isset($data["name_ru"]) ? $data["name_ru"] : "";
        $name_kk = isset($data["name_kk"]) ? $data["name_kk"] : "";
        $this->createRepository->insert(["name_kk" => $name_kk, "name_ru" => $name_ru, "hash" => $this->generateHash(3)]);
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