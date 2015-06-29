<?php
namespace CA\Component\CoreComponent\Repository;

use CA\Component\Apelido\Apelido;
use CA\Component\Comment\Comment;
use CA\Component\Comment\CommentRepositoryInterface as BaseRepositoryInterface;

class InMemoryCommentRepository implements BaseRepositoryInterface
{
    /**`
     * @var Comment[] $comments
     */
    private $comments = [];

    /**
     * @param Comment $comment
     * @return mixed
     */
    public function save(Comment $comment)
    {
        $this->comments[] = $comment;
    }

    /**
     * @return Comment[]
     */
    public function findAll()
    {
        return $this->comments;
    }

    /**
     * @param Apelido $apelido
     * @return Comment[]
     */
    public function findAllByApelido(Apelido $apelido) {
        $callback = function(Comment $comment) use ($apelido) {
            return $comment->getApelido()->getName() === $apelido->getName();
        };

        return array_filter($this->comments, $callback);
    }
}