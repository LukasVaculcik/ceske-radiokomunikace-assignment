<?php

declare(strict_types=1);

namespace App\AdminModule\Presenters;

use App\AdminModule\Components\SignInForm;
use App\AdminModule\Factories\SignInFormFactory;

final class SignPresenter extends \App\BaseModule\Presenters\BasePresenter
{
    public function __construct(
        private readonly SignInFormFactory $signInFormFactory
    ) {
    }

    protected function createComponentSignInForm(): SignInForm
    {
        return $this->signInFormFactory->create(function (): void {
            $this->redirect('Animal:default');
        });
    }

    public function actionOut(): void
    {
        $this->getUser()->logout();
    }
}
