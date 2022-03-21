<?php
namespace App\Helper;

class Language{
    public $string = [];

    public function locale(string $lang = "ru"):self{
        $this->string = json_decode(file_get_contents(TRANSLATE_DIR.$lang.'.json'), true);
        return $this;
    }

    public function get(string $key = ""){
        return isset($this->string[$key]) ? $this->string[$key] : $key;
    }

    public function getTitle(string $key = "") :string{
        return isset($this->string["title"][$key]) ? $this->string["title"][$key] : $key;
    }

    public function getString(string $key = "") :string{
        return isset($this->string["string"][$key]) ? $this->string["title"][$key] : $key;
    }

    public function getField(string $key = "") :string{
        return isset($this->string["field"][$key]) ? $this->string["title"][$key] : $key;
    }

    public function getButton(string $key = "") :string{
        return isset($this->string["button"][$key]) ? $this->string["title"][$key] : $key;
    }
}
?>