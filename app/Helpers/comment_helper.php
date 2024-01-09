<?php

function unapproveCommentCount($db)
{
    $builder = $db->table('comment');
    $builder->selectCount('ID');
    $builder->where('status', '0');
    $result = $builder->get()->getRow();
    return $result->ID;
}

function getPostComment($id, $db, $order = 'ASC')
{
    $builder = $db->table('comment');
    $builder->where('type', 'post');
    $builder->where('ID_post_page', $id);
    $builder->where('status', '1');
    $builder->orderBy('date_submit', $order);
    $result = $builder->get()->getResult();
    return $result;
}

function getPostCommentArray($id, $db, $order = 'ASC')
{
    $builder = $db->table('comment');
    $builder->where('type', 'post');
    $builder->where('ID_post_page', $id);
    $builder->where('status', '1');
    $builder->orderBy('date_submit', $order);
    $result = $builder->get()->getResultArray();
    return $result;
}

function getPageComment($id, $db, $order = 'ASC')
{
    $builder = $db->table('comment');
    $builder->where('type', 'page');
    $builder->where('ID_post_page', $id);
    $builder->where('status', '1');
    $builder->orderBy('date_submit', $order);
    $result = $builder->get()->getResult();
    return $result;
}

function getPageCommentArray($id, $db, $order = 'ASC')
{
    $builder = $db->table('comment');
    $builder->where('type', 'page');
    $builder->where('ID_post_page', $id);
    $builder->where('status', '1');
    $builder->orderBy('date_submit', $order);
    $result = $builder->get()->getResultArray();
    return $result;
}

function commentTreeRow($data, $parent=0, $depth=0){
    global $tree;
    for ( $i=0,$ni=count($data); $i<$ni; $i++ )
    {
        if ($data[$i]['ID_comment'] == $parent)
        {
            $data[$i]['depth'] = $depth;
            $tree[] = $data[$i];
            commentTreeRow($data, $data[$i]['ID'], $depth+1);
        }
    }
    return $tree;
}