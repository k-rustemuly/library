<?php

namespace App\Domain\Language\Service;

use App\Helper\Language;
use App\Helper\Admin;
use App\Domain\Language\Repository\LanguageFinderRepository as ReadRepository;

/**
 * Service.
 */
final class Read extends Admin{

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
     * The constructor.
     *
     */
    public function __construct(ReadRepository $readRepository) {
        $this->language = new Language();
        $this->readRepository = $readRepository;
    }

    /**
     *
     * @param string $lang the language 
     * 
     * @return array<mixed> The result
     */
    public function get(string $lang): array{
        return $this->readRepository->getAllByLang($lang);
    }
}