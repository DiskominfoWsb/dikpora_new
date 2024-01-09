<?php

if(!function_exists('array_bulan')) {
    function array_bulan($index = null)
    {
        $bulan = [
            1   => 'Januari',   '01'    => 'Januari',
            2   => 'Februari',  '02'    => 'Februari',
            3   => 'Maret',     '03'    => 'Maret',
            4   => 'April',     '04'    => 'April',
            5   => 'Mei',       '05'    => 'Mei',
            6   => 'Juni',      '06'    => 'Juni',
            7   => 'Juli',      '07'    => 'Juli',
            8   => 'Agustus',   '08'    => 'Agustus',
            9   => 'September', '09'    => 'September',
            10  => 'Oktober',   '10'    => 'Oktober',
            11  => 'November',  '11'    => 'November',
            12  => 'Desember',  '12'    => 'Desember'
        ];
        if($index)
        {
            return $bulan[$index];
        }
        else
        {
            return $bulan;
        }
    }
}

if(!function_exists('array_hari')) {
    function array_hari($index = null)
    {
        $hari = [
            'Sun'   => 'Minggu',    'Sunday'    => 'Minggu',
            'Mon'   => 'Senin',     'Monday'    => 'Senin',
            'Tue'   => 'Selasa',    'Tuesday'   => 'Selasa',
            'Wed'   => 'Rabu',      'Wednesday' => 'Rabu',
            'Thu'   => 'Kamis',     'Thursday'  => 'Kamis',
            'Fri'   => 'Jum\'at',   'Friday'    => 'Jum\'at',
            'Sat'   => 'Sabtu',     'Saturday'  => 'Sabtu',
        ];
        if($index)
        {
            return $hari[$index];
        }
        else
        {
            return $hari;
        }
    }
}

if(!function_exists('indonesian_date')) {
    function indonesian_date($datetime = '2000-01-01 00:00:01', $day = false)
    {
        $time   = strtotime($datetime);
        if($day) $day = array_hari(date('D', $time)).', ';
        $date   = date('d', $time);
        $month  = array_bulan(date('m', $time));
        $year   = date('Y', $time);
        return $day.$date.' '.$month.' '.$year;
    }
}