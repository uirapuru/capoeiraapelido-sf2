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

    /**
     * @var \DateTime
     */
    protected $createdAt;

    function __construct(Apelido $apelido, $message, User $autor, \DateTime $createdAt)
    {
        $this->apelido = $apelido;
        $this->message = $message;
        $this->createdAt = $createdAt;
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

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
}