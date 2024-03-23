<?php

namespace App\Traits;

use App\Models\MembresiaMembro;

trait MemberCountable
{
    public static function countRolAtual($vinculo)
    {
        return MembresiaMembro::where('vinculo', $vinculo)->count();
    }
    
    public static function countRolPermanente($vinculo)
    {
        return MembresiaMembro::where('vinculo', $vinculo)->onlyTrashed()->count();
    }

    public static function countHasErrors($vinculo)
    {
        return MembresiaMembro::where('vinculo', $vinculo)->where('has_errors', 1)->count();
    }
}