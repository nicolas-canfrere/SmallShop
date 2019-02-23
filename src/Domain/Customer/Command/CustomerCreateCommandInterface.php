<?php

namespace Domain\Customer\Command;


use Domain\Core\CommandBus\CommandInterface;

interface CustomerCreateCommandInterface extends CommandInterface
{
    public function getFirstname(): string;

    public function setFirstname(string $firstname): CustomerCreateCommandInterface;

    public function getLastname(): string;

    public function setLastname(string $lastname): CustomerCreateCommandInterface;

    public function getEmail(): string;

    public function setEmail(string $email): CustomerCreateCommandInterface;

    public function getUsername(): string;

    public function setUsername(string $username): CustomerCreateCommandInterface;

    public function getPassword(): string;

    public function setPassword(string $password): CustomerCreateCommandInterface;
}