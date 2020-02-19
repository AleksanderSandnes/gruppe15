<?php
    function setCookies($cookieName, $cookie) {
        setrawcookie($cookieName, $cookie, time() + (10 * 365 * 24 * 60 * 60));
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
            $cookieEmailen = getCookies("emailCookie");
            $cookiePassordet = getCookies("passwordCookie");

            if($login_type == 1) {
                $sqlen = "SELECT brukerNavn, brukerEmail, brukerPassord, brukerType FROM brukeretabell WHERE brukerEmailHash = ? AND brukerPassord = ?;";
            } else if($login_type == 2) {
                $sqlen = "SELECT brukerNavn, brukerEmail, brukerPassord, brukerType FROM foreleser WHERE brukerEmailHash = ? AND brukerPassord = ?";
            } else if($login_type == 3) {
                $sqlen = "SELECT brukerNavn, brukerEmail, brukerPassord, brukerType FROM admin WHERE brukerEmailHash = ? AND brukerPassord = ?";
            }
            $stmtsqlen = $conn->prepare($sqlen);
            $stmtsqlen->bind_param("ss",$cookieEmailen, $cookiePassordet);
            $stmtsqlen->execute();
            $stmtsqlen->bind_result($navnet, $mailen, $passordet, $typen);
            $stmtsqlen->store_result();
            $rnumsqlen = $stmtsqlen->num_rows;

            if($rnumsqlen == 1) {
                while($stmtsqlen->fetch()) {
                    $userInfoUsername = $navnet;
                    $userInfoEmail = $mailen;
                    $userInfoPassord = $passordet;
                    $userInfoBrukerType = $typen;
                }
                if($userInfoBrukerType == 3) {
                    if(md5($userInfoUsername) == $cookieEmailen && $userInfoPassord == $cookiePassordet && $userInfoBrukerType == $brukerTypeSideNr) {
                        return true;
                    } else {
                        return false;
                    }
                } else {
                    if(md5($userInfoEmail) == $cookieEmailen && $userInfoPassord == $cookiePassordet && $userInfoBrukerType == $brukerTypeSideNr) {
                        return true;
                    } else {
                        return false;
                    }
                }
            } else {
                return false;
            }
        }
    }
?>