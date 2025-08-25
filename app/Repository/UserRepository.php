<?php
// representasi ke table users, untuk get, add, update, delete
namespace Nabil\MVC\Repository;

use Nabil\MVC\Domain\User;

class UserRepository
{
    private \PDO $connection;

    public function __construct(\PDO $connection)
    {
        $this->connection = $connection;
    }

    public function save(User $user): User
    {
        $statement = $this->connection->prepare("INSERT INTO users(id, name, password) VALUES (?, ?, ?)");
        $statement->execute([
            $user->id,
            $user->name,
            $user->password
        ]);
        return $user;
    }
}
