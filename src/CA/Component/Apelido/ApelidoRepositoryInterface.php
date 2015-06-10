<?php
namespace CA\Component\Apelido;
use CA\Component\User\User;

/**
 * Interface ApelidoRepositoryInterface
 * @package CA\Component\Apelido
 */
interface ApelidoRepositoryInterface {

    /**
     * @param Apelido $user
     * @return mixed
     */
    public function save(Apelido $user);

    /**
     * @param User $user
     * @return Apelido
     */
    public function getUsersApelido(User $user);

    /**
     * @return Apelido[]
     */
    public function findAll();

    /**
     * @param string $getName
     * @return Apelido
     */
    public function getApelidoByName($name);
}