<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use \App\Models\ActivityLog ;

trait HandelActivityLog
{
    public function createActivityLog($data): void
    {
        $user=Auth::user();
        $data['performer']=$user->name;
        $data['timestamp']=now();

        ActivityLog::query()
            ->create($data);
    }
}
