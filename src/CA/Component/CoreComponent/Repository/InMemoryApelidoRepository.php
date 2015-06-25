<?php
namespace CA\Component\CoreComponent\Repository;

use CA\Component\Apelido\Apelido;
use CA\Component\Apelido\ApelidoRepositoryInterface as BaseRepositoryInterface;
use CA\Component\User\User;

class InMemoryApelidoRepository implements BaseRepositoryInterface
{
    /**
     * @var Apelido[] $apelidos
     */
    private $apelidos = [];

    /**
     * @param Apelido $apelido
     * @return mixed
     */
    public function save(Apelido $apelido)
    {
        $this->apelidos[$apelido->getName()] = $apelido;
    }

    /**
     * @param User $user
     * @return mixed
     */
    public function getApelidoForUser(User $user)
    {
        // TODO: Implement getUsersApelido() method.
    }

    /**
     * @return Apelido[]
     */
    public function findAll()
    {
        return $this->apelidos;
    }

    /**
     * @param string $getName
     * @return Apelido
     */
    public function findOneByName($name)
    {
        if(array_key_exists($name, $this->apelidos)) {
            return $this->apelidos[$name];
        }
    }


}