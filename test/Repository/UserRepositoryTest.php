<?php

namespace Nabil\Tests\Repository;

use PHPUnit\Framework\TestCase;
use Nabil\MVC\config\Database;
use Nabil\MVC\Domain\User;
use Nabil\MVC\Repository\SessionRepository;
use Nabil\MVC\Repository\UserRepository;

class UserRepositoryTest extends TestCase
{

    private UserRepository $userRepository;
    private SessionRepository $sessionRepository;

    protected function setUp(): void
    {
        $this->sessionRepository = new SessionRepository(Database::getConnection());
        $this->sessionRepository->deleteAll();

        $this->userRepository = new UserRepository(Database::getConnection());
        $this->userRepository->deleteAll();
    }

    public function testSaveSuccess()
    {
        $user = new User();
        $user->id = "eko";
        $user->name = "Eko";
        $user->password = "rahasia";

        $this->userRepository->save($user);

        // lakukan query ke database
        $result = $this->userRepository->findById($user->id);

        self::assertEquals($user->id, $result->id);
        self::assertEquals($user->name, $result->name);
        self::assertEquals($user->password, $result->password);
    }

    // test idnya yang tidak ada
    public function testFindByIdNotFound()
    {
        $user = $this->userRepository->findById("notfound");
        self::assertNull($user);
    }

    // test update user
    public function testUpdate()
    {
        $user = new User();
        $user->id = "nabil";
        $user->name = "fadilah";
        $user->password = "rahasia";

        $this->userRepository->save($user);

        $user->name = "Budi";
        $this->userRepository->update($user);

        // lakukan query ke database
        $result = $this->userRepository->findById($user->id);

        // hasil yang diharapkan
        self::assertEquals($user->id, $result->id);
        self::assertEquals($user->name, $result->name);
        self::assertEquals($user->password, $result->password);
    }
}
