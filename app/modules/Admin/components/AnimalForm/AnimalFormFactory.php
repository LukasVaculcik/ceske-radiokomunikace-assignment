<?php

namespace App\AdminModule\Factories;

use App\AdminModule\Components\AnimalForm;
use App\Model\AnimalRepository;
use Nette\Database\Table\ActiveRow;

class AnimalFormFactory
{
    public function __construct(
        private readonly AnimalRepository $animalRepository
    ) {}

    public function create(?ActiveRow $defaultValues, ?callable $onSuccess = null, ?callable $onError = null): AnimalForm
    {
        return new AnimalForm(
            $this->animalRepository,
            $defaultValues,
            $onSuccess,
            $onError
        );
    }
}