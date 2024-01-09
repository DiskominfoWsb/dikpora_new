<?php

function unapproveServiceCount($db)
{
    $builder = $db->table('service');
    $builder->selectCount('ID');
    $builder->where('status', '0');
    $result = $builder->get()->getRow();
    return $result->ID;
}