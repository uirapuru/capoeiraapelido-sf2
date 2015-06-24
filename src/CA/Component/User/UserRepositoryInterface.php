<?php
namespace CA\Component\User;
use CA\Component\Apelido\Apelido;

/**
 * Interface UserRepositoryInterface
 * @package CA\Component\User
 */
interface UserRepositoryInterface {

    /**
     * @param User $user
     */
    public function save(User $user);

    /**
     * @param Apelido $apelido
     * @return User[]
     */
    public function getUsersForApelido(Apelido $apelido);

    /**
     * @return User[]
     */
    public function findAll();

    /**
     * @param $token
     * @return User
     */
    public function getUserByToken($token);

    /**
     * @param $email
     * @return User|null
     */
    public function findOneByEmail($email);
}