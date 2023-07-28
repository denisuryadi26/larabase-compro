<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MembershipReset extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'membership:midnight';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset Membership Reseller Every Midnight';

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
     * @return int
     */
    public function handle()
    {
        $current_date =date("Y-m-d", time());
        $count = 0;

        $listMembership = DB::table('temp_conf_users_order_summary')->whereDate('periode_start_date','<=',$current_date)->get();
        if (count($listMembership) == 0)
        {
            $this->info('Data reseller not found.');
        }

        foreach ($listMembership as $item => $value)
        {
            if ($current_date > $value->periode_end_date)
            {
                $id = \Ramsey\Uuid\Uuid::uuid4()->toString();
                DB::table('temp_conf_users_order_summary')->insert([
                    'id' => $id,
                    'user_id' => $value->id,
                    'periode_start_date' => $current_date,
                    'periode_end_date' => date("Y-m-d", strtotime("+2 month", time())),
                    'total_order' => 0,
                    'created_at' => date("Y-m-d H:m:i", time())
                ]);
                $count +=1;
            }
        }
        $this->info("Sukses mereset $count data membership");

    }
}
