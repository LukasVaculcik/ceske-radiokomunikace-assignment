<?php


namespace App\Services;

use App\Model\UserRepository;
use DateTime;
use Nette\Security\AuthenticationException;
use Nette\Security\SimpleIdentity;
use Nette\Security\Passwords;

class Authenticator implements \Nette\Security\Authenticator
{
    public function __construct(
        private UserRepository $userRepository,
        private Passwords $passwords
    ) {}

    public function authenticate(string $username, string $password): SimpleIdentity
    {
        $row = $this->userRepository->findUsers()
            ->where(UserRepository::COLUMN_EMAIL. $username)
            ->fetch();

        if (!$row || !$this->passwords->verify($password, $row[UserRepository::COLUMN_PASSWORD_HASH])) {
            throw new AuthenticationException('Invalid credentials');
        }

        $row->update([UserRepository::COLUMN_DATE_LOGGED => new DateTime()]);

        $userData = $row->toArray();
        unset($userData[UserRepository::COLUMN_PASSWORD_HASH]);
        return new SimpleIdentity(
            $row[UserRepository::COLUMN_ID],
            $row[UserRepository::COLUMN_ROLE],
            $userData
        );
    }
}