<?php

namespace Tests\Domain;

use Gogordos\Domain\Entities\UserId;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class UserIdTest extends TestCase
{

    public function should_require_instance_of_uuid()
    {
        $this->expectException(\Exception::class);

        $id = new UserId;
    }

    public function test_should_create_new_user_id()
    {
        $id = new UserId(Uuid::uuid4());

        $this->assertInstanceOf(UserId::class, $id);
    }

    public function test_should_create_user_id_from_string()
    {
        $id = UserId::fromString('d16f9fe7-e947-460e-99f6-2d64d65f46bc');

        $this->assertInstanceOf('Gogordos\Domain\Entities\UserId', $id);
        $this->assertEquals(36, strlen($id));
    }
}