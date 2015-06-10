<?php

use Behat\Behat\Context\ContextInterface;
use Behat\Behat\Exception\PendingException;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\Event;
use CA\Component\CoreComponent\CreateApelido;
use CA\Component\CoreComponent\CreateUser;
use CA\Component\CoreComponent\Repository\InMemoryApelidoRepository;
use CA\Component\CoreComponent\Repository\InMemoryUserRepository;
use CA\Component\Apelido\Apelido;
use CA\Component\User\User;
use CA\Component\User\Organization;
use CA\Component\User\City;
use CA\Component\User\Country;

/**
 * Class ApelidoManagerContext
 */
class ApelidoManagerContext implements ContextInterface {

    /**
     * @var \CA\Component\User\User
     */
    private $loggedInUser;

    /**
     * @var \CA\Component\Apelido\ApelidoRepositoryInterface
     */
    private $apelidoRepository;

    /**
     * @var \CA\Component\User\UserRepositoryInterface
     */
    private $userRepository;

    /**
     * @var string[]
     */
    private $notifications = [];

    /**
     * @var CreateApelido $createApelido
     */
    private $createApelido;

    /**
     * @var CreateUser $createUser
     */
    private $createUser;

    /**
     * @param Event $event
     */
    public function recordNotification(Event $event)
    {
        $this->notifications[] = $event->getName();
    }

    /**
     * @BeforeScenario
     */
    public function prepare()
    {
        $this->notifications = [];

        $dispatcher = new EventDispatcher();

        $apelidoRepository = new InMemoryApelidoRepository();
        $userRepository = new InMemoryUserRepository();

        $this->createApelido = new CreateApelido($apelidoRepository, $dispatcher);
        $this->createUser = new CreateUser($userRepository, $dispatcher);

        $this->apelidoRepository = $apelidoRepository;
        $this->userRepository = $userRepository;

        $machadoApelido = new Apelido("Machado");
        $this->createApelido->createApelido($machadoApelido);

        $dispatcher->addListener(CreateApelido::SUCCESS, [$this, 'recordNotification']);
        $dispatcher->addListener(CreateApelido::FAILURE, [$this, 'recordNotification']);
        $dispatcher->addListener(CreateUser::SUCCESS, [$this, 'recordNotification']);
        $dispatcher->addListener(CreateUser::FAILURE, [$this, 'recordNotification']);

    }

    /**
     * @Given /^I am not logged in$/
     */
    public function iAmNotLoggedIn()
    {
        if($this->loggedInUser != null) {
            throw new RuntimeException("User is not null!");
        }
    }

    /**
     * @When /^I create new apelido "([^"]*)" with email "([^"]*)"$/
     */
    public function iCreateNewApelidoWithEmail($apelido, $email)
    {
        $apelido = new Apelido($apelido);

        $this->createApelido->createApelido($apelido);

        $user = new User(
            $email,
            $apelido,
            new City("city", new Country("country")),
            new Organization("Camangula"),
            uniqid()
        );

        $this->createUser->createUser($user);

        $this->loggedInUser = $user;
    }

    /**
     * @Then /^apelido "([^"]*)" should be saved$/
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
     */
    public function myAccountCreated($email)
    {
        foreach($this->userRepository->findAll() as $user)
        {
            if ($user->getName() == $email) {
                return;
            }
        }

        throw new RuntimeException("Apelido not saved");
    }

    /**
     * @Given /^I should be notified about successful apelido creation$/
     */
    public function iShouldBeNotifiedAboutSuccess()
    {
        if (!in_array(CreateApelido::SUCCESS, $this->notifications)) {
            throw new RuntimeException('No notification received');
        };
    }

    /**
     * @Given /^I should be notified about successful account creation$/
     */
    public function iShouldBeNotifiedAboutSuccessfulAccountCreation()
    {
        if (!in_array(CreateUser::SUCCESS, $this->notifications)) {
            throw new RuntimeException('No notification received');
        };
    }

    /**
     * @Given /^I should get a valid token for my account$/
     */
    public function iShouldGetAValidTokenForMyAccount()
    {
        $token = $this->loggedInUser->getToken();

        $user = $this->userRepository->getUserByToken($token);

        if($user->getName() !== $this->loggedInUser->getName()) {
            throw new \RuntimeException("Logged in user with token does not exists in repository");
        }

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
        if(!$this->loggedInUser || $this->loggedInUser->getName() !== $arg1) {
            throw new \RuntimeException("User is not logged in");
        }
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
     * @Given /^I should not be notified about successful apelido creation$/
     */
    public function iShouldNotBeNotifiedAboutSuccessfulApelidoCreation()
    {
        if (in_array(CreateApelido::SUCCESS, $this->notifications)) {
            throw new RuntimeException('Notification received!');
        };
    }
}