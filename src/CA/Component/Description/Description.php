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
     * @var User $author
     */
    protected $author;

    /**
     * @var Thumb[]
     */
    protected $thumbsUp = [];

    /**
     * @var Thumb[]
     */
    protected $thumbsDown = [];

    /**
     * @param Apelido $apelido
     * @param $message
     * @param Image $image
     * @param User $author
     */
    function __construct(Apelido $apelido, $message, Image $image, User $author)
    {
        $this->apelido = $apelido;
        $this->message = $message;
        $this->image = $image;
        $this->author = $author;
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
    public function getAuthor()
    {
        return $this->author;
    }

    public function addThumb(Thumb $thumb) {
        foreach (array_merge($this->thumbsUp, $this->thumbsDown) as $existingThumb) {
            if($existingThumb->getAuthor()->getName() === $thumb->getAuthor()->getName()) {
                throw new \Exception("User has already voted");
            }
        };

        if($thumb->getValue() > 0) {
            $this->thumbsUp[] = $thumb;
        } else {
            $this->thumbsDown[] = $thumb;
        }
    }

    public function getThumbsSum(){
        return count($this->thumbsUp) - count($this->thumbsDown);
    }
}