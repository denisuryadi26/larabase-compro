<?php

/**
 * @author Dodi Priyanto<dodi.priyanto76@gmail.com>
 */

use App\Models\Menu;

function get_breadcrumbs($url)
{
    $route = collect(\Route::getRoutes())->first(function ($route) use ($url) {
        return $route->matches(request()->create($url));
    });

    if (filled($route)) {
        $route_name = $route->action['as'];
        $menu = Menu::withTrashed()->with('parent')->where('route_name', '=', "$route_name")->first();
        return $menu;
    }
}

function getPagesAccess($current_path)
{
    $group_menu = \Illuminate\Support\Facades\Auth::user()->group()->with('group_menu')->first()->group_menu;
    $data = searchForRouteName($current_path, $group_menu);

    if ($data->is_addable == 1) {


        echo '<button type="button" class="btn btn-primary rounded-pill addModal" data-target="#myModal" data-toggle="modal" style="float: right !important;">
                <i class="tf-icons ti ti-plus"></i>
            ADD</button>';
    } else {
        echo '';
    }
}

function getPagesAccessImport($current_path)
{
    $group_menu = \Illuminate\Support\Facades\Auth::user()->group()->with('group_menu')->first()->group_menu;
    $data = searchForRouteName($current_path, $group_menu);

    if ($data->is_addable == 1) {


        echo '<button type="button" class="btn btn-rounded btn-primary text-bold addModal" data-target="#myModal" data-toggle="modal" style="float: right !important;">
                        <i class="tf-icons ti ti-plus"></i>
                        <span>ADD</span>
                    </button>
                    <br>
                    <br>';
    } else {
        echo '';
    }
}

function getFileName($file)
{
    return basename($file->getClientOriginalName(), '.' . $file->getClientOriginalExtension());
}

function getExtension($file)
{
    return $file->getClientOriginalExtension();
}

function pg2form_date($tgl, $time = false)
{
    $date = date_create($tgl);
    if ($time == true) {
        return date_format($date, "d-m-Y H:i:m");
    }
    return date_format($date, "d-m-Y");
}

function pg2form_word($tgl)
{
    $date = date_create($tgl);
    switch (date_format($date, "n")) {
        case 1:
            $bln = ' Januari ';
            break;
        case 2:
            $bln = ' Februari ';
            break;
        case 3:
            $bln = ' Maret ';
            break;
        case 4:
            $bln = ' April ';
            break;
        case 5:
            $bln = ' Mei ';
            break;
        case 6:
            $bln = ' Juni ';
            break;
        case 7:
            $bln = ' Juli ';
            break;
        case 8:
            $bln = ' Agustus ';
            break;
        case 9:
            $bln = ' Sepetember ';
            break;
        case 10:
            $bln = ' Oktober ';
            break;
        case 11:
            $bln = ' November ';
            break;
        case 12:
            $bln = ' Desember ';
            break;
    }
    return date_format($date, "d") . $bln . date_format($date, "Y");
}

function pg2form_word_with_time($tgl)
{
    $date = date_create($tgl);
    switch (date_format($date, "n")) {
        case 1:
            $bln = ' Januari ';
            break;
        case 2:
            $bln = ' Februari ';
            break;
        case 3:
            $bln = ' Maret ';
            break;
        case 4:
            $bln = ' April ';
            break;
        case 5:
            $bln = ' Mei ';
            break;
        case 6:
            $bln = ' Juni ';
            break;
        case 7:
            $bln = ' Juli ';
            break;
        case 8:
            $bln = ' Agustus ';
            break;
        case 9:
            $bln = ' Sepetember ';
            break;
        case 10:
            $bln = ' Oktober ';
            break;
        case 11:
            $bln = ' November ';
            break;
        case 12:
            $bln = ' Desember ';
            break;
    }
    return date_format($date, "d") . $bln . date_format($date, "Y") . ' ' . date_format($date, 'H:i');
}


function number_to_alphabet($number)
{
    $number = intval($number);
    if ($number <= 0) {
        return '';
    }
    $alphabet = '';
    while ($number != 0) {
        $p = ($number - 1) % 26;
        $number = intval(($number - $p) / 26);
        $alphabet = chr(65 + $p) . $alphabet;
    }
    return $alphabet;
}

function alphabet_to_number($string)
{
    $string = strtoupper($string);
    $length = strlen($string);
    $number = 0;
    $level = 1;
    while ($length >= $level) {
        $char = $string[$length - $level];
        $c = ord($char) - 64;
        $number += $c * (26 ** ($level - 1));
        $level++;
    }
    return $number;
}


function searchForRouteName($id, $array)
{
    foreach ($array as $key => $val) {
        if ($val['route_name'] === $id) {
            return $val->pivot;
        }
    }
    return null;
}


function removeSpace(array $data)
{
    $result = [];
    foreach ($data as $datum => $val) {
        $result[strtolower(str_replace(' ', '', $datum))] = $val;
    }

    return $result;
}

function searchForId($stock, $variant)
{
    $retStock = [];
    foreach ($variant as $key => $val) {
        if ($val->variant_id === $stock->variant_id) {
            return $val->value;
        }
    }

    return null;
}

function generateUnicode($lastCode)
{
    $newCode = (int)str_replace('0', '', $lastCode) + 1;
    $digitLengt = 2;
    $strDigit = 0;

    for ($i = 1; $i <= $digitLengt; $i++) {
        $strDigit .= '0';
    }
    return $strDigit . $newCode;
}
