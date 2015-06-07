<?php
namespace CA\Component\Description;
use CA\Component\Apelido\Apelido;
use CA\Component\User\User;

/**
 * Class Description
 * @package CA\Component\Description
 */
class Description {

    /**
     * @var Apelido $apelido
     */
    protected $apelido;

    /**
     * @var string $message
     */
    protected $message;

    /**
     * @var Image $image
     */
    protected $image;

    /**
     * @var User $autor
     */
    protected $autor;

    /**
     * @var Thumb[]
     */
    protected $thumbsUp;

    /**
     * @var Thumb[]
     */
    protected $thumbsDown;

    /**
     * @var \DateTime
     */
    protected $createdAt;

    /**
     * @param Apelido $apelido
     * @param $message
     * @param Image $image
     * @param User $autor
     * @param \DateTime $createdAt
     */
    function __construct(Apelido $apelido, $message, Image $image, User $autor, \DateTime $createdAt)
    {
        $this->apelido = $apelido;
        $this->message = $message;
        $this->image = $image;
        $this->autor = $autor;
        $this->createdAt = $createdAt;
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
     * @return Image
     */
    public function getImage()
    {
        return $this->image;
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