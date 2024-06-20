<?php

namespace App\Services\ServiceDatatable;

class Datatable
{
    public function execute($requestData = [])
    {
        $queryBuilder = $this->getQueryBuilder($requestData['parameters']);

        return $this->dataTable($queryBuilder, $requestData);
    }

    public function getQueryBuilder($parameters = []) { }

    public function dataTable($queryBuilder, $requestData = []) { }
}