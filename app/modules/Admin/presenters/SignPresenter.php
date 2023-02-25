<?php

declare(strict_types=1);

namespace App\AdminModule\Presenters;

use App\AdminModule\Factories\SignInFormFactory;
use Nette\Application\UI\Form;

final class SignPresenter extends \App\BaseModule\Presenters\BasePresenter
{
    public function __construct(
        private SignInFormFactory $signInFactory
    ){}
    
    protected function createComponentSignInForm(): Form
	{
		return $this->signInFactory->create(function (): void {
			$this->redirect('Homepage:default');
		});
	}

    public function actionOut(): void
	{
		$this->getUser()->logout();
	}
}
