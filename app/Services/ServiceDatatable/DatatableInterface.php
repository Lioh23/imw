<?php 

namespace App\Services\ServiceDatatable;


interface DatatableInterface
{
    public function getQueryBuilder($parameters = []);

    public function dataTable($queryBuilder, $requestData = []);
}