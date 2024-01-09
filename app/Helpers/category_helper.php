<?php

function getCategories($db)
{
    $postCategories = [];
    //seelct category in each posts
    $builder = $db->table('post');
    $builder->select('ID_category');
    $result = $builder->get()->getResult();
    foreach($result as $res)
    {
        $ID_category = explode(',', $res->ID_category);
        foreach($ID_category as $ic)
        {
            if(!in_array($ic, $postCategories)) array_push($postCategories, $ic);
        }
    }

    $builder->resetQuery();
    $builder = $db->table('category');
    $builder->whereIn('ID', $postCategories);
    $builder->orderBy('name');
    $result = $builder->get()->getResult();
    return $result;
}

function categoryToArray($categories, $result)
{
    //categories = '1,6,9'
    //result = getResult
    $category   = [];
    $categories = explode(',', $categories);

    //make category by id key
    foreach($result as $re)
    {
        $category[$re->ID] = [
            'ID_category'   => $re->ID_category,
            'name'          => $re->name,
            'description'   => $re->description,
        ];
    }

    //go to categories;
    $output = [];
    for($i=0; $i<count($categories); $i++)
    {
        $output[] = $category[$categories[$i]];
    }
    return $output;
}

function spacer($max){
    $space = '';
    for($i=0;$i<$max;$i++){
        $space .= '&nbsp; &nbsp;&nbsp;';
    }
    return $space;
}

function categoryTreeCheck($data, $parent = 0, $depth = 0, $ID_category = ''){
    $tree = "";
    $ID_categories = array_map('intval', explode(',', $ID_category));
    for ($i=0, $ni=count($data); $i<$ni; $i++)
    {
        if ($data[$i]['ID_category'] == $parent)
        {
            $checked = (in_array($data[$i]['ID'], $ID_categories)) ? ' checked="checked"' : '';
            $tree .= '<p class="m-0 py-1">'.spacer($depth).'<input type="checkbox" name="category[]" value="'.$data[$i]['ID'].'"'.$checked.'> '.$data[$i]['name'].'</p>';
            $tree .= categoryTreeCheck($data, $data[$i]['ID'], $depth+1, $ID_category);
        }
    }
    return $tree;
}

function generateTreeRow($data, $page, $user_ID, $parent = 0, $depth=0, $category_ID=[]){
    $tree = "";
    for ( $i=0,$ni=count($data); $i<$ni; $i++ ) {
        if ($data[$i]["parent_ID"] == $parent) {

            $edit   = ( $data[$i]["user_ID"]==$user_ID || $user_ID==1 ) ? '<a href="'.base_url().'?page='.$page.'&action=edit&id='.$data[$i]["ID"].'&key='.md5($user_ID.$data[$i]["ID"].SECURE).'">': '<a href="#">';
            $delete = ( $data[$i]["user_ID"]==$user_ID || $user_ID==1 ) ? '<a href="'.base_url().'?page='.$page.'&action=delete&id='.$data[$i]["ID"].'&key='.md5($user_ID.$data[$i]["ID"].SECURE).'" onclick="return confirm(\'Confirm deletion?\')">': '<a href="#">';

            $tree .= '<tr><td style="width: 35px;">'.$edit.'&nbsp; <i class="icon icon-pencil"></i></a>&nbsp;';
            $tree .= $delete.' <i class="icon icon-trash"></i></a></td>';
            $tree .= '<td>'.dash($depth);
            if($depth==0){
                $tree .= '<strong>'.$data[$i]['name'].'<strong>';
            }else{
                $tree .= $data[$i]['name'];
            }
            $tree .= '</td><td>'.$data[$i]["description"].'</td></tr>';
            $tree .= generateTreeRow($data, $page, $user_ID, $data[$i]["ID"], $depth+1);
        }
    }
    return $tree;
}

function getTags($db)
{
    $tags = [];
    $builder = $db->table('post');
    $builder->select('tags');
    $builder->orderBy('date_created', 'DESC');
    $result = $builder->get()->getResult();
    foreach($result as $res)
    {
        $myTags = ($res->tags) ? explode(',', $res->tags) : [];
        $myTags = array_map('strtolower', $myTags);
        for($i=0; $i<count($myTags); $i++)
        {
            $myTags[$i] = trim($myTags[$i]);
            if(!isset($tags[$myTags[$i]])) $tags[$myTags[$i]] = 0;
            $tags[$myTags[$i]]++;
        }
    }
    $tags_arr = [];
    $keys = array_keys($tags);
    foreach($keys as $key)
    {
        $tags_arr[] = [
            'tag'   => $key,
            'count' => $tags[$key],
        ];
    }

    //sorting array
    array_multisort(
        array_column($tags_arr, 'count'),
        SORT_DESC,
        $tags_arr
    );

    return $tags_arr;
}