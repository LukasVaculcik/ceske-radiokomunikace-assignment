<?php

namespace App\Model;

use Nette\Database\Explorer;
use Nette\Database\Table\Selection;

final class UserRepository
{
    public const
        TABLE_NAME = 'user',
        COLUMN_ID = 'id',
        COLUMN_EMAIL = 'email',
        COLUMN_PASSWORD_HASH = 'password',
        COLUMN_DATE_LOGGED = 'date_logged';

    public function __construct(
        private Explorer $database
    ) {}

    public function findUsers(): Selection
    {
        return $this->database->table(self::TABLE_NAME);
    }
}
