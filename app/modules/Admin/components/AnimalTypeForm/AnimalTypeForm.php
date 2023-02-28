<?php

declare(strict_types=1);

namespace App\AdminModule\Components;

use App\Model\AnimalRepository;
use Nette\Application\UI\Control;
use Nette\Application\UI\Form;
use Nette\Database\Table\ActiveRow;

class AnimalTypeForm extends Control
{

    public const
        FIELD_NAME = "name",
        FIELD_SUBMIT = "submit";

    public $onSuccess = null;
    public $onError = null;

    public function __construct(
        private readonly AnimalRepository $animalRepository,
        private readonly ?ActiveRow $defaultValues,
        $onSuccess,
        $onError
    ) {
        $this->onSuccess = $onSuccess;
        $this->onError = $onError;
    }

    public function render(): void
    {
        $this->template->setFile(__DIR__ . '/AnimalTypeForm.latte');
        $this->template->render();
    }

    public function createComponentForm(): Form
    {
        $form = new Form();

        $form->addText(self::FIELD_NAME, 'Type name')
            ->setRequired(true);

        $form->addSubmit(self::FIELD_SUBMIT, 'Save');

        if ($this->defaultValues) {
            $form->setDefaults($this->defaultValues);
        }

        $form->onSuccess[] = function (Form $form, array $values) {
            if ($this->onSuccess) {
                ($this->onSuccess)($values);
            }
        };

        return $form;
    }
}
