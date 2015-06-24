<?php

use CA\Component\CoreComponent\CreateApelido;
use CA\Component\CoreComponent\CreateDescription;
use CA\Component\CoreComponent\CreateUser;
use CA\Component\CoreComponent\Event;

trait NotifyTrait {

    /**
     * @var string[]
     */
    private $notifications = [];

    /**
     * @param Event $event
     */
    public function recordNotification(Event $event)
    {
        $this->notifications[] = $event->getName();
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
     * @Given /^I should be notified about successful account creation$/
     */
    public function iShouldBeNotifiedAboutSuccessfulAccountCreation()
    {
        if (!in_array(CreateUser::SUCCESS, $this->notifications)) {
            throw new RuntimeException('No notification received');
        };
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
     * @Then /^I should be notified about successful description creation$/
     */
    public function iShouldBeNotifiedAboutSuccessfulDescriptionCreation()
    {
        if (!in_array(CreateDescription::SUCCESS, $this->notifications)) {
            throw new RuntimeException('No notification received');
        };
    }

    /**
     * @Then /^I should be notified about failure on description creation$/
     */
    public function iShouldBeNotifiedAboutFailureOnDescriptionCreation()
    {
        if (!in_array(CreateDescription::FAILURE, $this->notifications)) {
            throw new RuntimeException('Notification not received!');
        };
    }
}