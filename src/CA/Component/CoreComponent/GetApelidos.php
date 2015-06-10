<?php
namespace CA\Component\CoreComponent;

use CA\Component\Apelido\Apelido;
use CA\Component\Apelido\ApelidoRepositoryInterface;

class GetApelidos
{
    /**
     * @var ApelidoRepositoryInterface $repository
     */
    private $repository;

    /**
     * @param ApelidoRepositoryInterface $repository
     */
    public function __construct(ApelidoRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return Apelido[]
     */
    public function getApelidos()
    {
        return $this->repository->findAll();
    }
}