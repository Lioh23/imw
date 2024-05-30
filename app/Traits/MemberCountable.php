<?php

namespace App\Traits;

use App\Models\MembresiaMembro;

trait MemberCountable
{
    use Identifiable;

    public static function countRolAtual($vinculo)
    {
        return MembresiaMembro::where('vinculo', $vinculo)
            ->where('igreja_id', Identifiable::fetchSessionIgrejaLocal()->id)
            ->count();
    }
    
    public static function countRolPermanente($vinculo)
    {
        return MembresiaMembro::where('vinculo', $vinculo)
            ->when($vinculo == 'M', function ($query) {
                $query->withTrashed();
            }, function ($query) {
                $query->onlyTrashed();
            })
            ->where('igreja_id', Identifiable::fetchSessionIgrejaLocal()->id)
            ->count();
    }

    public static function countHasErrors($vinculo)
    {
        return MembresiaMembro::where('vinculo', $vinculo)->where('has_errors', 1)
            ->where('igreja_id', Identifiable::fetchSessionIgrejaLocal()->id)
            ->count();
    }
}