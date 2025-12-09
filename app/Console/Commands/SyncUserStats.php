<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Project;

class SyncUserStats extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:sync-user-stats';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Recalculate total_claimed_projects and total_nett_budget for all users based on project history.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting user stats synchronization...');

        $users = User::all();
        $bar = $this->output->createProgressBar(count($users));

        foreach ($users as $user) {
            $completedProjects = $user->assignedProjects()
                ->where('status', 'completed')
                ->get();

            $count = $completedProjects->count();
            $totalBudget = $completedProjects->sum('pivot.payout_amount');

            $user->update([
                'total_claimed_projects' => $count,
                'total_nett_budget' => $totalBudget
            ]);

            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info('User statistics synchronized successfully!');
    }
}
