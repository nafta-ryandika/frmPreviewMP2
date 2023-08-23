<?php

include("../../configuration.php");
include("../../connection.php");
include("../../endec.php");

//Class For Pdf
require('../../mpdf/mpdf.php');

//Cek Get Data
if(isset($_POST['indata'])){
  $mpno = $_POST['indata'];
  $txtSQL =  "SELECT dt1.mpno, DATE_FORMAT(dt1.dateiss,'%d/%m/%Y') AS dateiss, DATE_FORMAT(dt1.datepor,'%d/%m/%Y') AS datepor, dt1.article, 
          dt1.`last`, dt1.noso, dt1.colour, DATE_FORMAT(dt1.dd,'%d/%m/%Y') AS dd, dt1.tot, dt2.d33, dt2.d33s, dt2.d34, dt2.d34s, dt2.d35, 
          dt2.d35s, dt2.d36, dt2.d36s, dt2.d37, dt2.d37s, dt2.d38, dt2.d38s, dt2.d39, dt2.d39s, dt2.d40, dt2.d40s, dt2.d41, dt2.d41s, dt2.d42, 
          dt2.d42s, dt2.d43, dt2.d43s, dt2.d44, dt1.cust, dt4.rspecial, dt4.rket , (select nama from kmcustomer c where c.cust = dt1.cust) as nama, 
          dt4.rrevisi, (select nmbrand from clbrand e where e.kdbrand = dt4.rkdbrand and e.kdcust = dt1.cust) as nmbrand, dt1.ket, dt2.kdassort
          FROM
          (
            SELECT a.cust, a.ordno, a.mpno, a.dateiss, a.datepor, a.article, a.`last`, a.noso, a.colour, 
            a.dd, a.tot, a.ket
            FROM DBKMBS.clmphead a
            WHERE a.mpno = '".$mpno."'
          )dt1
          LEFT JOIN
          (
            SELECT b.mpno, kdassort, IF(b.d33 = 0, '',b.d33) as d33, IF(b.d33s = 0, '',b.d33s) as d33s, IF(b.d34 = 0, '',b.d34) as d34, IF(b.d34s = 0, '',b.d34s) as d34s, IF(b.d35 = 0, '',b.d35) as d35, IF(b.d35s = 0, '',b.d35s) as d35s, IF(b.d36 = 0, '',b.d36) as d36, IF(b.d36s = 0, '',b.d36s) as d36s, IF(b.d37 = 0, '',b.d37) as d37, IF(b.d37s = 0, '',b.d37s) as d37s, IF(b.d38 = 0, '',b.d38) as d38, IF(b.d38s = 0, '',b.d38s) as d38s, IF(b.d39 = 0, '',b.d39) as d39, IF(b.d39s = 0, '',b.d39s) as d39s, IF(b.d40 = 0, '',b.d40) as d40, IF(b.d40s = 0, '',b.d40s) as d40s, IF(b.d41 = 0, '',b.d41) as d41, IF(b.d41s = 0, '',b.d41s) as d41s, IF(b.d42 = 0, '',b.d42) as d42, IF(b.d42s = 0, '',b.d42s) as d42s, IF(b.d43 = 0, '',b.d43) as d43, IF(b.d43s = 0, '',b.d43s) as d43s, IF(b.d44 = 0, '',b.d44) as d44, IF(b.d44s = 0, '',b.d44s) as d44s
            FROM DBKMBS.clmpdet3 b
            WHERE TRIM(b.mpno) = '".$mpno."'
          )dt2 
          ON dt1.mpno = dt2.mpno
          LEFT JOIN
          (
            SELECT d.rnomp, d.rspecial, d.rket,d.rrevisi, d.rkdbrand  FROM clemcmp d WHERE d.rnomp = '".$mpno."'
          )dt4
          ON dt1.mpno = dt4.rnomp";
}else{
  $txtSQL = "";
}

if(isset($_POST['instatus'])){
  if ($_POST['instatus']!=''){
    $instatus = $_POST['instatus'];
  }
}

// parameter
$background_color = "";
$txt_ket = "";
$txt_watermark = "";

if ($instatus == 3 || $instatus == 4) {
  $background_color = 'background-color: #ffa9a8;';
  $txt_ket = "<span style='color:red'>(MP BELUM ISSUED)</span>";
  $txt_watermark = "MP BELUM ISSUED";
}

$xname = $_SESSION[$domainApp."_myname"];
$xgroup = $_SESSION[$domainApp."_mygroup"];
date_default_timezone_set("Asia/Bangkok");
$today = date("d/m/Y H:i:s");

$result = mysql_query($txtSQL,$conn);
while ($data = mysql_fetch_array($result)){
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
  $rrevisi  = $data['rrevisi'];

  if (file_exists('../frm_pembuatan_mp/gambar/'.$cust.'-'.$article.'.jpg')) {
    $url = '../frm_pembuatan_mp/gambar/'.$cust.'-'.$article.'.jpg';
  }
  else{
    $url = 'img/No_Image_Available.jpg';
  }

  if ($last == "###") {
    $txt_ket = "<span style='color:red'>(MP BELUM KERJA)</span>";
    $txt_watermark = "MP BELUM KERJA";
    $last = "";
  }
}

$header .= "
          <table width='100%'>
            <tr>
              <td style='text-align:center;' colspan='3'>
              <b>PT KARYAMITRA BUDISENTOSA</b>
              </td>
            </tr>
            <tr>
              <td style='text-align:left;' width='25%'>Revisi : ".$rrevisi."</td>
              <td style='text-align:center;' width='50%'><b>MATERIAL PREPARATION ".$txt_ket."</b><td/>
              <td style='text-align:right;' width='25%'>Page : {PAGENO}/{nb}</td>
            <tr/>
          </table>
          <table width='100%' class='table' style='".$background_color."'>
            <tbody>
              <tr>
                <td align='' style='text-align: left;' width='15%' colspan=''>Customer</td>
                <td align='' width='1%' colspan=''>:</td>
                <td align='' style='text-align: left;' width='24%' colspan='10'>".$customer."</td>
                <td align='' style='text-align: left;' width='15%' colspan=''>Article</td>
                <td align='' width='1%' colspan=''>:</td>
                <td align='' style='text-align: left;' width='24%' colspan='10'>".$article."</td>
                <td align='center' style='text-align: center;' width='20%' rowspan='5' colspan='2'>
                    <img src='".$url."' style='width: 90px; height: 90px;'>
                </td>
              </tr>
              <tr>
                  <td align='' style='text-align: left;' width='15%' colspan=''>Order No</td>
                  <td align='' width='1%' colspan=''>:</td>
                  <td align='' style='text-align: left;' width='24%' colspan='10'>".$orderno."</td>
                  <td align='' style='text-align: left;' width='15%' colspan=''>Last</td>
                  <td align='' width='1%' colspan=''>:</td>
                  <td align='' style='text-align: left;' width='24%' colspan='10'>".$last."</td>
              </tr>
              <tr>
                  <td align='' style='text-align: left;' width='15%' colspan=''>MP No & Brand</td>
                  <td align='' width='1%' colspan=''>:</td>
                  <td align='' style='text-align: left;' width='24%' colspan='10'>".$mpno." - ".$nmbrand."</td>
                  <td align='' style='text-align: left;' width='15%' colspan=''>Colour</td>
                  <td align='' width='1%' colspan=''>:</td>
                  <td align='' style='text-align: left;' width='24%' colspan='10'>".$colour."</td>
              </tr>
              <tr>
                  <td align='' style='text-align: left;' width='15%' colspan=''>Date Issued</td>
                  <td align='' width='1%' colspan=''>:</td>
                  <td align='' style='text-align: left;' width='24%' colspan='10'>".$dateiss."</td>
                  <td align='' style='text-align: left;' width='15%' colspan=''>No Ref</td>
                  <td align='' width='1%' colspan=''>:</td>
                  <td align='' style='text-align: left;' width='24%' colspan='10'>".$ref."</td>
              </tr>
              <tr>
                  <td align='' style='text-align: left;' width='15%' colspan=''>PO Received</td>
                  <td align='' width='1%' colspan=''>:</td>
                  <td align='' style='text-align: left;' width='24%' colspan='10'>".$datepor."</td>
                  <td align='' style='text-align: left;' width='15%' colspan=''>D / D</td>
                  <td align='' width='1%' colspan=''>:</td>
                  <td align='' style='text-align: left;' width='24%' colspan='10'>".$dd."</td>
              </tr>
            </tbody>
          </table>
          <table width='100%' class='table'>
              <tr bgcolor='lightgray'>
                <td align='' width='3%'>SIZE</td>
                ";


                  if ($kdassort == 'EA') {
                    $header .=  "
                                <td align='center' width='3%'>33</td>
                                <td align='center' width='3%'>33.5</td>
                                <td align='center' width='3%'>34</td>
                                <td align='center' width='3%'>34.5</td>
                                <td align='center' width='3%'>35</td>
                                <td align='center' width='3%'>35.5</td>
                                <td align='center' width='3%'>36</td>
                                <td align='center' width='3%'>36.5</td>
                                <td align='center' width='3%'>37</td>
                                <td align='center' width='3%'>37.5</td>
                                <td align='center' width='3%'>38</td>
                                <td align='center' width='3%'>38.5</td>
                                <td align='center' width='3%'>39</td>
                                <td align='center' width='3%'>39.5</td>
                                <td align='center' width='3%'>40</td>
                                <td align='center' width='3%'>40.5</td>
                                <td align='center' width='3%'>41</td>
                                <td align='center' width='3%'>41.5</td>
                                <td align='center' width='3%'>42</td>
                                <td align='center' width='3%'>42.5</td>
                                <td align='center' width='3%'>43</td>
                                <td align='center' width='3%'>43.5</td>
                                <td align='center' width='3%'>44</td>
                                ";
                  }
                  else if ($kdassort == 'UA') {
                    $header .=  "
                                <td align='center' width='4%'>3</td>
                                <td align='center' width='4%'>3.5</td>
                                <td align='center' width='4%'>4</td>
                                <td align='center' width='4%'>4.5</td>
                                <td align='center' width='4%'>5</td>
                                <td align='center' width='4%'>5.5</td>
                                <td align='center' width='4%'>6</td>
                                <td align='center' width='4%'>6.5</td>
                                <td align='center' width='4%'>7</td>
                                <td align='center' width='4%'>7.5</td>
                                <td align='center' width='4%'>8</td>
                                <td align='center' width='4%'>8.5</td>
                                <td align='center' width='4%'>9</td>
                                <td align='center' width='4%'>9.5</td>
                                <td align='center' width='4%'>10</td>
                                <td align='center' width='4%'>10.5</td>
                                <td align='center' width='4%'>11</td>
                                <td align='center' width='4%'>11.5</td>
                                <td align='center' width='4%'>12</td>
                                <td align='center' width='4%'>12.5</td>
                                <td align='center' width='4%'>13</td>
                                <td align='center' width='4%'>13.5</td>
                                <td align='center' width='4%'>14</td>
                                ";
                  }else if ($kdassort == 'JA') {
                    $header .=  "
                                <td align='center' width='4%'>21</td>
                                <td align='center' width='4%'>21.5</td>
                                <td align='center' width='4%'>22</td>
                                <td align='center' width='4%'>22.5</td>
                                <td align='center' width='4%'>23</td>
                                <td align='center' width='4%'>23.5</td>
                                <td align='center' width='4%'>24</td>
                                <td align='center' width='4%'>24.5</td>
                                <td align='center' width='4%'>25</td>
                                <td align='center' width='4%'>25.5</td>
                                <td align='center' width='4%'>26</td>
                                <td align='center' width='4%'>26.5</td>
                                <td align='center' width='4%'>27</td>
                                <td align='center' width='4%'>27.5</td>
                                <td align='center' width='4%'>28</td>
                                <td align='center' width='4%'>28.5</td>
                                <td align='center' width='4%'>29</td>
                                <td align='center' width='4%'>29.5</td>
                                <td align='center' width='4%'>30</td>
                                <td align='center' width='4%'>30.5</td>
                                <td align='center' width='4%'>31</td>
                                <td align='center' width='4%'>31.5</td>
                                <td align='center' width='4%'>32</td>
                                ";
                  }

$header .=      "
                <td align='center' width='3%'>TOTAL</td>
              </tr>
              <tr style='".$background_color."'>
                <td align='' width='3%'>QTY</td>
                <td align='center' width='3%'>".$d33."</td>
                <td align='center' width='3%'>".$d33s."</td>
                <td align='center' width='3%'>".$d34."</td>
                <td align='center' width='3%'>".$d34s."</td>
                <td align='center' width='3%'>".$d35."</td>
                <td align='center' width='3%'>".$d35s."</td>
                <td align='center' width='3%'>".$d36."</td>
                <td align='center' width='3%'>".$d36s."</td>
                <td align='center' width='3%'>".$d37."</td>
                <td align='center' width='3%'>".$d37s."</td>
                <td align='center' width='3%'>".$d38."</td>
                <td align='center' width='3%'>".$d38s."</td>
                <td align='center' width='3%'>".$d39."</td>
                <td align='center' width='3%'>".$d39s."</td>
                <td align='center' width='3%'>".$d40."</td>
                <td align='center' width='3%'>".$d40s."</td>
                <td align='center' width='3%'>".$d41."</td>
                <td align='center' width='3%'>".$d41s."</td>
                <td align='center' width='3%'>".$d42."</td>
                <td align='center' width='3%'>".$d42s."</td>
                <td align='center' width='3%'>".$d43."</td>
                <td align='center' width='3%'>".$d43s."</td>
                <td align='center' width='3%'>".$d44."</td>
                <td align='center' width='3%'>".(float) $total."</td>
              </tr>
          </table>
          <table width='100%' class='table' autosize='1' border='1' width='100%' style='overflow: wrap'>
            <thead>
              <tr bgcolor='lightgray'>
                <td align='center' width='2.5%'><b>No</b></td>
                <td align='center' width='17.5%'><b>Shoe Parts</b></td>
                <td align='center' width='42%'><b>Material Description</b></td>
                <td align='center' width='21%'><b>Supplier</b></td>
                <td align='center' width='6%'><b>Calc</b></td>
                <td align='center' width='6%'><b>Qty</b></td>
                <td align='center' width='5%'><b>Unit</b></td>
              </tr>
            </thead>
          </table>
          ";

$sql_2 = "SELECT (select b.ket from kmmstpkj b where b.pkj = a.pkj) as ket
          FROM clmpdet1 a
          WHERE a.mpno = '".$mpno."'
          ORDER BY a.nopkj LIMIT 5";
$result_2 = mysql_query($sql_2,$conn);
$row_2 = 0;

while($data_2 = mysql_fetch_array($result_2)){
  $row_2++;

$content .=  "
            <table width='100%' class='table' autosize='1' border='1' width='100%' style='overflow: wrap'>
              <tr bgcolor='lightgray'>
                <td align='center' width='20%'><b>No MP : ".$mpno."</b></td>
                <td align='center' width='20%'><b>Cust : ".$customer."</b></td>
                <td align='center' width='20%'><b>Art : ".$article."</b></td>
                <td align='center' width='20%'><b>Col : ".$colour."</b></td>
                <td align='center' width='20%'><b>Tot. Order : ".(float) $total."</b></td>
              </tr>
            </table>
            <table width='100%' class='table' autosize='1' border='1' width='100%' style='overflow: wrap'>
              <tr>
                <td align='center' width='2.5%'><b>".$row_2."</b></td>
                <td align='left' style='text-align: left;' width='97.5%' colspan='6'><b>".$data_2['ket']."</b></td>
              </tr>
            </table>
            <table width='100%' class='table' autosize='1' border='1' width='100%' style='overflow: wrap'>
          ";

  $sql_3 = "SELECT 
            a.calc,
            a.qty,
            a.nstn,
            (select b.ket from kmmstsubpkj b where b.subpkj = a.subpkj) as ket,
            (select c.nmbrg from kmmstbhnbaku c where c.kdbrg = a.materi) as nmbrg,
            (select d.nmsupp from kmmstsupp d where d.kdsupp = a.sup) as nmsupp
            FROM clmpdet2 a
            WHERE a.mpno = '".$mpno."' AND a.nopkj = '".$row_2."'
            ORDER BY nmbrg";
  $result_3 = mysql_query($sql_3,$conn);
  $count_3 = mysql_num_rows($result_3);
  if ($count_3 > 0) {
    while ($data_3 = mysql_fetch_array($result_3)) {
      $nmsupp = $data_3['nmsupp'];
      $count_str_3 = strlen($nmsupp);
      
      if ($count_str_3 > 28) {
        $nmsupp = substr($data_3['nmsupp'], 0, 27);
      }

      $content .= "
                  <tr style='".$background_color."'>
                    <td align='' width='2.5%' ></td>
                    <td align='' width='17.5%' style='text-align: left;'>".strtoupper($data_3['ket'])."</td>
                    <td align='' width='42%' style='text-align: left;'>".utf8_encode($data_3['nmbrg'])."</td>
                    <td align='' width='21%' style='text-align: left;'>".$nmsupp."</td>
                    <td align='right' width='6%' >".(float) $data_3['calc']."</td>
                    <td align='right' width='6%' >".(float) $data_3['qty']."</td>
                    <td align='' width='5%' >".$data_3['nstn']."</td>
                  </tr>
                  ";
    }
  }
  else{
    $content .= "
                <tr>
                  <td colspan='6'>&nbsp;</td>
                </tr>
                ";
  }
  
  $content .= "</table>";   
}




$content .= "
            <table width='100%' class='table' style='text-align: left; ".$background_color."'>
              <tr valign='top'>
                <td width='15%'><b>Special Instruction</b></td>
                <td width='85%' style='text-align: left;' colspan='' valign='top'>".nl2br(utf8_encode($rspecial))."</td>
              </tr>
              <tr>
                <td width='15%'><b>Keterangan</b></td>
                <td width='85%' style='text-align: left;' rowspan='' valign='top'>".nl2br($rket)."</td>
              </tr>
            </table>
            <br/>
            ";

            // <table width='30%' class='table' style='text-align: left;' align='right'>
            //  <tr>
            //     <td width='15%'><b>Prepared By</b></td>
            //     <td width='15%'><b>Approved By</b></td>
            //   </tr>
            //   <tr>
            //     <td width='15%' ><br/><br/><br/><br/><br/><br/></td>
            //     <td width='15%'></td>
            //   </tr>
            //   <tr>
            //     <td width='15%'>".$_SESSION[$domainApp."_myname"]."</td>
            //     <td width='15%'>Winarni</td>
            //   </tr>
            // </table>

$footer = "Printed : ".$_SESSION[$domainApp."_myname"]." ".$today."";

//$mpdf=new mPDF('1mode','2format kertas','3font size','4font','5margin left','6margin right','7margin top','8margin bottom','9margin header','10margin footer','11orientasi kertas');
// $mpdf=new mPDF('','A4','7','Arial','5','5','49','10','5','5');
$mpdf=new mPDF('','A4','8','Arial','5','5','51.5','10','5','5');
$mpdf->simpleTables = true;
$mpdf->packTableData = true;
$keep_table_proportions = TRUE;
$mpdf->shrink_tables_to_fit=1;
$mpdf->SetHTMLHeader($header);
$mpdf->SetHTMLFooter($footer);
$stylesheet = file_get_contents('css/table.css');

// $mpdf->SetWatermarkImage(
//     'img/warning.png',
//     1,
//     '',
//     array(160,10)
// );
// $mpdf->showWatermarkImage = true;

if ($instatus == 3 || $instatus == 4) {
  $mpdf->SetWatermarkText($txt_watermark);
  $mpdf->showWatermarkText = true;
}

$mpdf->WriteHTML($stylesheet,1);

$mpdf->WriteHTML($content);
 
//save the file put which location you need folder/filname
$mpdf->Output("MP-".$mpno.".pdf", 'I');
 
 
//out put in browser below output function
$mpdf->Output();

?>
