<?php
   include('cookiemonster.php');

if(checkCookies(2)) {
       include('session.php');
       include('db.php');
       include('inputValidation.php');

       $fag = test_input($_POST['fagManUnderviser']);

       if (!empty($fag)) {
            $conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);
            if (mysqli_connect_error()) {
                die('Connect Error('. mysqli_connect_errno().')'. mysqli_connect_error());
            } else {
                $SELECT = "SELECT fagNavn FROM fag WHERE fagNavn = ? LIMIT 1";
                $INSERT = "INSERT INTO fag (idFag, fagNavn, idBruker) VALUES (?, ?, ?)";

                $stmt = $conn->prepare($SELECT);
                $stmt->bind_param("s",$fag);
                $stmt->execute();
                $stmt->bind_result($fag);
                $stmt->store_result();
                $rnum = $stmt->num_rows;

                $nummer = 0;


                if($rnum == 0) {
                    $nummer = rand(1000, 9999);
                } else {
                    $SELECTDISTINCT = "SELECT idFag FROM fag WHERE fagNavn = ? GROUP BY idFag";
                    $stmtSELECTDISTINCT = $conn->prepare($SELECTDISTINCT);
                    $stmtSELECTDISTINCT->bind_param("s",$fag);
                    $stmtSELECTDISTINCT->execute();
                    $stmtSELECTDISTINCT->bind_result($idFaget);
                    $stmtSELECTDISTINCT->store_result();
                    while($stmtSELECTDISTINCT->fetch()) {
                        $nummer = $idFaget;
                    }
                }

                $stmt->close();
                $SELECTED = "SELECT fagNavn FROM fag WHERE fagNavn = ? AND idFag = ? AND idBruker = ?";
                $stmt = $conn->prepare($SELECTED);
                $stmt->bind_param("sii",$fag,$nummer,$login_id);
                $stmt->execute();
                $stmt->bind_result($fag);
                $stmt->store_result();
                $rnumm = $stmt->num_rows;
                $stmt->close();
                if($rnumm == 0) {
                    $stmt = $conn->prepare($INSERT);
                    $stmt->bind_param("isi", $nummer, $fag, $login_id);
                    $stmt->execute();
                    echo "Fag lagt til";
                    $stmt->close();
                } else {
                    echo "Fag allerede lagt til";
                }
                $conn->close();
                //gå tilbake
            }
       } else {
            echo "Du må fylle ut alle feltene";
            die();
       }
   } else {
       delCookies("emailCookie");
       delCookies("passwordCookie");
       header("Location: ../html/index.php");
   }
?>