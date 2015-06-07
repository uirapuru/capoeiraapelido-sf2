<?php
namespace CA\Bundle\CommentBundle\Entity;

use CA\Component\Comment\Comment as BaseComment;

/**
 * Class Comment
 * @package CA\Bundle\CommentBundle\Entity
 */
class Comment extends BaseComment
{
    /**
     * @var integer $id
     */
    protected $id;
}