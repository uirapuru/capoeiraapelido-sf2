<?php
namespace CA\Component\User;
use CA\Component\Apelido\Apelido;

/**
 * Interface UserRepositoryInterface
 * @package CA\Component\User
 */
interface UserRepositoryInterface {
    public function getUsersForApelido(Apelido $apelido);
}