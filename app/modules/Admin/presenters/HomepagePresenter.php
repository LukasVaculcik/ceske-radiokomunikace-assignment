<?php

declare(strict_types=1);

namespace App\AdminModule\Presenters;

use App\Model\AnimalRepository;

final class HomepagePresenter extends BasePresenter
{
	public function __construct(
		private AnimalRepository $animalRepository,
	)
	{
        parent::__construct();
    }

	public function renderDefault()
	{
		$this->template->animals = $this->animalRepository->findAnimals()->fetchAll();
	}
}