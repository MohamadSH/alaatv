<?php

namespace App\Http\Controllers\Web;

use App\Console\Commands\CategoryTree\TotalTree;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TopicsTreeController extends Controller
{
    /**
     * @param Request $request
     * @return
     */
    public function lernitoTree(Request $request)
    {
        $TotalTree = new TotalTree();
        list($htmlPrint, $treePathData) = $TotalTree->getLernitoTreeHtmlPrint();
        return view('admin.topicsTree.index', compact('htmlPrint', 'treePathData'));
    }

    public function getTreeInPHPArrayString(Request $request, $lnid)
    {
        $TotalTree = new TotalTree();
        $stringFormat = $TotalTree->getTreeNodeByIdInHtmlString($lnid);
        return $stringFormat;
    }
}
