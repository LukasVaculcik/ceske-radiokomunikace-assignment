<?php

declare(strict_types=1);

namespace App\FrontModule\Presenters;

class BasePresenter extends \App\BaseModule\Presenters\BasePresenter
{
    public function injectRepository() {}

    protected function beforeRender()
    {
        parent::beforeRender();
    }
}