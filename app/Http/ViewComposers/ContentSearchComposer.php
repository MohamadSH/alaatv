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
        $tags = [] ;
        if($this->request->has("tags"))
            $tags =  $this->request->tags;
        $extraTags = $tags;

        $tree = $this->category->getWithDepth();
        $majors = $tree->where('depth',2)->pluck('name','id')->unique();
        $grades = $tree->where('depth',3)->pluck('name', 'id')->unique();
        $lessons  = $tree->where('depth',4)->pluck('name', 'id')->unique();
        $teachers = User::getTeachers()->pluck("full_name_reverse", "id");

        $defaultMajor  = $this->findDefault($tags, $majors->toArray());
        if ($defaultMajor && ($key = array_search($this->make_slug($majors[$defaultMajor] , "_"), $extraTags)) !== false) {
            unset($extraTags[$key]);
        }
        $defaultGrade =$this->findDefault($tags, $grades->toArray());
        if ($defaultGrade && ($key = array_search($this->make_slug($grades[$defaultGrade] , "_"), $extraTags)) !== false) {
            unset($extraTags[$key]);
        }
        $defaultLesson = $this->findDefault($tags, $lessons->toArray());
        if ($defaultLesson && ($key = array_search($this->make_slug($lessons[$defaultLesson] , "_"), $extraTags)) !== false) {
            unset($extraTags[$key]);
        }
        $defaultTeacher =$this->findDefault($tags, $teachers->toArray());
        if ($defaultTeacher && ($key = array_search($this->make_slug($teachers->toArray()[$defaultTeacher] , "_"), $extraTags)) !== false) {
            unset($extraTags[$key]);
        }

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
        $view->with(compact('grades','majors','lessons','teachers','defaultLesson','defaultTeacher','defaultGrade','defaultMajor','sideBarMode','ads1','ads2' , 'tags' , 'extraTags'));

    }

    /**
     * @param $tags
     * @param $inputs
     * @return string
     */
    private function findDefault(array $tags, array $inputs)
    {
        $inputSlug =  array_map(function ($input) {
            return  $this->make_slug($input, '_');
        }, $inputs);
        $default = array_intersect($tags, $inputSlug);
        if(is_array($default))
        {
            $default = array_first($default);
            return array_search($default, $inputSlug);
        }
        return null;
    }
}