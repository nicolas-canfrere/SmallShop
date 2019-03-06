<?php

namespace Tests\Domain\Customer\ValueObject;


use Domain\Customer\ValueObject\Email;
use PHPUnit\Framework\TestCase;

class EmailTest extends TestCase
{
    /**
     * @test
     */
    public function validation()
    {
        $this->expectException(\InvalidArgumentException::class);

        new Email('email@example');
    }

    /**
     * @test
     */
    public function sanitize()
    {
        $email = new Email('email§@example.org');
        $this->assertEquals('email@example.org', $email->getEmail());
    }

    /**
     * @test
     */
    public function tolower()
    {
        $email = new Email('EmaIl@example.org');
        $this->assertEquals('email@example.org', $email->getEmail());
    }

    /**
     * @test
     */
    public function equals()
    {
        $email1 = new Email('EmaIl@example.org');
        $email2 = new Email('email§@example.org');
        $this->assertTrue($email1->equals($email2));
    }

    /**
     * @test
     */
    public function notEquals()
    {
        $email1 = new Email('EmaIl@example.org');
        $email2 = new Email('mon.email@example.org');
        $this->assertFalse($email1->equals($email2));
    }
}
