<?php

namespace App\Http\Controllers\Concerns;

use App\Models\Employee;
use App\Support\PersonnelRoutes;
use Illuminate\Support\Facades\Auth;

trait ManagesPersonnelAbsencesAndLeaves
{
    protected function getEmployee(): ?Employee
    {
        return Employee::forUser(Auth::id());
    }

    protected function personnelUrl(string $path = ''): string
    {
        return PersonnelRoutes::url($path);
    }

    protected function personnelRouteName(string $name): string
    {
        return PersonnelRoutes::routeName($name);
    }
}
