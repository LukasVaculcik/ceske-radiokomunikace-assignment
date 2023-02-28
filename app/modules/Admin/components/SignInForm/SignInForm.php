<?php

declare(strict_types=1);

namespace App\AdminModule\Components;

use Nette\Application\UI\Control;
use Nette\Application\UI\Form;
use Nette\Security\AuthenticationException;
use Nette\Security\User;

class SignInForm extends Control
{
    public const
        FIELD_EMAIL = "email",
        FIELD_PASSWORD = "password",
        FIELD_REMEMBER = "remember",
        FIELD_SUBMIT = "submit";

    public $onSuccess = null;
    public $onError = null;

    public function __construct(
        private User $user,
        $onSuccess,
        $onError
    ) {
        $this->onSuccess = $onSuccess;
        $this->onError = $onError;
    }

    public function render(): void
    {
        $this->template->setFile(__DIR__ . '/SignInForm.latte');
        $this->template->render();
    }

    public function createComponentForm(): Form
    {
        $form = new Form;
        $form->addText(self::FIELD_EMAIL, 'Email:')
            ->setRequired('Please enter your email.');

        $form->addPassword(self::FIELD_PASSWORD, 'Password:')
            ->setRequired('Please enter your password.');

        $form->addCheckbox(self::FIELD_REMEMBER, 'Keep me signed in');

        $form->addSubmit(self::FIELD_SUBMIT, 'Sign in');

        $form->onSuccess[] = function (Form $form, \stdClass $data) {
            try {
                $this->user->setExpiration($data->remember ? '14 days' : '20 minutes');
                $this->user->login($data->email, $data->password);
            } catch (AuthenticationException $e) {
                $form->addError('The email or password you entered is incorrect.');
                return;
            }
            if ($this->onSuccess) {
                ($this->onSuccess)($data);
            }
        };

        return $form;
    }
}
