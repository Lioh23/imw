<?php

namespace App\DataTables;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;

abstract class AbstractDatatable
{
    public function execute(array $requestData): JsonResponse
    {
        $parameters = isset($requestData['parameters']) ? $requestData['parameters'] : [];

        $queryBuilder = $this->getQueryBuilder($parameters);

        return $this->dataTable($queryBuilder, $requestData);
    }

    protected abstract function getQueryBuilder(array $parameters): Builder;

    protected abstract function dataTable(Builder $queryBuilder, array $requestData): JsonResponse;
}