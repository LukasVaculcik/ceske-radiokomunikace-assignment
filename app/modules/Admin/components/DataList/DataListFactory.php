<?php

namespace App\AdminModule\Factories;

use App\AdminModule\Components\DataList;
use Nette\Database\Table\Selection;

class DataListFactory
{
    public function __construct(
    ) {}

    public function create(
        Selection $data,
        ?string $actionEdit = null,
        ?string $actionDelete = null,
        ?string $actionToggle = null
    ): DataList
    {
        return new DataList($data, $actionEdit, $actionDelete, $actionToggle);
    }
}