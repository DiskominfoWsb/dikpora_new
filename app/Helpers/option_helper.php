<?php

function getOption($name, $db)
{
    $builder = $db->table('option');
    $builder->where('option_name', $name);
    $result = $builder->get()->getRow();
    if($result)
    {
        return $result->option_value;
    }
    else
    {
        return null;
    }
}

function registerOption($name, $value, $db, $status = '1')
{
    $builder = $db->table('option');
    //check existing option
    $builder->where('option_name', $name);
    if($builder->get()->getNumRows() > 0)
    {
        return 0;
    }
    else
    {
        //serialize value if array
        if(is_array($value)) $value = serialize($value);
        $builder->resetQuery();
        $builder->insert([
            'ID'            => null,
            'option_name'   => $name,
            'option_value'  => $value,
            'status'        => $status,
        ]);
        return $db->affectedRows();
    }
}

function updateOption($name, $value, $db, $status = '1')
{
    $builder = $db->table('option');
    $builder->set('option_value', $value);
    $builder->where('option_name', $name);
    $builder->update();
    return $db->affectedRows();
}