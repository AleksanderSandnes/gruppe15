<?php
   include('session.php');
   include('db.php');

   $fag = $_POST['fagManUnderviser'];

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
                $SELECTDISTINCT = "SELECT DISTINCT * FROM fag WHERE fagNavn = '$fag'";
                $result = mysqli_query($conn, $SELECTDISTINCT);
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                $nummer = $row['idFag'];
            }

            $stmt->close();
            $SELECTED = "SELECT fagNavn FROM fag WHERE fagNavn = ? AND idFag = $nummer AND idBruker = $login_id";
            $stmt = $conn->prepare($SELECTED);
            $stmt->bind_param("s",$fag);
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
?>