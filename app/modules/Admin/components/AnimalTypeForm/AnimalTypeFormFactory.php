<?php

namespace App\AdminModule\Factories;

use App\AdminModule\Components\AnimalTypeForm;
use App\Model\AnimalRepository;
use Nette\Database\Table\ActiveRow;

class AnimalTypeFormFactory
{
    public function __construct(
        private readonly AnimalRepository $animalRepository
    ) {
    }

    public function create(?ActiveRow $defaultValues, ?callable $onSuccess = null, ?callable $onError = null): AnimalTypeForm
    {
        return new AnimalTypeForm(
            $this->animalRepository,
            $defaultValues,
            $onSuccess,
            $onError
        );
    }
}
