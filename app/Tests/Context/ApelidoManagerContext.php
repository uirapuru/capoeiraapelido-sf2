<?php

use Behat\Behat\Context\ContextInterface;
use CA\Component\Description\DescriptionRepositoryInterface;
use CA\Component\Description\Image;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\Event;
use CA\Component\CoreComponent\CreateApelido;
use CA\Component\CoreComponent\CreateUser;
use CA\Component\CoreComponent\CreateDescription;
use CA\Component\CoreComponent\Repository\InMemoryApelidoRepository;
use CA\Component\CoreComponent\Repository\InMemoryUserRepository;
use CA\Component\CoreComponent\Repository\InMemoryDescriptionRepository;
use CA\Component\Apelido\Apelido;
use CA\Component\Apelido\ApelidoRepositoryInterface;
use CA\Component\User\User;
use CA\Component\User\UserRepositoryInterface;
use CA\Component\Description\Description;

/**
 * Class ApelidoManagerContext
 */
class ApelidoManagerContext implements ContextInterface {

    use NotifyTrait;

    /**
     * @var User[]
     */
    private $loggedInUser;

    /**
     * @var ApelidoRepositoryInterface
     */
    private $apelidoRepository;

    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;

    /**
     * @var DescriptionRepositoryInterface|InMemoryDescriptionRepository
     */
    private $descriptionRepository;

    /**
     * @var CreateApelido $createApelido
     */
    private $createApelido;

    /**
     * @var CreateUser $createUser
     */
    private $createUser;

    /**
     * @var CreateDescription $createDescription
     */
    private $createDescription;

    /**
     * @BeforeScenario
     */
    public function prepare()
    {
        $dispatcher = new EventDispatcher();
        $dispatcher->addListener(CreateApelido::SUCCESS, [$this, 'recordNotification']);
        $dispatcher->addListener(CreateApelido::FAILURE, [$this, 'recordNotification']);
        $dispatcher->addListener(CreateUser::SUCCESS, [$this, 'recordNotification']);
        $dispatcher->addListener(CreateUser::FAILURE, [$this, 'recordNotification']);
        $dispatcher->addListener(CreateDescription::SUCCESS, [$this, 'recordNotification']);
        $dispatcher->addListener(CreateDescription::FAILURE, [$this, 'recordNotification']);

        $this->apelidoRepository = new InMemoryApelidoRepository();
        $this->userRepository = new InMemoryUserRepository();
        $this->descriptionRepository = new InMemoryDescriptionRepository();

        $this->createApelido = new CreateApelido($this->apelidoRepository, $dispatcher);
        $this->createUser = new CreateUser($this->userRepository, $dispatcher);
        $this->createDescription = new CreateDescription($this->descriptionRepository, $dispatcher);

        $machadoApelido = new Apelido("Machado");
        $this->apelidoRepository->save($machadoApelido);

        $loggedIn = new User('loggedin@tlen.pl', new Apelido('Uirapuru'), '', '', '', uniqid());
        $this->createUser->createUser($loggedIn);

        $this->loggedInUser[] = $loggedIn;
    }

    /**
     * @Given /^I am not logged in$/
     * @Given /^I am not logged in as "([^"]*)"$/
     */
    public function iAmNotLoggedIn($who = null)
    {
        if($who == null) {
            return;
        }

        foreach($this->loggedInUser as $user) {
            if($user->getName() == $who) {
                return;
            }
        }

        throw new RuntimeException("User is not null!");
    }

    /**
     * @When /^I create new apelido "([^"]*)"$/
     */
    public function iCreateNewApelido($apelido)
    {
        $apelido = new Apelido($apelido);
        $this->createApelido->createApelido($apelido);
    }

    /**
     * @Given /^I add to apelido "([^"]*)" user with email "([^"]*)", group "([^"]*)", city "([^"]*)", country "([^"]*)"$/
     */
    public function iCreateNewUser($apelidoName, $email, $organization, $city, $country)
    {
        $apelido = $this->apelidoRepository->getApelidoByName($apelidoName);

        if($apelido === null) {
            $this->iCreateNewApelido($apelidoName);
            $apelido = $this->apelidoRepository->getApelidoByName($apelidoName);
        }

        $user = new User($email, $apelido, $city, $country, $organization, uniqid());
        $this->createUser->createUser($user);
        $this->loggedInUser[] = $user;
    }

    /**
     * @Then /^apelido "([^"]*)" should exist$/
     */
    public function apelidoShouldBeSaved($name)
    {
        foreach($this->apelidoRepository->findAll() as $apelido)
        {
            if ($apelido->getName() == $name) {
                return;
            }
        }

        throw new RuntimeException("Apelido not saved");
    }

    /**
     * @Given /^my account "([^"]*)" created$/
     * @Given /^account "([^"]*)" does exist$/
     */
    public function myAccountCreated($email)
    {
        foreach($this->userRepository->findAll() as $user)
        {
            if ($user->getName() == $email) {
                return;
            }
        }

        throw new RuntimeException("Account not saved");
    }


    /**
     * @Given /^apelido "([^"]*)" does not exists$/
     */
    public function apelidoDoesNotExists($name)
    {
        foreach($this->apelidoRepository->findAll() as $apelido)
        {
            if ($apelido->getName() == $name) {
                throw new \RuntimeException("Apelido already exists!");
            }
        }
    }

    /**
     * @Given /^I am logged in as "([^"]*)"$/
     */
    public function iAmLoggedInAs($arg1)
    {
        foreach($this->loggedInUser as $user) {
            if($user->getName() == $arg1) {
                return;
            }
        }
        throw new \RuntimeException("User is not logged in");
    }

    /**
     * @Given /^apelido "([^"]*)" does exist$/
     */
    public function apelidoDoesExist($name)
    {
        foreach($this->apelidoRepository->findAll() as $apelido)
        {
            if ($apelido->getName() == $name) {
                return;
            }
        }

        throw new \RuntimeException("Apelido does not exist!");
    }

    /**
     * @Given /^user account "([^"]*)" has been created$/
     */
    public function userAccountDoesExist($name)
    {
        $user = new User($name, new Apelido('some'), '','','','');
        $this->userRepository->save($user);
    }

    /**
     * @When /^I create for apelido "([^"]*)" new description  "([^"]*)" with "([^"]*)" image as user "([^"]*)"$/
     */
    public function iCreateForApelidoNewDescriptionWithImage($apelidoName, $descriptionText, $imageFile, $userName)
    {
        $apelido = $this->apelidoRepository->getApelidoByName($apelidoName);
        $user = $this->userRepository->findOneByEmail($userName);

        $description = new Description($apelido, $descriptionText, new Image($imageFile), $user);
        $this->createDescription->createDescription($description);
    }

    /**
     * @Given /^apelido "([^"]*)" should have (\d+) description$/
     */
    public function apelidoShouldHaveDescription($apelidoName, $count)
    {
        $apelido = $this->apelidoRepository->getApelidoByName($apelidoName);

        if(count($this->descriptionRepository->findAllByApelido($apelido)) != $count) {
            throw new Exception('Description count not equal to tested');
        }
    }

}