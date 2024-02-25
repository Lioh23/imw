<?php 

namespace App\Services\ServiceImportacao;

use App\Traits\CsvImportUtils;
use Illuminate\Support\Facades\Storage;

class LeitorCsvService
{
    use CsvImportUtils;

    public function execute($fileName)
    {
        $csvContent = explode(PHP_EOL, Storage::get($fileName));
        $header     = collect(CsvImportUtils::clearStr(str_getcsv(array_shift(($csvContent)), ';')));
        $content    = collect($csvContent);
        
        $collect = $content
            ->filter(fn ($row) => strlen($row))
            ->map(function ($row) use ($header) {
                if(strlen($row)) return $header->combine(str_getcsv($row,';', '"'));
            })
            ->map(fn ($row) => $row->map(function ($value) {
                if ($value == '\0') return null;
                if (mb_strtolower($value) == 'true' || mb_strtolower($value) == 'false') return mb_strtolower($value) == 'true' ? true : false;
                return $value;
            }))
            ->sortBy('id')
            ->values();

        return $collect;
    }
}