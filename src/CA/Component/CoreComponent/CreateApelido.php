<?php
namespace CA\Component\CoreComponent;

use CA\Component\Apelido\Apelido;
use CA\Component\Apelido\ApelidoRepositoryInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class CreateApelido
{
    const SUCCESS = 'capoeira_apelido.apelido.creation_success';
    const FAILURE = 'capoeira_apelido.apelido.creation_failure';

    /**
     * @var ApelidoRepositoryInterface $repository
     */
    private $repository;

    /**
     * @var EventDispatcherInterface $dispatcher
     */
    private $dispatcher;

    /**
     * @param ApelidoRepositoryInterface $repository
     * @param EventDispatcherInterface $dispatcher
     */
    public function __construct(ApelidoRepositoryInterface $repository, EventDispatcherInterface $dispatcher)
    {
        $this->repository = $repository;
        $this->dispatcher = $dispatcher;
    }

    public function createApelido(Apelido $apelido)
    {
        if (!$apelido->getName()) {
            $this->dispatcher->dispatch(self::FAILURE, new Event([
                'apelido' => $apelido,
                'reason'  => 'Apelido name is empty'
            ]));

            return;
        }

        if(!$this->repository->findOneByName($apelido->getName())) {
            $this->repository->save($apelido);
            $this->dispatcher->dispatch(self::SUCCESS, new Event(['apelido' => $apelido]));
        }
    }
}