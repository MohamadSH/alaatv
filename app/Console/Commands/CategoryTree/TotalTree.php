<?php

namespace App\Console\Commands\CategoryTree;

class TotalTree
{
    public function getLernitoTreeHtmlPrint() {
        $Riazi = new Riazi();
        $Tajrobi = new Tajrobi();
        $Ensani = new Ensani();

        $lastUpdatedByLernito = $this->getLastUpdatedByLernito();

        /*return $lastUpdatedByLernito;*/

        $mote2 = [
            [
                'id' => '6321',
                'text' => 'ریاضی و فیزیک',
                'tags' => json_encode(['ریاضی_و_فیزیک'], JSON_UNESCAPED_UNICODE),
                'children' => $Riazi->getLernitoStyle()
            ],
            [
                'id' => '11552',
                'text' => 'علوم تجربی',
                'tags' => json_encode(['علوم_تجربی'], JSON_UNESCAPED_UNICODE),
                'children' => $Tajrobi->getLernitoStyle()
            ],
            [
                'id' => '15896',
                'text' => 'علوم انسانی',
                'tags' => json_encode(['علوم_انسانی'], JSON_UNESCAPED_UNICODE),
                'children' => $Ensani->getLernitoStyle()
            ]
        ];
        /*return $mote2;*/

        $htmlPrint = '';
        $treePathData = [];
        // loop in reshte
        $htmlPrint .= '<ul>';
        foreach ($mote2 as $key=>$value) {
            $pathString1 = $value['text'];
            $pathId1 = $value['id'];

            $lastUpdatedByLernitoKey = '';
            if ($key==0) {
                $lastUpdatedByLernitoKey = 'riaziUpdate';
            } elseif ($key==1) {
                $lastUpdatedByLernitoKey = 'tajrobiUpdate';
            } elseif ($key==2) {
                $lastUpdatedByLernitoKey = 'ensaniUpdate';
            }

            if (isset($lastUpdatedByLernito[$lastUpdatedByLernitoKey]) && count($lastUpdatedByLernito[$lastUpdatedByLernitoKey]['diff'])>0) {
                $value['hasNewItem'] = true;
                $this->updatePaieNodes($lastUpdatedByLernito[$lastUpdatedByLernitoKey], $value['children']);
            }

            $hasNew = '0';
            if (isset($value['hasNewItem']) && $value['hasNewItem']===true) {
                $hasNew = '1';
            }
            $htmlPrint .= '<li class="no_checkbox" data-has-new="'.$hasNew.'" data-alaa-node-id="'.$value['id'].'" data-jstree=\'{"checkbox_disabled":true, "icon":"/acm/extra/topicsTree/img/parent-icon.png"}\'>رشته: "'.$value['text'];

            // loop in paie
            $htmlPrint .= '<ul>';
            foreach ($value['children'] as $key1=>$value1) {
                $pathString2 = $pathString1.'@@**@@'.$value1['name'];
                $pathId2 = $pathId1.'-'.$value1['id'];

                $hasNew = '0';
                if (isset($value1['hasNewItem']) && $value1['hasNewItem']===true) {
                    $hasNew = '1';
                }
                $isNew = '0';
                if (isset($value1['isNewItem']) && $value1['isNewItem']===true) {
                    $isNew = '1';
                }

                $htmlPrint .= '<li class="no_checkbox" data-has-new="'.$hasNew.'" data-is-new="'.$isNew.'" data-alaa-node-id="'.$value1['id'].'" data-jstree=\'{"checkbox_disabled":true, "icon":"/acm/extra/topicsTree/img/parent-icon.png"}\'>پایه: '.$value1['name'];

                // loop in dars
                $htmlPrint .= '<ul>';
                foreach ($value1['children'] as $key2=>$value2) {
                    $pathString3 = $pathString2.'@@**@@'.$value2['name'];
                    $pathId3 = $pathId2.'-'.$value2['id'];
                    $htmlPrint .= $this->printDars($value2, $pathString3, $pathId3);
                }
                $htmlPrint .= '</ul></li>';
            }
            $htmlPrint .= '</ul></li>';
        }
        $htmlPrint .= '</ul>';

        return $htmlPrint;
    }

    private function iterateThroughTotalTree($tree)
    {
        $maxId = 0;
        if (isset($tree['id'])) {
            $tree['id'] = (int)$tree['id'];
            if ($tree['id']>$maxId) {
                $maxId = $tree['id'];
            }
            if (isset($tree['children']) && count($tree['children'])>0) {
                $newMaxId = $this->iterateThroughTotalTree($tree['children']);
                if ($newMaxId > $maxId) {
                    $maxId = $newMaxId;
                }
            }
        } else {
            foreach ($tree as $key => $value) {
                if (isset($value['id'])) {
                    $value['id'] = (int)$value['id'];
                }
                if (isset($value['id']) && $value['id']>$maxId) {
                    $maxId = $value['id'];
                }
                if (isset($value['children']) && count($value['children'])>0) {
                    $newMaxId = $this->iterateThroughTotalTree($value['children']);
                    if ($newMaxId > $maxId) {
                        $maxId = $newMaxId;
                    }
                }
            }
        }
        return $maxId;
    }

    private function printDars(array $nodeData, string $ps, string $pid) {
        global $treePathData;

        $name = 'درس: '.$nodeData['name'];
        $data = $nodeData['children'];
        $id = $nodeData['id'];

        $hasNew = '0';
        if (isset($nodeData['hasNewItem']) && $nodeData['hasNewItem']===true) {
            $hasNew = '1';
        }
        $isNew = '0';
        if (isset($nodeData['isNewItem']) && $nodeData['isNewItem']===true) {
            $isNew = '1';
        }

        $htmlPrint = '<li class="no_checkbox" data-has-new="'.$hasNew.'" data-is-new="'.$isNew.'" data-alaa-node-id="'.$id.'" data-jstree=\'{"checkbox_disabled":true, "icon":"/acm/extra/topicsTree/img/parent-icon.png"}\'>'.$name.'<ul>';
        foreach ($data as $key=>$value) {
            $pathString = $ps.'@@**@@'.$value['name'];
            $pathId = $pid.'-'.$value['id'];

            if(isset($value['children']) && count($value['children'])>0) {
                //                $htmlPrint .= '<li>('.$value['name'].')'.$this->printDars($value['name'], $value['children'], $value['id'], $pathString, $pathId).'</li>';
                $htmlPrint .= $this->printDars($value, $pathString, $pathId);
            } else {

                $isNewItem = '0';
                if (isset($value['isNewItem']) && $value['isNewItem']===true) {
                    $isNewItem = '1';
                }

                $htmlPrint .= '<li data-jstree=\'{"icon":"/acm/extra/topicsTree/img/book-icon-1.png"}\' data-alaa-node-id="'.$value['id'].'" data-is-new="'.$isNewItem.'" ps="'.$pathString.'" pid="'.$pathId.'" id="'.$value['id'].'">'.$value['name'].'</li>';
                $treePathData[$value['id']] = [
                    'ps' => $pathString,
                    'pid' => $pathId
                ];
            }
        }
        $htmlPrint .= '</ul></li>';
        return $htmlPrint;
    }

    private function changeLernitoNodeToAlaaNode(array &$lernitoNode) {
        $this->changeLernitoNodeChildren($lernitoNode);
        return $lernitoNode;
    }

    private function changeLernitoNodeChildren(array &$lernitoNodeChildren) {
        $lernitoNodeChildren['id'] = time().'-'.$lernitoNodeChildren['_id'];
        $lernitoNodeChildren['name'] = $lernitoNodeChildren['label'];
        $lernitoNodeChildren['tags'] = json_encode([str_replace(' ', '_', $lernitoNodeChildren['label'])], JSON_UNESCAPED_UNICODE);
        unset($lernitoNodeChildren['_id']);
        unset($lernitoNodeChildren['label']);
        if (isset($lernitoNodeChildren['children'])) {
            foreach ($lernitoNodeChildren['children'] as $key=>$child) {
                $this->changeLernitoNodeChildren($lernitoNodeChildren['children'][$key]);
            }
        }
    }

    private function updatePaieNodes(array $lastUpdatedByLernito, &$oldChildren) {
        if (isset($lastUpdatedByLernito['diff'])) {
            foreach ($lastUpdatedByLernito['diff'] as $diffKey=>$diffNode) {
                if (!isset($diffNode['diff']) && isset($diffNode['lernitoNode'])) {
                    $newItem = $this->changeLernitoNodeToAlaaNode($diffNode['lernitoNode']);
                    $newItem['isNewItem'] = true;
                    $oldChildren[] = $newItem;
                } elseif (isset($diffNode['diff']) && isset($diffNode['lernitoNode']) && isset($diffNode['alaaNode'])) {
                    foreach ($oldChildren as $oldChildrenKey=>$oldChildrenValue) {
                        if ($diffNode['alaaNode']['id'] == $oldChildrenValue['id']) {
                            $oldChildren[$oldChildrenKey]['hasNewItem'] = true;
                            $this->updatePaieNodes($diffNode, $oldChildren[$oldChildrenKey]['children']);
                        }
                    }
                }
            }
        }
    }

    public function getTreeNodeByIdInHtmlString($lnid) {

        if (!is_numeric($lnid)) {
            return '';
        }
        $lernitoNodeId = $lnid;
        $lastUpdatedByLernito = $this->getLastUpdatedByLernito();
        $maxId = $this->getLastIdOfTopicsTree();

        $nodeFound = $this->findLernitoNodeById($lastUpdatedByLernito, $lernitoNodeId);
        $this->changeLernitoNodeToAlaaNode($nodeFound);
        $stringFormat = str_replace('"', "'", $this->convertAlaaNodeArrayToStringFormat($nodeFound, $maxId));
        $stringFormat = str_replace(PHP_EOL, '', $stringFormat);

        return $stringFormat;
    }

    private function findLernitoNodeById(array $lastUpdatedByLernito, int $lernitoNodeId) {
        $nodeFound = null;
        foreach ($lastUpdatedByLernito as $key=>$value) {
            if (isset($value['lernitoNode']['_id']) && $value['lernitoNode']['_id'] == $lernitoNodeId) {
                return $value['lernitoNode'];
            } elseif (isset($value['diff'])) {
                $nodeFound = $this->findLernitoNodeById($value['diff'], $lernitoNodeId);
                if ($nodeFound!=null) {
                    return $nodeFound;
                }
            }
        }
        return $nodeFound;
    }

    private function getLastUpdatedByLernito(): array {
        $Riazi = new Riazi();
        $Tajrobi = new Tajrobi();
        $Ensani = new Ensani();
        $lastUpdatedByLernito = [
            'riaziUpdate' => [
                'diff' => $Riazi->getLastUpdatedByLernito(),
                'alaaNode' => [
                    'id' => '6321',
                    'text' => 'ریاضی و فیزیک',
                    'tags' => json_encode(['ریاضی_و_فیزیک'], JSON_UNESCAPED_UNICODE),
                ]
            ],
            'tajrobiUpdate' => [
                'diff' => $Tajrobi->getLastUpdatedByLernito(),
                'alaaNode' => [
                    'id' => '11552',
                    'text' => 'علوم تجربی',
                    'tags' => json_encode(['علوم_تجربی'], JSON_UNESCAPED_UNICODE),
                ]
            ],
            'ensaniUpdate' => [
                'diff' => $Ensani->getLastUpdatedByLernito(),
                'alaaNode' => [
                    'id' => '15896',
                    'text' => 'علوم انسانی',
                    'tags' => json_encode(['علوم_انسانی'], JSON_UNESCAPED_UNICODE),
                ]
            ]
        ];
        return $lastUpdatedByLernito;
    }

    private function getTotalTopicsTree(): array {
        $Riazi = new Riazi();
        $Tajrobi = new Tajrobi();
        $Ensani = new Ensani();
        $totalTree = array_merge($Riazi->getTree(), $Tajrobi->getTree(), $Ensani->getTree());
        return $totalTree;
    }

    private function getLastIdOfTopicsTree(): int {
        $maxId = 0;
        $totalTree = $this->getTotalTopicsTree();
        $maxId = $this->iterateThroughTotalTree($totalTree);
        return $maxId;
    }

    private function convertAlaaNodeArrayToStringFormat(array  $alaaNode, &$nodeId): string {

        if (isset($alaaNode['name'])) {
            $nodeId++;
            $nodeArrayString = "
            <div class='objectWraper'>
                <div>[</div>";
            $nodeArrayString .= "
                    <div class='objectBody'>
                        <div>'id' => '$nodeId',</div>
                        <div>'name' => '".$alaaNode['name']."',</div>
                        <div>'tags' => ".json_encode([str_replace(' ', '_', $alaaNode['name'])], JSON_UNESCAPED_UNICODE).",</div>
                        <div>'children' => ".$this->convertAlaaNodeArrayToStringFormat((isset($alaaNode['children']))? $alaaNode['children'] : [], $nodeId)."</div>
                    </div>";
            $nodeArrayString .= "
                <div>]</div>
            </div>";
        } else {
            $nodeArrayString = "[";
            foreach ($alaaNode as $key=>$value) {
                $nodeId++;
                $nodeArrayString .= "
                    <div class='inChildren'>
                        <div>[</div>";
                $nodeArrayString .= "
                            <div class='objectBody'>
                                <div>'id' => '$nodeId',</div>
                                <div>'name' => '".$value['name']."',</div>
                                <div>'tags' => ".json_encode([str_replace(' ', '_', $value['name'])], JSON_UNESCAPED_UNICODE).",</div>
                                <div>'children' => ".$this->convertAlaaNodeArrayToStringFormat((isset($value['children']))? $value['children'] : [], $nodeId)."</div>
                            </div>";
                $nodeArrayString .= "
                        <div>],</div>
                    </div>";
            }
            if (count($alaaNode)>0) {
                $nodeArrayString .= "
                    <div>]</div>";
            } else {
                $nodeArrayString .= "]";
            }
        }
        return $nodeArrayString;
    }
}