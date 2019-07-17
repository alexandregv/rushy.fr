<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;

class UpdateUsernames extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = "update:usernames";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Update players' usernames";

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //$stats_rushbox  = DB::table('stats_rushbox')->get();
        //$stats_rtf      = DB::table('stats_rtf')->get();
        //$stats_rushzone = DB::table('stats_rushzone')->get();
        $staff          = DB::table('staff')->get();
      
        $tables = ['staff' => $staff/*, 'stats_rushbox' => $stats_rushbox, 'stats_rtf' => $stats_rtf, 'stats_rushzone' => $stats_rushzone*/];
      
        foreach($tables as $table_name => $table)
        {
          echo "-----[" . $table_name . "]-----\n";
          foreach($table as $user)
          {
            $updated_name = uuid_to_username($user->uuid);
            if($user->pseudo != $updated_name)
            {
              echo $user->pseudo ." --> " . $updated_name . "\n";
              DB::table($table_name)->where('uuid', $user->uuid)->update(['pseudo' => $updated_name]);
            }
          }
          echo "\n\n";
        }
    }
}
