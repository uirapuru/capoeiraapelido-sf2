<?php
namespace CA\Component\CoreComponent;

use CA\Component\User\User;
use CA\Component\User\UserRepositoryInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class CreateUser
{
    const SUCCESS = 'capoeira_apelido.user.creation_success';
    const FAILURE = 'capoeira_apelido.user.creation_failure';

    /**
     * @var UserRepositoryInterface $repository
     */
    private $repository;

    /**
     * @var EventDispatcherInterface $dispatcher
     */
    private $dispatcher;

    /**
     * @param UserRepositoryInterface $repository
     * @param EventDispatcherInterface $dispatcher
     */
    public function __construct(UserRepositoryInterface $repository, EventDispatcherInterface $dispatcher)
    {
        $this->repository = $repository;
        $this->dispatcher = $dispatcher;
    }

    public function createUser(User $user)
    {
        if (!$user->getName()) {
            $this->dispatcher->dispatch(self::FAILURE, new Event([
                'user' => $user,
                'reason'  => 'User name is empty'
            ]));

            return;
        }

        $this->repository->save($user);
        $this->dispatcher->dispatch(self::SUCCESS, new Event(['user' => $user]));
    }
}