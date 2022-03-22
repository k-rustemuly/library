<?php 
declare(strict_types=1);

namespace App\Helper;
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

}