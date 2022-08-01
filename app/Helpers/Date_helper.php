<?php
setlocale(LC_ALL, 'id-ID', 'id_ID');

function myDate($date)
{
    return $date ? date("d-m-Y", strtotime($date)) : false;
}

function dateTime($date)
{
    return $date ? date("d-m-Y H:i", strtotime($date)) : false;
}

function dayID($date)
{
    return $date ? strftime("%A", strtotime($date)) : false;
}

function dateID($date)
{
    return $date ? strftime("%A, %d %B %Y", strtotime($date)) : false;
}

function dateTimeID($date)
{
    return $date ? strftime("%A, %d %B %Y %H:%M", strtotime($date)) : false;
}

function namaBulan($bulan)
{
    return match ($bulan) {
        1   => "Januari",
        2   => "Februari",
        3   => "Maret",
        4   => "April",
        5   => "Mei",
        6   => "Juni",
        7   => "Juli",
        8   => "Agustus",
        9   => "September",
        10  => "Oktober",
        11  => "November",
        12  => "Desember",
        default => "Not Valid"
    };
}
