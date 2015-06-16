<?php
namespace CA\Component\CoreComponent;

use CA\Component\User\City;
use CA\Component\User\Organization;
use CA\Component\User\User;
use CA\Component\User\UserRepositoryInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class CreateUser
{
    const SUCCESS = 'capoeira_apelido.user.creation_success';
    const FAILURE = 'capoeira_apelido.user.creation_failure';

    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;

    /**
     * @var EventDispatcherInterface $dispatcher
     */
    private $dispatcher;

    /**
     * @param UserRepositoryInterface $userRepository
     * @param EventDispatcherInterface $dispatcher
     */
    function __construct(
        UserRepositoryInterface $userRepository,
        EventDispatcherInterface $dispatcher
    )
    {
        $this->userRepository = $userRepository;
        $this->dispatcher = $dispatcher;
    }

    /**
     * @param User $user
     */
    public function createUser(User $user)
    {
        if (!$user->getName()) {
            $this->dispatcher->dispatch(self::FAILURE, new Event([
                'user' => $user,
                'reason'  => 'User name is empty'
            ]));

            return;
        }

        $this->userRepository->save($user);
        $this->dispatcher->dispatch(self::SUCCESS, new Event(['user' => $user]));
    }
}