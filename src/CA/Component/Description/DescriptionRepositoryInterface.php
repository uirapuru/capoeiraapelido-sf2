<?php
namespace CA\Component\Description;
use CA\Component\Apelido\Apelido;
use CA\Component\User\User;

/**
 * Interface DescriptionRepositoryInterface
 * @package CA\Component\Description
 */
interface DescriptionRepositoryInterface {

    /**
     * @param Description $description
     * @return mixed
     */
    public function save(Description $description);

    /**
     * @param User $user
     * @return Description|null
     */
    public function findOneByAuthor(User $user);

    /**
     * @param Apelido $apelido
     * @return Description[]
     */
    public function findAllByApelido(Apelido $apelido);
}