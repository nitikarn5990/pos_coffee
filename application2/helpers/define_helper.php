<?php

define("DATE", date('Y-m-d'));

define("DATE_TIME", date('Y-m-d H:i:s'));

define("DATE_TIME_FILE", date('YmdHis'));



function Add_month($condi, $date) {

    //$date = "2016-04";
    $newdate = strtotime($condi . ' month', strtotime($date));
    $newdate = date('Y-m', $newdate);

    return $newdate;
}

function ShowDateThTime($myDate) {
    if ($myDate != "0000-00-00 00:00:00") {
        $myTimeArray = explode(" ", $myDate);
        $myTime = explode(":", $myTimeArray[1]);
        $myDateArray = explode("-", $myDate);
        $myDay = sprintf("%d", $myDateArray[2]);
        switch ($myDateArray[1]) {
            case "01" : $myMonth = "ม.ค.";
                break;
            case "02" : $myMonth = "ก.พ.";
                break;
            case "03" : $myMonth = "มี.ค.";
                break;
            case "04" : $myMonth = "เม.ย.";
                break;
            case "05" : $myMonth = "พ.ค.";
                break;
            case "06" : $myMonth = "มิ.ย.";
                break;
            case "07" : $myMonth = "ก.ค.";
                break;
            case "08" : $myMonth = "ส.ค.";
                break;
            case "09" : $myMonth = "ก.ย.";
                break;
            case "10" : $myMonth = "ต.ค.";
                break;
            case "11" : $myMonth = "พ.ย.";
                break;
            case "12" : $myMonth = "ธ.ค.";
                break;
        }
        $myYear = sprintf("%d", $myDateArray[0]);
        return($myDay . "/" . $myMonth . "/" . $myYear . ", " . $myTime[0] . ":" . $myTime[1]);
    } else {
        return "";
    }
}

function ShowDateTh2($myDate) {
    if ($myDate != "0000-00-00") {
        // $myTimeArray = explode(" ", $myDate);
        // $myTime = explode(":", $myTimeArray[1]);
        $myDateArray = explode("-", $myDate);
        //   $myDay = sprintf("%d", $myDateArray[2]);
        switch ($myDateArray[1]) {
            case "01" : $myMonth = "ม.ค.";
                break;
            case "02" : $myMonth = "ก.พ.";
                break;
            case "03" : $myMonth = "มี.ค.";
                break;
            case "04" : $myMonth = "เม.ย.";
                break;
            case "05" : $myMonth = "พ.ค.";
                break;
            case "06" : $myMonth = "มิ.ย.";
                break;
            case "07" : $myMonth = "ก.ค.";
                break;
            case "08" : $myMonth = "ส.ค.";
                break;
            case "09" : $myMonth = "ก.ย.";
                break;
            case "10" : $myMonth = "ต.ค.";
                break;
            case "11" : $myMonth = "พ.ย.";
                break;
            case "12" : $myMonth = "ธ.ค.";
                break;
        }
        $myYear = sprintf("%d", $myDateArray[0] + 543);
        return($myDateArray[2] . " " . $myMonth . " " . $myYear );
    } else {
        return "";
    }
}

function ShowDateTh($myDate) {
    if ($myDate != "0000-00") {
        // $myTimeArray = explode(" ", $myDate);
        // $myTime = explode(":", $myTimeArray[1]);
        $myDateArray = explode("-", $myDate);
        //   $myDay = sprintf("%d", $myDateArray[2]);
        switch ($myDateArray[1]) {
            case "01" : $myMonth = "ม.ค.";
                break;
            case "02" : $myMonth = "ก.พ.";
                break;
            case "03" : $myMonth = "มี.ค.";
                break;
            case "04" : $myMonth = "เม.ย.";
                break;
            case "05" : $myMonth = "พ.ค.";
                break;
            case "06" : $myMonth = "มิ.ย.";
                break;
            case "07" : $myMonth = "ก.ค.";
                break;
            case "08" : $myMonth = "ส.ค.";
                break;
            case "09" : $myMonth = "ก.ย.";
                break;
            case "10" : $myMonth = "ต.ค.";
                break;
            case "11" : $myMonth = "พ.ย.";
                break;
            case "12" : $myMonth = "ธ.ค.";
                break;
        }
        $myYear = sprintf("%d", $myDateArray[0] + 543);
        return( $myMonth . " " . $myYear );
    } else {
        return "";
    }
}

function encode_login($q) {
    $cryptKey = 'qJB0rGtIn5UB1xG03efyCp';
    $qEncoded = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($cryptKey), $q, MCRYPT_MODE_CBC, md5(md5($cryptKey))));
    return trim($qEncoded);
}

function decode_login($q) {
    $cryptKey = 'qJB0rGtIn5UB1xG03efyCp';
    $qDecoded = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($cryptKey), base64_decode($q), MCRYPT_MODE_CBC, md5(md5($cryptKey))), "\0");
    return( $qDecoded );
}

?>