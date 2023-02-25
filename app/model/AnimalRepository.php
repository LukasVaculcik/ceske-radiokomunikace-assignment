<?php

namespace App\Model;

use Exception;
use Nette\Database\Explorer;
use Nette\Database\Table\ActiveRow;
use Nette\Database\Table\Selection;

class AnimalRepository
{
    public const
        TABLE_PRIMARY = 'animal',
        COLUMN_PRIMARY_ID = 'id',
        COLUMN_PRIMARY_NAME = 'name',
        COLUMN_PRIMARY_SORT = 'sort',
        COLUMN_PRIMARY_IS_VISIBLE = 'is_visible',
        COLUMN_PRIMARY_DATE_CREATED = 'date_created',
        COLUMN_PRIMARY_DATE_UPDATED = 'date_updated',

        TABLE_TYPE = 'animal_has_type',
        COLUMN_TYPE_PARENT = 'animal_id',
        COLUMN_TYPE_ID = 'animal_type_id';

    public function __construct(
        private Explorer $database
    ) {}

    public function findAnimals(): Selection
    {
        return $this->database->table(self::TABLE_PRIMARY);
    }

    public function findAnimalById(int $id): Selection
    {
        return $this->findAnimals()->wherePrimary($id);
    }

    public function findVisibleAnimals(): Selection
    {
        return $this->findAnimals()->where(self::COLUMN_PRIMARY_IS_VISIBLE, true);
    }
    
    public function createAnimal(array $values): ActiveRow
    {
        $row = $this->findAnimals()->insert($values);
        return $row;
    }

    public function updateAnimal(int $id, array $values): void
    {
        $this->findAnimalById($id)->update($values);
    }

    public function deleteAnimal(int $id): void
    {
        $row = $this->findAnimalById($id);
        $object = $row->fetch();

        if (!$object) {
            throw new Exception('Record does not exist');
        }

        $row->delete();
    }

    public function sortAnimals(array $ids): void
    {
        foreach ($ids as $sort => $id) {
            $this->findAnimalById($id)
            ->update([self::COLUMN_PRIMARY_SORT => $sort]);
        }
    }
}