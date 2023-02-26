<?php

declare(strict_types=1);

namespace App\AdminModule\Components;

use Nette\Application\UI\Control;
use Nette\Database\Table\Selection;

class DataList extends Control {

    public function __construct(
        private Selection $data,
        private ?string $actionEdit,
        private ?string $actionDelete,
        private ?string $actionToggle,
    )
    {}

    public function render(): void
    {
        $this->template->setFile(__DIR__ . '/DataList.latte');
        $this->template->data = $this->data;
        $this->template->render();
    }

    public function handleEdit(?int $id = null): void
    {
        if($this->actionEdit){
            $this->getPresenter()->redirect($this->actionEdit, $id);
        }
    }

    public function handleDelete(int $id): void
    {
        if($this->actionDelete){
            $this->getPresenter()->redirect($this->actionDelete, $id);
        }
    }

    public function handleToggle(int $id): void
    {
        if($this->actionToggle){
            $this->getPresenter()->redirect($this->actionToggle, $id);
        }
    }

}