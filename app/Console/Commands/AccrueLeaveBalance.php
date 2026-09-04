<?php

namespace App\Console\Commands;

use App\Models\Employee;
use Illuminate\Console\Command;

class AccrueLeaveBalance extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'leaves:accrue-balance';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Accrémente le solde de congé de tous les employés actifs de 1.5 jours par mois';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $employees = Employee::where('status', 0)->get();
        $count = 0;
        $resetCount = 0;

        foreach ($employees as $employee) {
            $wasReset = $employee->checkAndReset2YearBalance();
            if ($wasReset) {
                $resetCount++;
            }

            $employee->leave_balance_days = round(($employee->leave_balance_days ?? 0) + 1.5, 2);
            $employee->save();
            $count++;
        }

        $this->info("Solde de congé accrémenté de 1.5 jours pour {$count} employé(s)" . ($resetCount > 0 ? " (dont {$resetCount} solde(s) réinitialisé(s) pour le cycle de 2 ans)." : "."));
        return Command::SUCCESS;
    }
}
