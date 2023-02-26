<?php

declare(strict_types=1);

namespace App\AdminModule\Presenters;

use App\AdminModule\Components\AnimalForm;
use App\AdminModule\Components\DataList;
use App\AdminModule\Factories\AnimalFormFactory;
use App\AdminModule\Factories\DataListFactory;
use App\Model\AnimalRepository;
use Exception;
use Nette\Application\BadRequestException;
use Nette\Database\Table\ActiveRow;

final class AnimalPresenter extends BasePresenter
{
    private ?ActiveRow $record = null;

	public function __construct(
		private readonly AnimalRepository $animalRepository,
		private readonly AnimalFormFactory $animalFormFactory,
		private readonly DataListFactory $dataListFactory,
	
	)
	{
        parent::__construct();
    }

    // RENDER
	public function renderDefault()
	{

	}

    // ACTIONS/HANDLES
    public function actionEdit(?int $id = null)
    {
        $this->record = empty($id) ? null : $this->animalRepository->findAnimalById($id)->fetch();
        if ($id && !$this->record) {
            throw new BadRequestException('Záznam neexistuje');
        }
    }

    public function actionToggle(int $id): void
    {
        $row = $this->animalRepository->findAnimalById($id);
        $visibility = $row->fetch()[AnimalRepository::COLUMN_PRIMARY_IS_VISIBLE];

        $this->animalRepository->findAnimalById($id)->update([AnimalRepository::COLUMN_PRIMARY_IS_VISIBLE => !$visibility]);

        if($visibility){
            $this->flashMessage('Záznam byl skryt');
        }else{
            $this->flashMessage('Záznam byl publikován');
        }

        $this->redirect('default');
    }

    public function actionDelete(int $id): void
    {
        try {
            $this->animalRepository->deleteAnimal($id);
            $this->flashMessage("Záznam byl smazán.");
        } catch (Exception $e) {
            $this->flashMessage($e->getMessage(), 'warning');
        }
        $this->redirect('default');
    }

    //CREATE COMPONENTS
    public function createComponentAnimalForm(): AnimalForm
    {
        return $this->animalFormFactory->create(
            $this->record,
            function($values){
                if ($this->record) {
                    $this->animalRepository->updateAnimal($this->record->id, $values);
                }else{
                    $this->animalRepository->createAnimal($values);
                }
                $this->redirect('default');
            },
        );
    }

    public function createComponentDataList(): DataList
    {
        $data = $this->animalRepository->findAnimals()->order('sort ASC, name ASC');
        return $this->dataListFactory->create(
            $data,
            'Animal:edit',
            'Animal:delete',
            'Animal:toggle',
        );
    }
}