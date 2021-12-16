<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditTrail extends Model
{
    use HasFactory;

    protected $table = 'audit_trail';

    protected $fillable = [
        'user_id',
        'module',
        'action',
    ];

    public function audit($module, $action) {
        $this::create([
            'user_id' => \Auth::id(),
            'module' => $module,
            'action' => $action
        ]);
    }
}
