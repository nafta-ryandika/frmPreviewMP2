<?php
  $xrdm = date("YmdHis");
?>
<link rel="stylesheet" href="css/table.css?verion=$xrdm">
<style>
  /*#background{
    position:absolute;
    z-index:1;
    background-repeat: no-repeat;
    background-image: url("img/warning.png");
    background-position: center 30px;
    background-size: 70%;
    opacity: 0.4;
    height: 100%;
  }

  #content{
      z-index:0;
  }*/
</style>

<?php
  include("../../connection.php");

  // parameter
  $background_color = "";
  $txt_ket = "";
  $txt_watermark = "";

  if(isset($_POST['innomp'])){
    if ($_POST['innomp']!=''){
      $innomp = $_POST['innomp'];
    }
  }

  if(isset($_POST['instatus'])){
    if ($_POST['instatus']!=''){
      $instatus = $_POST['instatus'];
    }
  }

  if ($instatus == 3 || $instatus == 4) {
    $background_color = 'background-color: #ffa9a8;';
    $txt_ket = "<span style='color:red'>(MP BELUM ISSUED)</span>";
    $txt_watermark = "MP BELUM ISSUED";
  }
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN""http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

  <head>
    <title>Form View</title>
  </head>

  <?php
    $xrdm = date("YmdHis");
    echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"css/style.css?verion=$xrdm\" />";
    echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"css/frmstyle.css?version=$xrdm\" />";
  ?>

  <body>
    <br/>
    <?php
      $sql =  "SELECT * FROM (
                SELECT dt1.mpno, DATE_FORMAT(dt1.dateiss,'%d/%m/%Y') AS dateiss, DATE_FORMAT(dt1.datepor,'%d/%m/%Y') AS datepor, dt1.article, 
                dt1.`last`, dt1.noso, dt1.colour, DATE_FORMAT(dt1.dd,'%d/%m/%Y') AS dd, dt1.tot, dt2.d33, dt2.d33s, dt2.d34, dt2.d34s, dt2.d35, 
                dt2.d35s, dt2.d36, dt2.d36s, dt2.d37, dt2.d37s, dt2.d38, dt2.d38s, dt2.d39, dt2.d39s, dt2.d40, dt2.d40s, dt2.d41, dt2.d41s, dt2.d42, 
                dt2.d42s, dt2.d43, dt2.d43s, dt2.d44, dt1.cust, dt4.rspecial, dt4.rket , 
                -- (select nama from kmcustomer c where c.cust = dt1.cust) as nama, 
                dt4.rrevisi, (select nmbrand from clbrand e where e.kdbrand = dt4.rkdbrand and e.kdcust = dt1.cust) as nmbrand, dt1.ket, dt2.kdassort
                FROM
                (
                  SELECT a.cust, a.ordno, a.mpno, a.dateiss, a.datepor, a.article, a.`last`, a.noso, a.colour, 
                  a.dd, a.tot, a.ket
                  FROM DBKMBS.clmphead a
                  WHERE a.mpno = '".$innomp."'
                )dt1
                LEFT JOIN
                (
                  SELECT b.mpno, kdassort, IF(b.d33 = 0, '',b.d33) as d33, IF(b.d33s = 0, '',b.d33s) as d33s, IF(b.d34 = 0, '',b.d34) as d34, IF(b.d34s = 0, '',b.d34s) as d34s, IF(b.d35 = 0, '',b.d35) as d35, IF(b.d35s = 0, '',b.d35s) as d35s, IF(b.d36 = 0, '',b.d36) as d36, IF(b.d36s = 0, '',b.d36s) as d36s, IF(b.d37 = 0, '',b.d37) as d37, IF(b.d37s = 0, '',b.d37s) as d37s, IF(b.d38 = 0, '',b.d38) as d38, IF(b.d38s = 0, '',b.d38s) as d38s, IF(b.d39 = 0, '',b.d39) as d39, IF(b.d39s = 0, '',b.d39s) as d39s, IF(b.d40 = 0, '',b.d40) as d40, IF(b.d40s = 0, '',b.d40s) as d40s, IF(b.d41 = 0, '',b.d41) as d41, IF(b.d41s = 0, '',b.d41s) as d41s, IF(b.d42 = 0, '',b.d42) as d42, IF(b.d42s = 0, '',b.d42s) as d42s, IF(b.d43 = 0, '',b.d43) as d43, IF(b.d43s = 0, '',b.d43s) as d43s, IF(b.d44 = 0, '',b.d44) as d44, IF(b.d44s = 0, '',b.d44s) as d44s
                  FROM DBKMBS.clmpdet3 b
                  WHERE TRIM(b.mpno) = '".$innomp."'
                )dt2 
                ON dt1.mpno = dt2.mpno
                LEFT JOIN
                (
                  SELECT d.rnomp, d.rspecial, d.rket,d.rrevisi, d.rkdbrand  FROM clemcmp d WHERE d.rnomp = '".$innomp."'
                )dt4
                ON dt1.mpno = dt4.rnomp
                )dt5
              LEFT JOIN
              (SELECT cust, nama, IF(kirim = 1, 'EXPORT', IF(kirim =2, 'LOKAL', 'LOKAL')) AS kirim FROM kmcustomer)dt6
              ON dt5.cust = dt6.cust";
  // echo $sql;

  $result = mysql_query($sql,$conn);
  $count = mysql_num_rows($result);

  if ($count > 0) {
    while ($data = mysql_fetch_array($result)) {
      $customer  = trim($data['nama']);
      $article = trim($data['article']);
      $orderno = trim($data['noso']);
      $last = trim($data['last']);
      $mpno = trim($data['mpno']);
      $cust = trim($data['cust']);
      $colour = trim($data['colour']);
      $dateiss = trim($data['dateiss']);
      $datepor = trim($data['datepor']);
      $dd = trim($data['dd']);
      $total = trim($data['tot']);
      $nmbrand = trim($data['nmbrand']);
      $ref = trim($data['ket']);
      $kirim = trim($data['kirim']);

      $d33 = $data['d33'];
      $d34 = $data['d34'];
      $d35 = $data['d35'];
      $d36 = $data['d36'];
      $d37 = $data['d37'];
      $d38 = $data['d38'];
      $d39 = $data['d39'];
      $d40 = $data['d40'];
      $d41 = $data['d41'];
      $d42 = $data['d42'];
      $d43 = $data['d43'];
      $d44 = $data['d44'];

      $d33s = $data['d33s'];
      $d34s = $data['d34s'];
      $d35s = $data['d35s'];
      $d36s = $data['d36s'];
      $d37s = $data['d37s'];
      $d38s = $data['d38s'];
      $d39s = $data['d39s'];
      $d40s = $data['d40s'];
      $d41s = $data['d41s'];
      $d42s = $data['d42s'];
      $d43s = $data['d43s'];
      // $d44s = $data['d44s'];

      $kdassort = trim($data['kdassort']);

      $rspecial = $data['rspecial'];
      $rket = $data['rket'];

      if ($last == "###") {
        $txt_ket = "<span style='color:red'>(MP BELUM KERJA)</span>";
        $txt_watermark = "MP BELUM KERJA";
        $last = "";
      }
    }
  }
  ?>
    <?php
      if ($instatus == 3 || $instatus == 4) {
      echo "<div id='background' style='height: 100%; width: 100%;'>
              <p id='watermark'>".$txt_watermark."</p>
            </div>";
      }
    ?>
    <div id="content" style="width: 100%">
      <table width="100%" class="table" style="font-size: 14px; <?=$background_color?>">
        <thead>
          <tr>
            <td align="center" colspan="26"><b>PT KARYAMITRA BUDISENTOSA</b></td>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td align="center" colspan="26"><b>MATERIAL PREPARATION <?=$txt_ket?></b></td>
          </tr>
          <tr>
            <td align="" style="text-align: left;" width="15%" colspan="">Customer</td>
            <td align="" width="1%" colspan="">:</td>
            <td align="" style="text-align: left;" width="34%" colspan="10"><?php echo $customer; ?></td>
            <td align="" style="text-align: left;" width="15%" colspan="">Article</td>
            <td align="" width="1%" colspan="">:</td>
            <td align="" style="text-align: left;" width="34%" colspan="10"><?php echo $article; ?></td>
            <td align="" style="text-align: left;" width="34%" rowspan="5">
              <div id="uploaded-picture_1" style="border:4px black inset;width: 120px; height: 120px;">
                <?php
                  if (file_exists("../frm_pembuatan_mp/gambar/".$cust."-".$article.".jpg")) {
                    $url = "../frm_pembuatan_mp/gambar/".$cust."-".$article.".jpg";
                  }
                  else{
                    $url = "img/No_Image_Available.jpg";
                  }
                ?>
                <img src="<?=$url?>" style="width: 120px; height: 120px;">
              </div>
            </td>
          </tr>
          <tr>
              <td align="" style="text-align: left;" width="15%" colspan="">Order No</td>
              <td align="" width="1%" colspan="">:</td>
              <td align="" style="text-align: left;" width="34%" colspan="10"><?php echo $orderno; ?></td>
              <td align="" style="text-align: left;" width="15%" colspan="">Last</td>
              <td align="" width="1%" colspan="">:</td>
              <td align="" style="text-align: left;" width="34%" colspan="10"><?php echo $last; ?></td>
          </tr>
          <tr>
              <td align="" style="text-align: left;" width="15%" colspan="">MP No & Brand</td>
              <td align="" width="1%" colspan="">:</td>
              <td align="" style="text-align: left;" width="34%" colspan="10"><?php echo $mpno; ?> - <?php echo $nmbrand; ?></td>
              <td align="" style="text-align: left;" width="15%" colspan="">Colour</td>
              <td align="" width="1%" colspan="">:</td>
              <td align="" style="text-align: left;" width="34%" colspan="10"><?php echo $colour; ?></td>
          </tr>
          <tr>
              <td align="" style="text-align: left;" width="15%" colspan="">Date Issued</td>
              <td align="" width="1%" colspan="">:</td>
              <td align="" style="text-align: left;" width="34%" colspan="10"><?php echo $dateiss; ?></td>
              <td align="" style="text-align: left;" width="15%" colspan="">No Ref</td>
              <td align="" width="1%" colspan="">:</td>
              <td align="" style="text-align: left;" width="34%" colspan="10"><?php echo $ref; ?></td>
          </tr>
          <tr>
              <td align="" style="text-align: left;" width="15%" colspan="">PO Received</td>
              <td align="" width="1%" colspan="">:</td>
              <td align="" style="text-align: left;" width="34%" colspan="10"><?php echo $datepor; ?></td>
              <td align="" style="text-align: left;" width="15%" colspan="">D / D</td>
              <td align="" width="1%" colspan="">:</td>
              <td align="" style="text-align: left;" width="34%" colspan="10"><?php echo $dd; ?></td>
          </tr>
        </tbody>
      </table>
      <table width="100%" class="table" style="font-size: 14px; <?=$background_color?>">
        <tbody>
          <tr>
            <td align="" width="4%">SIZE</td>
            <?php
            if ($kdassort == 'EA') {
            ?>
              <td align="center" width="4%">33</td>
              <td align="center" width="4%">33.5</td>
              <td align="center" width="4%">34</td>
              <td align="center" width="4%">34.5</td>
              <td align="center" width="4%">35</td>
              <td align="center" width="4%">35.5</td>
              <td align="center" width="4%">36</td>
              <td align="center" width="4%">36.5</td>
              <td align="center" width="4%">37</td>
              <td align="center" width="4%">37.5</td>
              <td align="center" width="4%">38</td>
              <td align="center" width="4%">38.5</td>
              <td align="center" width="4%">39</td>
              <td align="center" width="4%">39.5</td>
              <td align="center" width="4%">40</td>
              <td align="center" width="4%">40.5</td>
              <td align="center" width="4%">41</td>
              <td align="center" width="4%">41.5</td>
              <td align="center" width="4%">42</td>
              <td align="center" width="4%">42.5</td>
              <td align="center" width="4%">43</td>
              <td align="center" width="4%">43.5</td>
              <td align="center" width="4%">44</td>
            <?php
            }
            else if ($kdassort == 'UA') {
            ?>
              <td align="center" width="4%">3</td>
              <td align="center" width="4%">3.5</td>
              <td align="center" width="4%">4</td>
              <td align="center" width="4%">4.5</td>
              <td align="center" width="4%">5</td>
              <td align="center" width="4%">5.5</td>
              <td align="center" width="4%">6</td>
              <td align="center" width="4%">6.5</td>
              <td align="center" width="4%">7</td>
              <td align="center" width="4%">7.5</td>
              <td align="center" width="4%">8</td>
              <td align="center" width="4%">8.5</td>
              <td align="center" width="4%">9</td>
              <td align="center" width="4%">9.5</td>
              <td align="center" width="4%">10</td>
              <td align="center" width="4%">10.5</td>
              <td align="center" width="4%">11</td>
              <td align="center" width="4%">11.5</td>
              <td align="center" width="4%">12</td>
              <td align="center" width="4%">12.5</td>
              <td align="center" width="4%">13</td>
              <td align="center" width="4%">13.5</td>
              <td align="center" width="4%">14</td>
            <?php
            }
            else if ($kdassort == 'JA') {
            ?>
              <td align="center" width="4%">21</td>
              <td align="center" width="4%">21.5</td>
              <td align="center" width="4%">22</td>
              <td align="center" width="4%">22.5</td>
              <td align="center" width="4%">23</td>
              <td align="center" width="4%">23.5</td>
              <td align="center" width="4%">24</td>
              <td align="center" width="4%">24.5</td>
              <td align="center" width="4%">25</td>
              <td align="center" width="4%">25.5</td>
              <td align="center" width="4%">26</td>
              <td align="center" width="4%">26.5</td>
              <td align="center" width="4%">27</td>
              <td align="center" width="4%">27.5</td>
              <td align="center" width="4%">28</td>
              <td align="center" width="4%">28.5</td>
              <td align="center" width="4%">29</td>
              <td align="center" width="4%">29.5</td>
              <td align="center" width="4%">30</td>
              <td align="center" width="4%">30.5</td>
              <td align="center" width="4%">31</td>
              <td align="center" width="4%">31.5</td>
              <td align="center" width="4%">32</td>
            <?php
            }
            ?>
            <td align="center" width="4%">TOTAL</td>
          </tr>
          <tr>
            <td align="" width="4%">QTY</td>
            <td align="center" width="4%"><?php echo $d33 ?></td>
            <td align="center" width="4%"><?php echo $d33s; ?></td>
            <td align="center" width="4%"><?php echo $d34; ?></td>
            <td align="center" width="4%"><?php echo $d34s; ?></td>
            <td align="center" width="4%"><?php echo $d35; ?></td>
            <td align="center" width="4%"><?php echo $d35s; ?></td>
            <td align="center" width="4%"><?php echo $d36; ?></td>
            <td align="center" width="4%"><?php echo $d36s; ?></td>
            <td align="center" width="4%"><?php echo $d37; ?></td>
            <td align="center" width="4%"><?php echo $d37s; ?></td>
            <td align="center" width="4%"><?php echo $d38; ?></td>
            <td align="center" width="4%"><?php echo $d38s; ?></td>
            <td align="center" width="4%"><?php echo $d39; ?></td>
            <td align="center" width="4%"><?php echo $d39s; ?></td>
            <td align="center" width="4%"><?php echo $d40; ?></td>
            <td align="center" width="4%"><?php echo $d40s; ?></td>
            <td align="center" width="4%"><?php echo $d41; ?></td>
            <td align="center" width="4%"><?php echo $d41s; ?></td>
            <td align="center" width="4%"><?php echo $d42; ?></td>
            <td align="center" width="4%"><?php echo $d42s; ?></td>
            <td align="center" width="4%"><?php echo $d43; ?></td>
            <td align="center" width="4%"><?php echo $d43s; ?></td>
            <td align="center" width="4%"><?php echo $d44; ?></td>
            <td align="center" width="4%"><?php echo (float) $total; ?></td>
          </tr>
        </tbody>
      </table>
      <table width="100%" class="table" style="font-size: 14px; <?=$background_color?>">
        <thead>
          <tr>
            <td align="center" width="5%"><b>No</b></td>
            <td align="center" width="15%"><b>Shoe Parts</b></td>
            <td align="center" width="44%"><b>Material Description</b></td>
            <td align="center" width="17%"><b>Supplier</b></td>
            <td align="center" width="7%"><b>Calc</b></td>
            <td align="center" width="7%"><b>Qty</b></td>
            <td align="center" width="5%"><b>Unit</b></td>
          </tr>
        </thead>
        <tbody>
          <tr>
          <?php
          $sql_2 = "SELECT (select b.ket from kmmstpkj b where b.pkj = a.pkj) as ket
                    FROM clmpdet1 a
                    WHERE a.mpno = '".$innomp."'
                    ORDER BY a.nopkj LIMIT 5";
          $result_2 = mysql_query($sql_2,$conn);
          $row_2 = 0;
          // echo($sql_2);
          while($data_2 = mysql_fetch_array($result_2)){
            $row_2++;
          ?>
            <table width="100%" class="table" style="font-size: 14px; background-color: lightgray;">
              <tr>
                <td align="center" width="20%"><b>No MP : <?php echo $innomp; ?></b></td>
                <td align="center" width="20%"><b>Cust : <?php echo $customer; ?></b></td>
                <td align="center" width="20%"><b>Art : <?php echo $article; ?></b></td>
                <td align="center" width="20%"><b>Col : <?php echo $colour; ?></b></td>
                <td align="center" width="20%"><b>Tot. Order : <?php echo (float) $total; ?></b></td>
              </tr>
            </table>
            <table width="100%" class="table" style="font-size: 14px;">
              <tr>
                <td align="center" width="5%"><b><?php echo $row_2; ?></b></td>
                <td align="left" style="text-align: left;" width="95%" colspan="6"><b><?php echo $data_2['ket']; ?></b></td>
              </tr>
            </table>
            <table width="100%" class="table" style="font-size: 14px; <?=$background_color?>">
              <?php

              $sql_3 = "SELECT 
                        a.calc,
                        a.qty,
                        a.nstn,
                        (select b.ket from kmmstsubpkj b where b.subpkj = a.subpkj) as ket,
                        (select c.nmbrg from kmmstbhnbaku c where c.kdbrg = a.materi) as nmbrg,
                        (select d.nmsupp from kmmstsupp d where d.kdsupp = a.sup) as nmsupp
                        FROM clmpdet2 a
                        WHERE a.mpno = '".$innomp."' AND a.nopkj = '".$row_2."'
                        ORDER BY nmbrg";
              $result_3 = mysql_query($sql_3,$conn);
              $count_3 = mysql_num_rows($result_3);
              if ($count_3 > 0) {
                while ($data_3 = mysql_fetch_array($result_3)) {
              ?>
                <tr>
                  <td align="" width="5%" ></td>
                  <td align="" width="15%" style="text-align: left; padding: 3px;"><?php echo strtoupper($data_3["ket"]); ?></td>
                  <td align="" width="40%" style="text-align: left; padding: 3px;"><?php echo utf8_encode($data_3["nmbrg"]); ?></td>
                  <td align="" width="21%" style="text-align: left; padding: 3px;"><?php echo $data_3["nmsupp"]; ?></td>
                  <td align="" width="7%" style="text-align: right;"><?php echo (float) $data_3["calc"]; ?></td>
                  <td align="" width="7%" style="text-align: right;"><?php echo (float) $data_3["qty"]; ?></td>
                  <td align="" width="5%" ><?php echo $data_3["nstn"]; ?></td>
                </tr>
              <?php
                }
              }
              else{
              ?>
                <tr>
                  <td colspan="6">&nbsp;</td>
                </tr>
              <?php
              }
              ?>
            </table>   
            <?php
            }
            ?>
          </tr>
        </tbody>
      </table>
      <table width="100%" class="table" style="text-align: left; font-size: 14px; <?=$background_color?>">
        <tr>
          <td width="30%"><b><u>Special Instruction</u></b></td>
          <td width="70%" style="text-align: left;"><?php echo nl2br(utf8_encode($rspecial)); ?></td>
        </tr>
        <tr>
          <td width="30%"><b><u>Keterangan</u></b></td>
          <td width="70%" style="text-align: left;"><?php echo nl2br($rket); ?></td>
        </tr>
      </table>
    </div>
  </body>

</html>
<?php
  mysql_close($conn);
?>
