<?php
namespace CA\Component\Apelido;

/**
 * Interface ApelidoRepositoryInterface
 * @package CA\Component\Apelido
 */
interface ApelidoRepositoryInterface {

    /**
     * @param Apelido $apelido
     * @return mixed
     */
    public function save(Apelido $apelido);
}