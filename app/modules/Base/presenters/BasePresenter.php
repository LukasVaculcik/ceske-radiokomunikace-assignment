<?php

declare(strict_types=1);

namespace App\BaseModule\Presenters;

use App\Services\ViteAssets;
use Nette\Application\UI\Presenter;
use Nette\Http\Url;

class BasePresenter extends Presenter
{
    private ViteAssets $viteAssets;
    
    public function injectViteAssets(
        ViteAssets $viteAssets
    ) {
        $this->viteAssets = $viteAssets;
    }

    protected function beforeRender()
    {
        parent::beforeRender();
        $this->template->viteAssets = $this->viteAssets;
    }

    public function getURL()
    {
        $httpRequest = $this->getHttpRequest();
        $rawUrl = $httpRequest->getUrl();
        return new Url($rawUrl);
    }

}
