<?php

declare(strict_types=1);

namespace App\FrontModule\Presenters;

use App\Model\AnimalRepository;

final class HomepagePresenter extends BasePresenter
{
	public function __construct(
		private readonly AnimalRepository $animalRepository,
	)
	{
        parent::__construct();
    }

	public function renderDefault()
	{
		$this->template->animals = $this->animalRepository->findVisibleAnimals()->fetchAll();
	}
}
