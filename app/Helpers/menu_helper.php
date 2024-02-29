<?php

function getNavMenu($index = 0, $db)
{
    $navMenu = getOption('nav_menu', $db);
    $navMenu = unserialize($navMenu);
    $navMenu = $navMenu[$index];

    $pageIDs = [$navMenu['menu_ID']];
    $childs  = $navMenu['menu_child'];
    for($i=0; $i<count($childs); $i++)
    {
        array_push($pageIDs, $childs[$i]['menu_ID']);
        $childz = $childs[$i]['menu_child'];
        for($j=0; $j<count($childz); $j++)
        {
            array_push($pageIDs, $childz[$j]['menu_ID']);
            $childx = $childz[$j]['menu_child'];
            for($k=0; $k<count($childx); $k++)
            {
                array_push($pageIDs, $childx[$k]['menu_ID']);
                $child0 = $childx[$k]['menu_child'];
                for($l=0; $l<count($child0); $l++)
                {
                    array_push($pageIDs, $child0[$l]['menu_ID']);
                }
            }
        }
    }

    $builder = $db->table('page');
    $builder->select('ID,ID_page,title,slug,content,featured_image');
    $builder->whereIn('ID', $pageIDs);
    $result = $builder->get()->getResultArray();
    $realPages = [];
    foreach($result as $res)
    {
        $realPages[$res['ID']] = $res;
    }

    return [
        'menu'  => $navMenu,
        'page'  => $realPages,
    ];
}

function getMenuNewTree($textColor = 'text-light', $db)
{
    $menuOutput  = '';
    $menuNewTree = json_decode(getOption('menu_new_tree', $db), true);
    if(is_array($menuNewTree))
    {
        $menuID     = $menuNewTree['menuID'];
        $menuTitle  = $menuNewTree['menuTitle'];
        $menuURL    = $menuNewTree['menuURL'];

        //ambil konten dan featured image dulu dari parent 0
        $pageArr = $pageIDArr = [];
        for($i=0; $i<count($menuID[0]); $i++)
        {
            $parentID0  = $menuID[0][$i];
            if(substr($parentID0,0,1) == 'p') array_push($pageIDArr,substr($parentID0,1,strlen($parentID0)-1));
        }
        //get page data
        if(count($pageIDArr) > 0)
        {
            $builder = $db->table('page');
            $builder->select('ID, content, featured_image');
            $builder->whereIn('ID', $pageIDArr);
            $result = $builder->get()->getResult();
            foreach($result as $r)
            {
                $pageArr['p'.$r->ID] = [
                    'content'   => substr($r->content,0,150),
                    'image'     => $r->featured_image,
                ];
            }
        }

        //mulai tree dari parent 0
        for($i=0; $i<count($menuID[0]); $i++)
        {
            $parentID0  = $menuID[0][$i];
            if(isset($menuID[$parentID0])) $menuURL[$parentID0] = 'javascript:void(0)';
            $menuOutput .= '<li><a href="'.$menuURL[$parentID0].'" class="a-normal '.$textColor.'">'.$menuTitle[$parentID0].'</a>';
            //check if has child or not
            if(isset($menuID[$parentID0]))
            {
                $parentID1  = $menuID[$parentID0]; //masih array
                $mContent   = (isset($pageArr[$parentID0])) ? $pageArr[$parentID0]['content'] : '';
                //$mImage     = (isset($pageArr[$parentID0])) ? $pageArr[$parentID0]['image'] : '';
                $mgnLeft    = (isset($pageArr[$parentID0])) ? '0%' : '';
                //$tdDisplay  = (isset($pageArr[$parentID0])) ? '' : 'd-none';
                $cornerRad  = (isset($pageArr[$parentID0])) ? '' : 'border-top-left-radius: 0rem; border-bottom-left-radius: 0rem;';
                $menuOutput .= '<table border="0" style="margin-left: '.$mgnLeft.';"><tr><th colspan="2" class="p-0" style="font-size: 8px;"><small>&nbsp;</small></th></tr>';
                $menuOutput .= '<tr><td>';
                //$menuOutput .= '<div class="d-block"><h5 class="pt-2 mb-0">'.$menuTitle[$parentID0].'</h5>';
                $menuOutput .= '<p><small>'.$mContent.'</small></p></div></td>';
                $menuOutput .= '<td style="'.$cornerRad.'"><ul style="'.$cornerRad.'">';
                for($j=0; $j<count($parentID1); $j++)
                {
                    if(isset($menuID[$parentID1[$j]])) $menuURL[$parentID1[$j]] = 'javascript:void(0)';
                    //jadikan induk-semang jika punya child
                    $indukSemang = (isset($menuID[$parentID1[$j]])) ? ' class="induk-semang"' : '';
                    $indukSemanG = (isset($menuID[$parentID1[$j]])) ? ' <i class="bi bi-chevron-right"></i>' : '';
                    $menuOutput .= '<li'.$indukSemang.'>';
                    $menuOutput .= '<a href="'.$menuURL[$parentID1[$j]].'" class="a-normal text-dark">'.$menuTitle[$parentID1[$j]].$indukSemanG.'</a>';
                    if(isset($menuID[$parentID1[$j]]))
                    {
                        $parentID2  = $menuID[$parentID1[$j]];
                        $menuOutput .= '<ul class="anak-semang">';
                        for($k=0; $k<count($parentID2); $k++)
                        {
                            if(isset($menuID[$parentID2[$k]])) $menuURL[$parentID2[$k]] = 'javascript:void(0)';
                            //jadikan induk-semang jika punya child
                            $indukSemang1 = (isset($menuID[$parentID2[$k]])) ? ' class="induk-semang"' : '';
                            $indukSemanG1 = (isset($menuID[$parentID2[$k]])) ? ' <i class="bi bi-chevron-right"></i>' : '';
                            $menuOutput .= '<li'.$indukSemang1.'>';
                            $menuOutput .= '<a href="'.$menuURL[$parentID2[$k]].'" class="a-normal text-dark">'.$menuTitle[$parentID2[$k]].$indukSemanG1.'</a>';
                            if(isset($menuID[$parentID2[$k]]))
                            {
                                $parentID3  = $menuID[$parentID2[$k]];
                                $menuOutput .= '<ul class="anak-semang">';
                                for($l=0; $l<count($parentID3); $l++)
                                {
                                    if(isset($menuID[$parentID3[$l]])) $menuURL[$parentID3[$l]] = 'javascript:void(0)';
                                    //jadikan induk-semang jika punya child
                                    $indukSemang2 = (isset($menuID[$parentID3[$l]])) ? ' class="induk-semang"' : '';
                                    $indukSemanG2 = (isset($menuID[$parentID3[$l]])) ? ' <i class="bi bi-chevron-right"></i>' : '';
                                    $menuOutput .= '<li'.$indukSemang2.'>';
                                    $menuOutput .= '<a href="'.$menuURL[$parentID3[$l]].'" class="a-normal text-dark">'.$menuTitle[$parentID3[$l]].$indukSemanG2.'</a>';

                                    $menuOutput .= '</li>';
                                }
                                $menuOutput .= '</ul>';
                            }
                            $menuOutput .= '</li>';
                        }
                        $menuOutput .= '</ul>';
                    }
                    $menuOutput .= '</li>';
                }
                $menuOutput .= '</ul></td></tr></table>';
            }
            $menuOutput .= '</li>';
        }
    }
    return $menuOutput;
}

function getMenuNewNav($db)
{
    $menuOutput  = 'coba';
    $menuNewTree = json_decode(getOption('menu_new_tree', $db), true);
    if(is_array($menuNewTree) && $menuNewTree['menuID'])
    {
        $menuID     = $menuNewTree['menuID'];
        $menuTitle  = $menuNewTree['menuTitle'];
        $menuURL    = $menuNewTree['menuURL'];

        //mulai tree dari parent 0
        for($i=0; $i<count($menuID[0]); $i++)
        {
            $parentID0  = $menuID[0][$i];
            $menuOutput .= '<li class="d-block my-1">';
            $menuOutput .= '<div class="py-2 ps-3 pe-2 border border-1 cursor-compass">';
            $menuOutput .= '<div class="float-end me-1">';
            $menuOutput .= '<span class="d-inline-block me-2 pe-2 fw-bold cursor-pointer menu-plus" parent-target="#parent-'.$parentID0.'">+</span>';
            $menuOutput .= '<span class="d-inline-block fw-bold text-danger cursor-pointer menu-drop">x</span>';
            $menuOutput .= '</div>';
            $menuOutput .= '<div>'.$menuTitle[$parentID0].'</div>';
            $menuOutput .= '<input type="hidden" id="menu-'.$parentID0.'" name="menu-id[0][]" value="'.$parentID0.'">';
            $menuOutput .= '<input type="hidden" id="title-'.$parentID0.'" name="menu-title['.$parentID0.']" value="'.htmlspecialchars($menuTitle[$parentID0]).'">';
            $menuOutput .= '<input type="hidden" id="url-'.$parentID0.'" name="menu-url['.$parentID0.']" value="'.$menuURL[$parentID0].'">';
            $menuOutput .= '</div>';
            $menuOutput .= '<ul id="parent-'.$parentID0.'" class="menu-sortable">';
            //check if has child or not
            if(isset($menuID[$parentID0]))
            {
                $parentID1  = $menuID[$parentID0]; //masih array
                for($j=0; $j<count($parentID1); $j++)
                {
                    $menuOutput .= '<li class="d-block my-1">';
                    $menuOutput .= '<div class="py-2 ps-3 pe-2 border border-1 cursor-compass">';
                    $menuOutput .= '<div class="float-end me-1">';
                    $menuOutput .= '<span class="d-inline-block me-2 pe-2 fw-bold cursor-pointer menu-plus" parent-target="#parent-'.$parentID1[$j].'">+</span>';
                    $menuOutput .= '<span class="d-inline-block fw-bold text-danger cursor-pointer menu-drop">x</span>';
                    $menuOutput .= '</div>';
                    $menuOutput .= '<div>'.$menuTitle[$parentID1[$j]].'</div>';
                    $menuOutput .= '<input type="hidden" id="menu-'.$parentID1[$j].'" name="menu-id['.$parentID0.'][]" value="'.$parentID1[$j].'">';
                    $menuOutput .= '<input type="hidden" id="title-'.$parentID1[$j].'" name="menu-title['.$parentID1[$j].']" value="'.htmlspecialchars($menuTitle[$parentID1[$j]]).'">';
                    $menuOutput .= '<input type="hidden" id="url-'.$parentID1[$j].'" name="menu-url['.$parentID1[$j].']" value="'.$menuURL[$parentID1[$j]].'">';
                    $menuOutput .= '</div>';
                    $menuOutput .= '<ul id="parent-'.$parentID1[$j].'" class="menu-sortable">';
                    if(isset($menuID[$parentID1[$j]]))
                    {
                        $parentID2  = $menuID[$parentID1[$j]];
                        for($k=0; $k<count($parentID2); $k++)
                        {
                            $menuOutput .= '<li class="d-block my-1">';
                            $menuOutput .= '<div class="py-2 ps-3 pe-2 border border-1 cursor-compass">';
                            $menuOutput .= '<div class="float-end me-1">';
                            $menuOutput .= '<span class="d-inline-block me-2 pe-2 fw-bold cursor-pointer menu-plus" parent-target="#parent-'.$parentID2[$k].'">+</span>';
                            $menuOutput .= '<span class="d-inline-block fw-bold text-danger cursor-pointer menu-drop">x</span>';
                            $menuOutput .= '</div>';
                            $menuOutput .= '<div>'.$menuTitle[$parentID2[$k]].'</div>';
                            $menuOutput .= '<input type="hidden" id="menu-'.$parentID2[$k].'" name="menu-id['.$parentID1[$j].'][]" value="'.$parentID2[$k].'">';
                            $menuOutput .= '<input type="hidden" id="title-'.$parentID2[$k].'" name="menu-title['.$parentID2[$k].']" value="'.htmlspecialchars($menuTitle[$parentID2[$k]]).'">';
                            $menuOutput .= '<input type="hidden" id="url-'.$parentID2[$k].'" name="menu-url['.$parentID2[$k].']" value="'.$menuURL[$parentID2[$k]].'">';
                            $menuOutput .= '</div>';
                            $menuOutput .= '<ul id="parent-'.$parentID2[$k].'" class="menu-sortable">';
                            if(isset($menuID[$parentID2[$k]]))
                            {
                                $parentID3  = $menuID[$parentID2[$k]];
                                for($l=0; $l<count($parentID3); $l++)
                                {
                                    $menuOutput .= '<li class="d-block my-1">';
                                    $menuOutput .= '<div class="py-2 ps-3 pe-2 border border-1 cursor-compass">';
                                    $menuOutput .= '<div class="float-end me-1">';
                                    $menuOutput .= '<span class="d-inline-block me-2 pe-2 fw-bold cursor-pointer menu-plus" parent-target="#parent-'.$parentID3[$l].'">+</span>';
                                    $menuOutput .= '<span class="d-inline-block fw-bold text-danger cursor-pointer menu-drop">x</span>';
                                    $menuOutput .= '</div>';
                                    $menuOutput .= '<div>'.$menuTitle[$parentID3[$l]].'</div>';
                                    $menuOutput .= '<input type="hidden" id="menu-'.$parentID3[$l].'" name="menu-id['.$parentID1[$k].'][]" value="'.$parentID3[$l].'">';
                                    $menuOutput .= '<input type="hidden" id="title-'.$parentID3[$l].'" name="menu-title['.$parentID3[$l].']" value="'.htmlspecialchars($menuTitle[$parentID3[$l]]).'">';
                                    $menuOutput .= '<input type="hidden" id="url-'.$parentID3[$l].'" name="menu-url['.$parentID3[$l].']" value="'.$menuURL[$parentID3[$l]].'">';
                                    $menuOutput .= '</div>';
                                    $menuOutput .= '<ul id="parent-'.$parentID3[$l].'" class="menu-sortable"></ul></li>';
                                }
                            }
                            $menuOutput .= '</ul></li>';
                        }
                    }
                    $menuOutput .= '</ul></li>';
                }
            }
            $menuOutput .= '</ul></li>';
        }
    }
    return $menuOutput;
}