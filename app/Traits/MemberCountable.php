<?php

namespace App\Traits;

use App\Models\MembresiaMembro;

trait MemberCountable
{
    use Identifiable;

    public static function countRolAtual($vinculo)
    {
        return MembresiaMembro::where('vinculo', $vinculo)
            ->when($vinculo == 'M', function ($query) {
                $query->whereHas('rolAtual', function ($sub) {
                    $sub->withTrashed()->where('status', 'A');
                });
            }, function ($query) {
                $query->where('status', 'A');
            })
            ->where('igreja_id', Identifiable::fetchSessionIgrejaLocal()->id)
            ->withTrashed()
            ->count();
    }
    
    public static function countRolPermanente($vinculo)
    {
        return MembresiaMembro::with('rolAtual')
            ->where('vinculo', $vinculo)
            ->whereHas('rolAtual', function ($query) {
                $query->withTrashed()->whereIn('status', ['A', 'I']);
            })
            ->where('igreja_id', Identifiable::fetchSessionIgrejaLocal()->id)
            ->withTrashed()
            ->count();
    }

    public static function countExcluidos($vinculo) 
    {
        return MembresiaMembro::where('vinculo', $vinculo)
            ->where('status', 'I')
            ->where('igreja_id', Identifiable::fetchSessionIgrejaLocal()->id)
            ->withTrashed()
            ->count();
    }

    public static function countHasErrors($vinculo)
    {
        return MembresiaMembro::where('vinculo', $vinculo)->where('has_errors', 1)
            ->where('igreja_id', Identifiable::fetchSessionIgrejaLocal()->id)
            ->count();
    }
}