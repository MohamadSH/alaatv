<?php

namespace App\Http\Controllers;

use App\Console\Commands\CategoryTree\TotalTree;
use Illuminate\Http\Request;

class TopicsTreeController extends Controller
{
    /**
     * @param  Request  $request
     *
     * @return
     */
    public function lernitoTree(Request $request)
    {
        $TotalTree = new TotalTree();
        $htmlPrint = $TotalTree->getLernitoTreeHtmlPrint();
        return view('admin.topicsTree.index', compact('htmlPrint'));
    }
    
    public function getTreeInPHPArrayString(Request $request, $lnid)
    {
        $TotalTree    = new TotalTree();
        $stringFormat = $TotalTree->getTreeNodeByIdInHtmlString($lnid);
        return $stringFormat;
    }
}
