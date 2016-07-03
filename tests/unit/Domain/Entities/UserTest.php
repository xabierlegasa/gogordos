<?php

namespace Tests\Domain\Entities;


use Gogordos\Domain\Entities\User;
use Gogordos\Domain\Entities\UserId;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class UserTest extends TestCase
{
    public function test_when_user_data_is_valid_user_is_created_correctly()
    {
        $user = User::register(
            new UserId(Uuid::fromString('46e7faad-c4db-4a6f-9f01-fe9d9322d238')),
            'hello@example.com',
            'username',
            'password'
        );

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals('46e7faad-c4db-4a6f-9f01-fe9d9322d238', $user->id());
        $this->assertEquals('hello@example.com', $user->email());
        $this->assertEquals('username', $user->username());
        $this->assertEquals('password', $user->password());
    }
}