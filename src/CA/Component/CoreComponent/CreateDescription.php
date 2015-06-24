<?php
namespace CA\Component\CoreComponent;

use CA\Component\Description\Description;
use CA\Component\Description\DescriptionRepositoryInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class CreateDescription
{
    const SUCCESS = 'capoeira_apelido.description.creation_success';
    const FAILURE = 'capoeira_apelido.description.creation_failure';

    /**
     * @var DescriptionRepositoryInterface
     */
    private $descriptionRepository;

    /**
     * @var EventDispatcherInterface $dispatcher
     */
    private $dispatcher;

    /**
     * @param DescriptionRepositoryInterface $descriptionRepository
     * @param EventDispatcherInterface $dispatcher
     */
    function __construct(
        DescriptionRepositoryInterface $descriptionRepository,
        EventDispatcherInterface $dispatcher
    )
    {
        $this->descriptionRepository = $descriptionRepository;
        $this->dispatcher = $dispatcher;
    }

    /**
     * @param Description $description
     */
    public function createDescription(Description $description)
    {
        if (!$description->getMessage()) {
            $this->dispatcher->dispatch(self::FAILURE, new Event([
                'description' => $description,
                'reason'  => 'Description is empty'
            ]));

            return;
        }

        if(!$this->descriptionRepository->findOneByAuthor($description->getAuthor()))
        {
            $this->descriptionRepository->save($description);
            $this->dispatcher->dispatch(self::SUCCESS, new Event(['description' => $description]));
        } else {
            $this->dispatcher->dispatch(self::FAILURE, new Event(['description' => $description, 'reason' => 'Description for this user already exists']));
        }
    }
}