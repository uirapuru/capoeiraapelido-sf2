<?php
namespace CA\Component\Comment;
use CA\Component\Apelido\Apelido;

/**
 * Interface CommentRepositoryInterface
 * @package CA\Component\Comment
 */
interface CommentRepositoryInterface {
    /**
     * @param Apelido $apelido
     * @return Comment[]
     */
    public function getCommentsForApelido(Apelido $apelido);

    /**
     * @param Comment $comment
     * @return mixed
     */
    public function save(Comment $comment);
}