<?php
  include("../../configuration.php");
  include("../../connection.php");

  // parameter
  $mygroup = $_SESSION[$domainApp."_mygroup"];
  $myxdept = $_SESSION[$domainApp."_myxdept"];
  $status_user = 0;
  if ($mygroup == 'MP') {
    $status_user = 1;
  }
  else if ($myxdept == 'ADM' || $myxdept == 'EDPST') {
    $status_user = 1;
  }

  if(isset($_POST['intxtmode'])){
    $intxtmode = $_POST['intxtmode'];
  }
  if(isset($_POST['innomp'])){
    $innomp = trim(strtoupper(htmlspecialchars($_POST['innomp'])));
  }

  if($intxtmode=='check_mp'){
    $sql = "SELECT mpno,
            IF(dateiss IS NULL, 0, 1) AS status_issued,
            (SELECT COUNT(lgnomp) FROM clloguser a WHERE a.lgnomp = '".$innomp."' AND TRIM(lgket) = 'BATAL ISSUED MP' LIMIT 1) AS status_log, 
            (SELECT COUNT(nomp) FROM rpprgrsh a WHERE a.nomp = '".$innomp."') status_launching
            FROM clmphead WHERE mpno = '".$innomp."'";
    $res = mysql_query($sql,$conn);
    $row = mysql_num_rows($res);

    // 0 data tidak ditemukan
    // 1 alert mp belum di issued
    // 2 show mp
    // 3 mp belum issued ada log batal issued

    if ($row > 0) {
      while ($data = mysql_fetch_array($res)) {
        $status_issued = $data["status_issued"];
        $status_log = $data["status_log"];
        $status_launching = $data["status_launching"];

        if ($status_issued == 0 && $status_user == 0 && $status_log == 0) {
          echo(1);
        }
        else if ($status_issued == 0 && $status_user == 0 && $status_log > 0) {
          echo(3);
        }
        elseif ($status_user == 0 && $status_launching > 0) {
          echo(4);
        }
        else {
          echo(2);
        }
      }
    }
    else{
      echo 0;
    }
  }

  // close connection !!!!
  mysql_close($conn)
?>