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

        TABLE_TYPE = 'animal_type',
        COLUMN_TYPE_ID = 'id',
        COLUMN_TYPE_NAME = 'name',
        COLUMN_TYPE_DATE_CREATED = 'date_created',
        COLUMN_TYPE_DATE_UPDATED = 'date_updated',

        TABLE_HAS_TYPE = 'animal_has_type',
        COLUMN_HAS_TYPE_PARENT = 'animal_id',
        COLUMN_HAS_TYPE_ID = 'animal_type_id';

    public function __construct(
        private Explorer $database
    ) {
    }

    // Animal
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

        $idType = $values['type'];
        unset($values['type']);

        $row = $this->findAnimals()->insert($values);
        $this->createAnimalHasType($row[self::COLUMN_PRIMARY_ID], $idType);

        return $row;
    }

    public function updateAnimal(int $id, array $values): void
    {
        $this->findAnimalHasType()->where(self::COLUMN_HAS_TYPE_PARENT, $id)->delete();
        $idType = $values['type'];
        $this->createAnimalHasType($id, $idType);
        unset($values['type']);

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

    // Animal Type
    public function findAnimalTypes(): Selection
    {
        return $this->database->table(self::TABLE_TYPE);
    }

    public function findAnimalTypeById(int $id): Selection
    {
        return $this->findAnimalTypes()->wherePrimary($id);
    }

    public function createAnimalType(array $values): ActiveRow
    {
        $row = $this->findAnimalTypes()->insert($values);
        return $row;
    }

    public function updateAnimalType(int $id, array $values): void
    {
        $this->findAnimalTypeById($id)->update($values);
    }

    public function deleteAnimalType(int $id): void
    {
        $row = $this->findAnimalTypeById($id);
        $object = $row->fetch();

        if (!$object) {
            throw new Exception('Record does not exist');
        }

        $row->delete();
    }

    // Animal has type
    public function findAnimalHasType(): Selection
    {
        return $this->database->table(self::TABLE_HAS_TYPE);
    }

    public function createAnimalHasType(int $idAnimal, int $idType): ActiveRow
    {
        return $this->findAnimalHasType()->insert([
            self::COLUMN_HAS_TYPE_PARENT => $idAnimal,
            self::COLUMN_HAS_TYPE_ID => $idType,
        ]);
    }
}
