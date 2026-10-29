<?php

namespace App\Observers;

use App\Models\EmployeeModel;
use App\Models\UserModel;
use App\Models\UserEmployeeModel;
use Illuminate\Support\Facades\DB;

class EmployeeObserver
{
    /**
     * Handle the EmployeeModel "created" event.
     */
    public function created(EmployeeModel $employeeModel)
    {
        DB::transaction(function () use ($employeeModel) {
            $user = UserModel::create([
                'username'=>$employeeModel->work_id,
                'password'=>bcrypt($employeeModel->work_id),
                'role_id'=>1
            ]);
            UserEmployeeModel::create([
                'user_id'=>$user->user_id,
                'employee_id'=>$employeeModel->employee_id
            ]);
        });
    }

    /**
     * Handle the EmployeeModel "updated" event.
     */
    public function updated(EmployeeModel $employeeModel): void
    {
        //
    }

    /**
     * Handle the EmployeeModel "deleted" event.
     */
    public function deleted(EmployeeModel $employeeModel): void
    {
        //
    }

    /**
     * Handle the EmployeeModel "restored" event.
     */
    public function restored(EmployeeModel $employeeModel): void
    {
        //
    }

    /**
     * Handle the EmployeeModel "force deleted" event.
     */
    public function forceDeleted(EmployeeModel $employeeModel): void
    {
        //
    }
}
