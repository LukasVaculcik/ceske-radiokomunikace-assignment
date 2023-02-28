<?php

declare(strict_types=1);

namespace App\AdminModule\Factories;

use App\AdminModule\Components\SignInForm;
use Nette\Security\User;


final class SignInFormFactory
{
    public function __construct(
        private User $user
    ) {
    }

    public function create(?callable $onSuccess = null, ?callable $onError = null): SignInForm
    {
        return new SignInForm(
            $this->user,
            $onSuccess,
            $onError
        );
    }
}
