<?php

namespace App\Domain\Terminal\Service;

use App\Helper\Language;
use App\Helper\Admin;
use App\Domain\Organization\Repository\OrganizationFinderRepository;

/**
 * Service.
 */
final class Read extends Admin{

    private $language;

    private $organizationFinderRepository;

    /**
     * The constructor.
     *
     */
    public function __construct(OrganizationFinderRepository $organizationFinderRepository) {
        $this->language = new Language();
        $this->organizationFinderRepository = $organizationFinderRepository;
    }

    /**
     *
     * @param string $lang the language 
     * 
     * @return array<mixed> The result
     */
    public function get(string $bin, string $lang): array{
        $this->language->locale($lang);
        $orgInfo = $this->organizationFinderRepository->findByBin($bin, $lang);
        if(empty($orgInfo)) return array();
        $array = array(
            "title" => $orgInfo["name"]
        );
        return $array;
    }
}