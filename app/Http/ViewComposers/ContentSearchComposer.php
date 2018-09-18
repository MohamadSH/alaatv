<?php

namespace App\Http\ViewComposers;


use App\Category;
use App\Traits\CharacterCommon;
use App\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContentSearchComposer
{
    use CharacterCommon;
    /**
     * @var Category
     */
    protected $category;

    protected $request;

    /**
     * Create a new ContentSearch composer.
     *
     * @param Category $category
     * @param Request $request
     */
    public function __construct(Category $category , Request $request)
    {
        $this->category = $category;
        $this->request = $request;
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $tags =  $this->request->all()['tags'];

        $tree = $this->category->getWithDepth();
        $majors = $tree->where('depth',2)->pluck('name','id')->unique();
        $grades = $tree->where('depth',3)->pluck('name', 'id')->unique();
        $lessons  = $tree->where('depth',4)->pluck('name', 'id')->unique();
        $teachers = User::getTeachers()->pluck("full_name_reverse", "id");

        $defaultMajor  = $this->findDefault($tags, $majors->toArray());
        $defaultGrade =$this->findDefault($tags, $grades->toArray());
        $defaultLesson = $this->findDefault($tags, $lessons->toArray());
        $defaultTeacher =$this->findDefault($tags, $teachers->toArray());


        $sideBarMode = "closed";
//            $ads1 = [
//                //DINI SEBTI
//                'https://cdn.sanatisharif.ir/upload/ads/SMALL-SLIDE-1.jpg' => 'https://sanatisharif.ir/landing/4',
//            ];
//            $ads2 = [
//                //DINI SEBTI
//                'https://cdn.sanatisharif.ir/upload/ads/SMALL-SLIDE-2.jpg' => 'https://sanatisharif.ir/landing/4',
//                'https://cdn.sanatisharif.ir/upload/ads/SMALL-SLIDE-3.jpg' => 'https://sanatisharif.ir/landing/4',
//            ];
        $ads1 = [];
        $ads2 = [];

        $view->with(compact('grades','majors','lessons','teachers','defaultLesson','defaultTeacher','defaultGrade','defaultMajor','sideBarMode','ads1','ads2'));

    }

    /**
     * @param $tags
     * @param $inputs
     * @return string
     */
    private function findDefault(array $tags, array $inputs)
    {
        $default = array_intersect($tags, array_map(function ($input) {
            return  $this->make_slug($input, '_');
        }, $inputs));
        if(is_array($default))
            return array_first($default);
        return null;
    }
}