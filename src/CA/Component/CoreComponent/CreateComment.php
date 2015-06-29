<?php
namespace CA\Component\CoreComponent;

use CA\Component\Comment\Comment;
use CA\Component\Comment\CommentRepositoryInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class CreateComment
{
    const SUCCESS = 'capoeira_apelido.comment.creation_success';
    const FAILURE = 'capoeira_apelido.comment.creation_failure';

    /**
     * @var CommentRepositoryInterface
     */
    private $commentRepository;

    /**
     * @var EventDispatcherInterface $dispatcher
     */
    private $dispatcher;

    /**
     * @param CommentRepositoryInterface $commentRepository
     * @param EventDispatcherInterface $dispatcher
     */
    function __construct(
        CommentRepositoryInterface $commentRepository,
        EventDispatcherInterface $dispatcher
    )
    {
        $this->commentRepository = $commentRepository;
        $this->dispatcher = $dispatcher;
    }

    /**
     * @param Comment $comment
     */
    public function createComment(Comment $comment)
    {
        if (!$comment->getMessage()) {
            $this->dispatcher->dispatch(self::FAILURE, new Event([
                'comment' => $comment,
                'reason'  => 'Comment is empty'
            ]));

            return;
        }

        $this->commentRepository->save($comment);
        $this->dispatcher->dispatch(self::SUCCESS, new Event(['comment' => $comment]));
    }
}