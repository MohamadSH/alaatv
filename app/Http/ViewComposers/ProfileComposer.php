<?php

namespace App\Http\ViewComposers;


use Illuminate\View\View;

class ProfileComposer
{

    /**
     * Create a new Profile composer.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Bind data to the view.
     *
     * @param  View $view
     * @return void
     */
    public function compose(View $view)
    {
//        $view->with('count', $this->users->count());
    }
}