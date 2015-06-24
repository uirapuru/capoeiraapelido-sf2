<?php

use Behat\Behat\Context\ContextInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\Event;
use CA\Component\CoreComponent\CreateApelido;
use CA\Component\CoreComponent\CreateUser;
use CA\Component\CoreComponent\Repository\InMemoryApelidoRepository;
use CA\Component\CoreComponent\Repository\InMemoryUserRepository;
use CA\Component\CoreComponent\Repository\InMemoryCityRepository;
use CA\Component\CoreComponent\Repository\InMemoryCountryRepository;
use CA\Component\CoreComponent\Repository\InMemoryOrganizationRepository;
use CA\Component\Apelido\Apelido;
use CA\Component\Apelido\ApelidoRepositoryInterface;
use CA\Component\User\User;
use CA\Component\User\Organization;
use CA\Component\User\City;
use CA\Component\User\Country;
use CA\Component\User\UserRepositoryInterface;
use CA\Component\User\OrganizationRepositoryInterface;
use CA\Component\User\CityRepositoryInterface;
use CA\Component\User\CountryRepositoryInterface;

/**
 * Class ApelidoManagerContext
 */
class ApelidoManagerContext implements ContextInterface {

    /**
     * @var User
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
     * @var CountryRepositoryInterface
     */
    private $countryRepository;

    /**
     * @var CityRepositoryInterface
     */
    private $cityRepository;

    /**
     * @var OrganizationRepositoryInterface
     */
    private $organizationRepository;

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
        $dispatcher = new EventDispatcher();
        $dispatcher->addListener(CreateApelido::SUCCESS, [$this, 'recordNotification']);
        $dispatcher->addListener(CreateApelido::FAILURE, [$this, 'recordNotification']);
        $dispatcher->addListener(CreateUser::SUCCESS, [$this, 'recordNotification']);
        $dispatcher->addListener(CreateUser::FAILURE, [$this, 'recordNotification']);

        $this->apelidoRepository = new InMemoryApelidoRepository();
        $this->userRepository = new InMemoryUserRepository();

        $this->createApelido = new CreateApelido($this->apelidoRepository, $dispatcher);
        $this->createUser = new CreateUser(
            $this->userRepository,
            $dispatcher
        );

        $machadoApelido = new Apelido("Machado");
        $this->apelidoRepository->save($machadoApelido);
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
        $this->loggedInUser = $user;
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

    /**
     * @Given /^user account "([^"]*)" has been created$/
     */
    public function userAccountDoesExist($name)
    {
        $user = new User($name, new Apelido('some'), '','','','');
        $this->userRepository->save($user);
    }

    /**
     * @Given /^I should be notified about error on account creation$/
     */
    public function iShouldBeNotifiedAboutErrorOnAccountCreation()
    {
        if (!in_array(CreateUser::FAILURE, $this->notifications)) {
            throw new RuntimeException('Notification not received!');
        };
    }
}