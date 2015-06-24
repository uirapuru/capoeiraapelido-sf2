<?php
namespace CA\Component\CoreComponent\Repository;

use CA\Component\Apelido\Apelido;
use CA\Component\Description\Description;
use CA\Component\Description\DescriptionRepositoryInterface as BaseRepositoryInterface;
use CA\Component\User\User;
use Closure;

class InMemoryDescriptionRepository implements BaseRepositoryInterface
{
    /**`
     * @var Description[] $descriptions
     */
    private $descriptions = [];

    /**
     * @param Description $description
     * @return mixed
     */
    public function save(Description $description)
    {
        $this->descriptions[] = $description;
    }

    /**
     * @return Description[]
     */
    public function findAll()
    {
        return $this->descriptions;
    }

    /**
     * @param User $user
     * @return Description|null
     */
    public function findOneByAuthor(User $user)
    {
        foreach($this->descriptions as $description) {
            if($description->getAuthor()->getName() == $user->getName()) {
                return $description;
            }
        }
    }

    /**
     * @param Apelido $apelido
     * @return Description[]
     */
    public function findAllByApelido(Apelido $apelido) {
        $callback = function(Description $description) use ($apelido) {
            return $description->getApelido()->getName() === $apelido->getName();
        };

        return array_filter($this->descriptions, $callback);
    }
}