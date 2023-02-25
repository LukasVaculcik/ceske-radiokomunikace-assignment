<?php

declare(strict_types=1);

namespace App\AdminModule\Presenters;

class BasePresenter extends \App\BaseModule\Presenters\BasePresenter
{

    protected function startup()
    {
        parent::startup();
        
        if (!$this->getUser()->isLoggedIn()) {
            $this->redirect('Sign:in');
        }
    }
}
