<?php
namespace CA\Component\Apelido;

/**
 * Class Apelido
 * @package CA\Component\Apelido
 */
class Apelido {

    /**
     * @var string $name
     */
    protected $name;

    /**
     * @param $name
     */
    function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}