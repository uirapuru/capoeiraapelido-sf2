<?php
namespace CA\Component\Description;
use CA\Component\Apelido\Apelido;

/**
 * Interface DescriptionRepositoryInterface
 * @package CA\Component\Description
 */
interface DescriptionRepositoryInterface {

    /**
     * @param Apelido $apelido
     * @return Description[]
     */
    public function getDescriptionsForApelido(Apelido $apelido);

    /**
     * @param Description $description
     * @return mixed
     */
    public function save(Description $description);
}