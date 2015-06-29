<?php
namespace CA\Component\Comment;
use CA\Component\Apelido\Apelido;
use CA\Component\User\User;

/**
 * Class Comment
 * @package CA\Component\Comment
 */
class Comment {

    /**
     * @var Apelido
     */
    protected $apelido;

    /**
     * @var string
     */
    protected $message;

    /**
     * @var User
     */
    protected $autor;

    function __construct(Apelido $apelido, $message, User $autor)
    {
        $this->apelido = $apelido;
        $this->message = $message;
        $this->autor = $autor;
    }

    /**
     * @return Apelido
     */
    public function getApelido()
    {
        return $this->apelido;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @return User
     */
    public function getAutor()
    {
        return $this->autor;
    }
}