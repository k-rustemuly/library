<?php

namespace App\Domain\Book\Service;

use App\Helper\Language;
use App\Domain\Book\Repository\BookFinderRepository as ReadRepository;

/**
 * Service.
 */
final class Search{

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
    public function search(string $lang, array $params): array{
        $isbn = isset($params['isbn']) ? $params['isbn']:0;
        return $this->readRepository->findByIsbn($isbn);
    }

}