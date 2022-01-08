<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BackupInfo extends Model
{
    

    protected $table = 'backup_info';

    protected $fillable = [
        'file_name',
    ];

}
