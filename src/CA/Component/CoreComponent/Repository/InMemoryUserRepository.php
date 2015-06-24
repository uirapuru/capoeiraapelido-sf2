<?php
namespace CA\Component\CoreComponent\Repository;

use CA\Component\Apelido\Apelido;
use CA\Component\User\User;
use CA\Component\User\UserRepositoryInterface as BaseRepositoryInterface;

class InMemoryUserRepository implements BaseRepositoryInterface
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

    /**
     * @param Apelido $apelido
     * @return \Generator
     */
    public function getUsersForApelido(Apelido $apelido)
    {
        foreach($this->users as $user) {
            if($user->getApelido()->getName() == $apelido->getName()) {
                yield $user;
            }
        }
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

    /**
     * @param $email
     * @return User|null
     */
    public function findOneByEmail($email)
    {
        foreach($this->users as $user) {
            if($user->getName() === $email) {
                return $user;
            }
        }
    }
}