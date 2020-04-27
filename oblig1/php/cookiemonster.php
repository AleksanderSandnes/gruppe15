<?php
    function setCookies($cookieName, $cookie) {
        setrawcookie($cookieName, $cookie, time() + (24 * 60 * 60), "", "localhost"); // Cookien varer 1 dag
    }

    function getCookies($cookieName) {
        if(isset($_COOKIE["$cookieName"])) {
            return htmlspecialchars($_COOKIE["$cookieName"]);
        }
        return false;
    }

    function delCookies($cookieName) {
        setrawcookie($cookieName, "", time() - (10 * 365 * 24 * 60 * 60));
    }

    function checkCookies($brukerTypeSideNr) {
        include("db.php");
        include("session.php");

        $conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);

        if (mysqli_connect_error()) {
            die('Connect Error('. mysqli_connect_errno().')'. mysqli_connect_error());
        } else {
            $cookieEmailen = getCookies("stonks");
            $cookiePassordet = getCookies("quarantineLife");

            if($login_type == 1) {
                $sqlen = "SELECT brukerNavn, brukerEmail, brukerPassord, salt, saltEmail, brukerType FROM brukeretabell WHERE md5(concat(brukerEmailHash, saltEmail)) = ? AND md5(concat(brukerPassord, salt)) = ?;";
            } else if($login_type == 2) {
                $sqlen = "SELECT brukerNavn, brukerEmail, brukerPassord, salt, saltEmail, brukerType FROM foreleser WHERE md5(concat(brukerEmailHash, saltEmail)) = ? AND md5(concat(brukerPassord, salt)) = ?";
            } else if($login_type == 3) {
                $sqlen = "SELECT brukerNavn, brukerEmail, brukerPassord, salt, saltEmail, brukerType FROM admin WHERE md5(concat(brukerEmailHash, saltEmail)) = ? AND md5(concat(brukerPassord, salt)) = ?";
            }
            $stmtsqlen = $conn->prepare($sqlen);
            $stmtsqlen->bind_param("ss",$cookieEmailen, $cookiePassordet);
            $stmtsqlen->execute();
            $stmtsqlen->bind_result($navnet, $mailen, $passordet, $salt, $saltEmail, $typen);
            $stmtsqlen->store_result();
            $rnumsqlen = $stmtsqlen->num_rows;


            if($rnumsqlen == 1) {
                while($stmtsqlen->fetch()) {
                    $userInfoUsername = $navnet;
                    $userInfoEmail = $mailen;
                    $userInfoPassord = $passordet;
                    $userInfoBrukerType = $typen;
                    $saltet = $salt;
                    $saltetEmail = $saltEmail;
                }
                if($userInfoBrukerType == 3) {
                    if(md5(md5($userInfoUsername).$saltetEmail) == $cookieEmailen && md5($userInfoPassord.$saltet) == $cookiePassordet && $userInfoBrukerType == $brukerTypeSideNr) {
                        return true;
                    } else {
                        return false;
                    }
                } else {
                    if(md5(md5($userInfoEmail).$saltetEmail) == $cookieEmailen && md5($userInfoPassord.$saltet) == $cookiePassordet && $userInfoBrukerType == $brukerTypeSideNr) {
                        return true;
                    } else {
                        return false;
                    }
                }
            } else {
                return true;
            }
        }
    }
?>