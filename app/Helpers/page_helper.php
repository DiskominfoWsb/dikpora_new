<?php

function registerPageNavMenu($data, $db)
{
    $builder = $db->table('option');
    $builder->where('option_name', $data['option_name']);
    if($builder->get()->getNumRows() > 0)
    {
        $builder->update($data);
    }
    else
    {
        $data['ID']     = null;
        $data['status'] = '1';
        $builder->insert($data);
    }
    return $db->affectedRows();
}

function pageTreeRadio($data, $parent = 0, $depth = 0, $check = 0){
    $tree = '';
    for ($i=0, $ni=count($data); $i<$ni; $i++)
    {
        $pid = ($data[$i]['ID'] <= 1) ? 0 : $data[$i]['ID'];
        if ($data[$i]['ID_page'] == $parent)
        {
            $checked = ($data[$i]['ID'] == $check) ? ' checked="checked"' : '';
            $tree .= '<p class="m-0 py-1">'.spacer($depth).'<input type="radio" name="parent" value="'.$pid.'"'.$checked.'> '.substr($data[$i]['title'],0,30).' ...</p>';
            $tree .= pageTreeRadio($data, $data[$i]['ID'], $depth+1, $check);
        }
    }
    return $tree;
}
