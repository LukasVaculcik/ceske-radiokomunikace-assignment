<?php

declare(strict_types=1);

namespace App\FrontModule\Presenters;

use App\Model\AnimalRepository;

final class HomepagePresenter extends BasePresenter
{
    public function __construct(
        private readonly AnimalRepository $animalRepository,
    ) {
        parent::__construct();
    }

    public function renderDefault()
    {
        $animals = $this->animalRepository->findVisibleAnimals()->fetchAll();
        $types = $this->animalRepository->findAnimalTypes()->fetchAll();

        $animalHasType = $this->animalRepository->findAnimalHasType()->fetchPairs(AnimalRepository::COLUMN_HAS_TYPE_PARENT, AnimalRepository::COLUMN_HAS_TYPE_ID);

        $grid = array_map(function ($type) use ($animalHasType) {
            $animalIds = array_keys(
                array_filter($animalHasType, function ($hasTypeId) use ($type) {
                    return $type->id === $hasTypeId;
                })
            );
            return [
                'name' => $type->name,
                'animals' => $animalIds,
            ];
        }, $types);

        $this->template->animals = $animals;
        $this->template->grid = $grid;
    }
}
