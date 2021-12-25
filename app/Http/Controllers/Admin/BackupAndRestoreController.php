<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BackupInfo;
use DB;
use DateTime;

class BackupAndRestoreController extends Controller
{
    public function index() {
        $res = DB::table('backup_info')->orderBy('created_at', 'desc')->first();
        $last_backup = "No backup database yet.";
        if (isset($res->file_name)) {
            $last_backup = 'Last backup: '.date('F d, Y h:i A', strtotime($res->created_at));
        }
        return view('admin.utilities.backup-and-restore.index', compact('last_backup'));
   }

    public function backup() {

        $filename = "backup-db-" . date('Y-m-d') .".sql";


        $command = "".env('DUMP_PATH')." --user=" . env('DB_USERNAME') . " --password=" . env('DB_PASSWORD') . " --host=" . env('DB_HOST') . " " . env('DB_DATABASE') . "  > " . storage_path() . "/app/backup/" . $filename;

        $returnVar = NULL;
        $output = NULL;

        exec($command, $output, $returnVar);
        BackupInfo::create([
            'file_name' => $filename
        ]);
        return redirect()->back()->with('success', 'Database was backup successfully.');
    }

    public function restore() {
        
        $sql = storage_path() . "/app/backup/backup-db-" . date('Y-m-d') .".sql";
        \DB::unprepared(file_get_contents($sql));
        return redirect()->back()->with('success', 'Database was restored successfully.');

        /*
        $db = [
            'username' => env('DB_USERNAME'),
            'password' => env('DB_PASSWORD'),
            'host' => env('DB_HOST'),
            'database' => env('DB_DATABASE')
        ];
    
        exec("mysql --user={$db['username']} --password={$db['password']} --host={$db['host']} --database {$db['database']} < $sql");
    
        \Log::info('SQL Import Done');*/
    }

    
    function timeAgo($datetime, $full = false) {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);
    
        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;
    
        $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }
    
        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' ago' : 'just now';
    }
}
