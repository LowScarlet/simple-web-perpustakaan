<?php
function serial_abstrak($string) {
    $limit = 150;
    if (!(strlen($string) > 0) or ($string == null)) {
        return "Buku ini belum memiliki Abstrak!";
    }
    if (strlen($string) > $limit) {
        $stringCut = substr($string, 0, $limit);
        $endPoint = strrpos($stringCut, ' ');

        $string = $endPoint? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
        $string .= '...';
    }
    return $string;
}
function serial_book_title($string) {
    $limit = 50;
    if (!(strlen($string) > 0) or ($string == null)) {
        return "Buku ini tidak memiliki judul!";
    }
    if (strlen($string) > $limit) {
        $stringCut = substr($string, 0, $limit);
        $endPoint = strrpos($stringCut, ' ');

        $string = $endPoint? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
        $string .= '...';
    }
    return $string;
}

function user_displayname($a, $b) {
    if ($a and $b) {
        return "$a $b";
    }
    return "Unknown User";
}

function paging($no, $search, $key) {
    if (isset($search) and isset($key)) {
        return "?page=$no&search=$search&key=$key#main";
    }
    return "?page=$no#main";
}

function user_is_admin($perms) {
    if ($perms >= 3) {
        return true;
    }
    return false;
}