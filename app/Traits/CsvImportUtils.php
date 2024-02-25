<?php 

namespace App\Traits;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

trait CsvImportUtils
{
    public static function formatDateToImport(string|null $ptBrDate)
    {
        if (!$ptBrDate) return $ptBrDate;
        try {
            return Carbon::createFromFormat('d/m/Y', $ptBrDate)->format('Y-m-d');
        } catch(\Exception $e) {
            return null;
        }
    }

    public static function clearStr($str) {
        return preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $str);
    }

    public static function import($collection, $controle)
    {
        $conn = DB::connection();
        $conn->beginTransaction();
        $conn->statement('SET FOREIGN_KEY_CHECKS=0;');
        try {
            $collection->each(function ($item) use ($conn, $controle) {
                $conn->table($controle->target_table)->updateOrInsert($item);
            });
            $conn->table('controle_importacoes_csv')->where('id', $controle->id)->update(['executed' => true]);
            $conn->commit();
            $conn->statement('SET FOREIGN_KEY_CHECKS=1;');
            dd("Importação para {$controle->target_table} Realizada com sucesso!");
        } catch(\Exception $e) {
            $conn->rollBack();
            $conn->statement('SET FOREIGN_KEY_CHECKS=1;');
            dd($e->getMessage());
        }        
    }
}