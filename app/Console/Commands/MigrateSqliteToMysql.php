<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Config;

class MigrateSqliteToMysql extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:sqlite-to-mysql';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate data from local SQLite to the configured MySQL database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // 1. Confirm intention
        if (!$this->confirm('This will wipe the current database (MySQL) and import data from database/database.sqlite. Ensure your .env is configured for MySQL. Continue?')) {
            return;
        }

        $sqlitePath = database_path('database.sqlite');
        if (!file_exists($sqlitePath)) {
            $this->error("SQLite database not found at: $sqlitePath");
            return;
        }

        // 2. Configure separate SQLite connection
        Config::set('database.connections.sqlite_source', [
            'driver' => 'sqlite',
            'url' => env('DATABASE_URL'),
            'database' => $sqlitePath,
            'prefix' => '',
            'foreign_key_constraints' => env('DB_FOREIGN_KEYS', true),
        ]);

        $this->info('Reading from SQLite...');
        
        // 3. Disable Foreign Keys on Target
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // 4. Get all tables from SQLite
        // We list them manually to ensure order or just exclude system tables
        // Or better: dynamic.
        $tables = [
            'users',
            // 'password_reset_tokens', 
            // 'personal_access_tokens', // Skipped: Migration not present
            'universities',
            'banks',
            'projects',
            'deliverables',
            'claim_logs',
            'notifications',
            'activity_logs', // Corrected from activity_log
        ];

        
        foreach ($tables as $table) {
            $this->info("Migrating table: $table");
            
            // Wipe target table
            if (Schema::hasTable($table)) {
                DB::table($table)->truncate();
                
                // Fetch from source
                try {
                    $rows = DB::connection('sqlite_source')->table($table)->get();
                    
                    $bar = $this->output->createProgressBar(count($rows));
                    
                    foreach ($rows->chunk(100) as $chunk) {
                        $data = [];
                        foreach ($chunk as $row) {
                            $data[] = (array) $row;
                        }
                        DB::table($table)->insert($data);
                        $bar->advance(count($chunk));
                    }
                    $bar->finish();
                    $this->newLine();
                    
                } catch (\Exception $e) {
                    $this->error("Error extracting from $table: " . $e->getMessage());
                    // Continue to next table (some tables might not exist in sqlite)
                    continue;
                }
            } else {
                $this->warn("Table $table does not exist in target database. Run 'php artisan migrate' first.");
            }
        }

        // 5. Re-enable Foreign Keys
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $this->info('Migration completed successfully!');
    }
}
