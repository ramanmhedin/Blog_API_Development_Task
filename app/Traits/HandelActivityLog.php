<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use \App\Models\ActivityLog ;

trait HandelActivityLog
{
    public function createActivityLog($data): void
    {
        $user=Auth::user() ?? null;
        $data['performer']=$user?->name ?? "un auth user";
        $data['performer_id']=$user?->id ?? null;
        $data['timestamp']=now();

        ActivityLog::query()
            ->create($data);
    }
}
