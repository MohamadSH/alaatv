<?php

namespace App\Http\Controllers\Web;

use App\Category;
use App\Http\Controllers\Controller;
use Arr;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $nodes = Category::get()->toTree();
        return response()->json([
            'nodes' => $nodes
        ]);
        //Sample code for printing nodes
//        $traverse = function ($categories, $prefix = '-') use (&$traverse) {
//            foreach ($categories as $category) {
//                echo PHP_EOL.$prefix.' '.$category->name;
//                echo '<br>';
//
//                $traverse($category->children, $prefix.'-');
//            }
//        };
//
//        $traverse($nodes);
    }

    public function store(Request $request)
    {
        $tags = convertTagStringToArray($request->get('tags' , ''));
        $node = Category::create([
            'name'          => $request->get('name'),
            'description'   => $request->get('description'),
            'tags'          => (!empty($tags))?$tags:null,
        ]);

        if(!isset($node)){
            return response()->json([
                'error'=> [
                    'message' => 'Database on inserting node' ,
                ]
            ]);
        }

        $this->makeNodeRelations($node, $request->all());

        return response()->json([
            'message' => 'Node has benn inserted successfully' ,
        ]);
    }

    public function update(Request $request , Category $node)
    {
        $tags = convertTagStringToArray($request->get('tags'));
        $updateResult = $node->update([
            'name'          => $request->get('name'),
            'description'   => $request->get('description'),
            'tags'          => (!empty($tags))?$tags:null,
        ]);

        if($updateResult){
            return response()->json([
                'error'=> [
                    'message' => 'Database error on updating node' ,
                ]
            ]);
        }

        $this->makeNodeRelations($node, $request->all());

        return response()->json([
            'message' => 'Node has benn updated successfully' ,
        ]);
    }

    public function destroy(Category $node)
    {
        if($node->delete()){
            return response()->json([
                'message' => 'Node has benn deleted successfully' ,
            ]);
        }

        return response()->json([
            'error'=> [
                'message' => 'Database on deleting node' ,
            ]
        ]);

    }

    /**
     * @param Category $node
     * @param array $inputData
     */
    private function makeNodeRelations(Category $node, array $inputData): void
    {
        $parentId = Arr::get($inputData, 'parent_id');
        $isRoot = Arr::get($inputData, 'isRoot');
        if (isset($parentId)) {
            $parent = Category::where('id',$parentId)->first();
        } elseif (isset($isRoot)) {
            $node->makeRoot()->save();
        }

        if (isset($parent)) {
            $node->appendToNode($parent)->save();
        } else {
            $node->makeRoot()->save();
        }
    }
}
