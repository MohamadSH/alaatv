<?php

namespace App\Observers;

use App\Employeetimesheet;
use Illuminate\Support\Facades\Artisan;

class EmployeetimesheetObserver
{
    /**
     * Handle the content "created" event.
     *
     * @param  \App\Employeetimesheet  $employeetimesheet
     *
     * @return void
     */
    public function created(Employeetimesheet $employeetimesheet)
    {

    }

    /**
     * Handle the content "updated" event.
     *
     * @param  \App\Employeetimesheet  $employeetimesheet
     *
     * @return void
     */
    public function updated(Employeetimesheet $employeetimesheet)
    {
    }

    /**
     * Handle the content "deleted" event.
     *
     * @param  \App\Employeetimesheet  $employeetimesheet
     *
     * @return void
     */
    public function deleted(Employeetimesheet $employeetimesheet)
    {
        //
    }

    /**
     * Handle the content "restored" event.
     *
     * @param  \App\Employeetimesheet  $employeetimesheet
     *
     * @return void
     */
    public function restored(Employeetimesheet $employeetimesheet)
    {
        //
    }

    /**
     * Handle the content "force deleted" event.
     *
     * @param  \App\Employeetimesheet  $employeetimesheet
     *
     * @return void
     */
    public function forceDeleted(Employeetimesheet $employeetimesheet)
    {
        //
    }

    /**
     * When issuing a mass update via Eloquent,
     * the saved and updated model events will not be fired for the updated models.
     * This is because the models are never actually retrieved when issuing a mass update.
     *
     * @param  Employeetimesheet  $employeetimesheet
     */
    public function saving(Employeetimesheet $employeetimesheet)
    {
    }

    public function saved(Employeetimesheet $employeetimesheet)
    {
        Artisan::call('cache:clear');
    }
}
