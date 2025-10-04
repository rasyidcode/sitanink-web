<?php

function convertDate(string $date)
{
    $dateArr = explode('-', $date);
    if ($dateArr[1] == '01') {
        return $dateArr[2] . ' Januari ' . $dateArr[0];
    } else if ($dateArr[1] == '02') {
        return $dateArr[2] . ' Februari ' . $dateArr[0];
    } else if ($dateArr[1] == '03') {
        return $dateArr[2] . ' Maret ' . $dateArr[0];
    } else if ($dateArr[1] == '04') {
        return $dateArr[2] . ' April ' . $dateArr[0];
    } else if ($dateArr[1] == '05') {
        return $dateArr[2] . ' Mei ' . $dateArr[0];
    } else if ($dateArr[1] == '06') {
        return $dateArr[2] . ' Juni ' . $dateArr[0];
    } else if ($dateArr[1] == '07') {
        return $dateArr[2] . ' Juli ' . $dateArr[0];
    } else if ($dateArr[1] == '08') {
        return $dateArr[2] . ' Agustus ' . $dateArr[0];
    } else if ($dateArr[1] == '09') {
        return $dateArr[2] . ' September ' . $dateArr[0];
    } else if ($dateArr[1] == '10') {
        return $dateArr[2] . ' Oktober ' . $dateArr[0];
    } else if ($dateArr[1] == '11') {
        return $dateArr[2] . ' November ' . $dateArr[0];
    } else if ($dateArr[1] == '12') {
        return $dateArr[2] . ' Desember ' . $dateArr[0];
    }
}