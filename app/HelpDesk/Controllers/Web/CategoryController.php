<?php

namespace App\HelpDesk\Controllers\Web;

use App\Category;
use App\Http\Requests\Request;

class CategoryController
{
    public function store(Request $request)
    {
        $tags = convertTagStringToArray(array_get($request->get('tags') , 'tags'));
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

        $parentId = $request->get('parent_id');
        if(isset($parentId)){
            $parent = Category::Find($parentId);
        }

        if(isset($parent)){
            $node->appendToNode($parent)->save();
        }else{
            $node->makeRoot()->save();
        }

        return response()->json([
            'message' => 'Node has benn inserted successfully' ,
        ]);
    }

    public function update(Request $request , Category $node)
    {
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
}
