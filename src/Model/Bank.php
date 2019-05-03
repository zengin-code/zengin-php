<?php
namespace ZenginCode\Model;

/**
 * Class Bank
 *
 * @package ZenginCode\Model
 */
class Bank
{
    public $code = null;
    public $name = null;
    public $kana = null;
    public $hira = null;
    public $roma = null;

    public function __construct($sourceJson)
    {
        $this->code = $sourceJson['code'];
        $this->name = $sourceJson['name'];
        $this->kana = $sourceJson['kana'];
        $this->hira = $sourceJson['hira'];
        $this->roma = $sourceJson['roma'];
    }
}
