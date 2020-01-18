<?php

namespace App\Http\ViewComposers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class HeaderComposer
{
    /**
     * @var Request
     */
    private $request;

    private $defaultProfileImg;

    /**
     * Create a new Profile composer.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request           = $request;
        $this->defaultProfileImg = config('constants.PROFILE_DEFAULT_IMAGE');
    }

    /**
     * Bind data to the view.
     *
     * @param View $view
     *
     * @return void
     */
    public function compose(View $view)
    {
        $user         = $this->request->user();
        $profileImage = ($user != null ? $user->photo : route('image',
            ['category' => '1', 'w' => '39', 'h' => '39', 'filename' => $this->defaultProfileImg]));

        //Checking for liveStream
//        $live = LiveStreamAssistant::isThereLiveStream();

        $view->with(compact('profileImage'));
    }
}
