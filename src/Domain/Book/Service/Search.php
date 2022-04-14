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
        $data = isset($params['isbn']) ? $this->readRepository->findByIsbn($params['isbn']) : array();
        $data = isset($params['id']) ? $this->readRepository->findById($params['id']) : array();
        return $data;
    }

}