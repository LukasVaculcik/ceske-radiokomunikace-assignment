<?php

declare(strict_types=1);

namespace App\BaseModule\Presenters;

use Nette\Application\UI\Presenter;

class BasePresenter extends Presenter
{

    protected function beforeRender()
    {
        parent::beforeRender();
    }

}
