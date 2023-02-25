<?php

declare(strict_types=1);

namespace App\AdminModule\Factories;

use Nette\Application\UI\Form;
use Nette\Security\User;
use Nette\Security\AuthenticationException;


final class SignInFormFactory
{
	public function __construct(
        private User $user
    )
	{}

	public function create(callable $onSuccess): Form
	{
		$form = new Form;
		$form->addText('email', 'Email:')
			->setRequired('Please enter your email.');

		$form->addPassword('password', 'Password:')
			->setRequired('Please enter your password.');

		$form->addCheckbox('remember', 'Keep me signed in');

		$form->addSubmit('send', 'Sign in');

		$form->onSuccess[] = function (Form $form, \stdClass $data) use ($onSuccess): void {
			try {
				$this->user->setExpiration($data->remember ? '14 days' : '20 minutes');
				$this->user->login($data->email, $data->password);
			} catch (AuthenticationException $e) {
				$form->addError('The email or password you entered is incorrect.');
				return;
			}
			$onSuccess();
		};

		return $form;
	}
}