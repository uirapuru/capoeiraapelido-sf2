<?php
namespace CA\Component\CoreComponent\Repository;

use CA\Component\Apelido\Apelido;
use CA\Component\User\User;
use CA\Component\User\UserRepositoryInterface;

class InMemoryUserRepository implements UserRepositoryInterface
{
    /**
     * @var User[] $users
     */
    private $users = [];

    /**
     * @param User $user
     * @return mixed
     */
    public function save(User $user)
    {
        $this->users[$user->getName()] = $user;
    }

    public function getUsersForApelido(Apelido $apelido)
    {
        // TODO: Implement getUsersForApelido() method.
    }

    /**
     * @return User[]
     */
    public function findAll()
    {
        return $this->users;
    }

    /**
     * @param $token
     * @return User
     */
    public function getUserByToken($token)
    {
        foreach($this->users as $user) {
            if($user->getToken() === $token) {
                return $user;
            }
        }
    }


}