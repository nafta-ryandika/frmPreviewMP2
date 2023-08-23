<?php
require_once '../../PHPExcel/PHPExcel.php';
include("../../configuration.php");
include("../../connection.php");
include("../../endec.php");


//Cek Get Data
if(isset($_POST['nmSQL'])){
  $txtSQL = $_POST['nmSQL'];
}else{
  $txtSQL = "";
}

$xname = $_SESSION[$domainApp."_myname"];
$xgroup = $_SESSION[$domainApp."_mygroup"];

// Get data records from table.
$result=mysql_query($txtSQL);

$excel = new PHPExcel();

$excel->getProperties()->setCreator('PT Karyamitra Budisentosa')
             ->setLastModifiedBy($xname)
             ->setTitle("Master Shoes")
             ->setSubject("Master Shoes")
             ->setDescription("Laporan Master Shoes")
             ->setKeywords("Master Shoes");

// STYLE HEADER
$style_col = array(
  'font' => array('bold' => true),
  'alignment' => array(
    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
  ),
  'borders' => array(
    'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
    'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
    'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
    'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN)
  )
);

// STYLE ROW TABEL
$style_row = array(
  'alignment' => array(
    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
  ),
  'borders' => array(
    'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
    'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
    'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),
    'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN)
  )
);

// STYLE ROW BOTTOM BORDER
$style_borderBottom = array(
  'borders' => array(
    'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN)
  )
);

// STYLE ROW RIGHT BORDER
$style_borderRight = array(
  'borders' => array(
    'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN)
  )
);

//STYLE ROW ALIGN CENTER VERTICALLY
$style_rowCenterVertically = array(
  'alignment' => array(
    'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
  )
);

//STYLE ROW ALIGN TOP VERTICALLY
$style_rowTopVertically = array(
  'alignment' => array(
    'top' => PHPExcel_Style_Alignment::VERTICAL_TOP
  )
);

//STYLE ROW TEXT ALIGN LEFT HORIZONTALLY
$style_rowLeftHorizontally = array(
  'alignment' => array(
    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT
  ),
  'borders' => array(
    'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN)
  )
);

// STYLE ROW COLOR PURPLE
$style_rowColor = array(
	'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'color' => array('rgb'=>'E1E0F7'),
    ),
);

$style_rowColorGrey = array(
	'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'color' => array('rgb'=>'DCDADA'),
    ),
);

$excel->getActiveSheet()->getRowDimension('1')->setRowHeight(25);
$excel->getActiveSheet()->mergeCells('A1:C1');
// ADD GAMBAR
$objDrawing = new PHPExcel_Worksheet_Drawing();
// $objDrawing->setName('Logo');
// $objDrawing->setDescription('Logo');
$objDrawing->setPath('img/logokmbs.jpg');
$objDrawing->setCoordinates('A1');
$objDrawing->setHeight(50);
$objDrawing->setWidth(50);
$objDrawing->setWorksheet($excel->getActiveSheet());

$excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE);
$excel->setActiveSheetIndex(0)->setCellValue('A1', "                    PT KARYAMITRA BUDISENTOSA");
$excel->getActiveSheet()->getStyle('A1')->applyFromArray($style_rowCenterVertically);

// $excel->setActiveSheetIndex(0)->setCellValue('A2',$txtSQL);

$excel->setActiveSheetIndex(0)->setCellValue('A3', "LAPORAN MASTER SHOES");
$excel->getActiveSheet()->mergeCells('A3:C3');
$excel->getActiveSheet()->getStyle('A3')->getFont()->setBold(TRUE);
$excel->getActiveSheet()->getStyle('A3')->getFont()->setSize(12);

// SET HEIGHT ROW
$excel->getActiveSheet()->getRowDimension('3')->setRowHeight(20);
$excel->getActiveSheet()->getRowDimension('4')->setRowHeight(20);

$excel->getActiveSheet()->getStyle('A4')->applyFromArray($style_row);
$excel->getActiveSheet()->getStyle('B4:D4')->applyFromArray($style_row);
$excel->getActiveSheet()->getStyle('E4:G4')->applyFromArray($style_row);

$excel->getActiveSheet()->getStyle('A4:C4')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$excel->setActiveSheetIndex(0)->setCellValue('A4', "No");
$excel->setActiveSheetIndex(0)->setCellValue('B4', "Gambar");
$excel->setActiveSheetIndex(0)->setCellValue('E4', "Keterangan");
$excel->getActiveSheet()->mergeCells('B4:D4');
$excel->getActiveSheet()->mergeCells('E4:G4');

$excel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
$excel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
$excel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
$excel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
$excel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
$excel->getActiveSheet()->getColumnDimension('F')->setWidth(1);
$excel->getActiveSheet()->getColumnDimension('G')->setWidth(55);

$excel->getActiveSheet()->getStyle('A4:E4')->applyFromArray($style_rowColorGrey);


$numrow = 5;
$no = 1;
$numrowKeterangan = 5;

while($data = mysql_fetch_array($result)){
  // $excel->getActiveSheet()->getRowDimension($numrow)->setRowHeight(20);
  $excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $no);
  // $excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style_row);

  $xid = $data['xid'];
  $sql2 = "select xid, gambar from gbshoes where id_shoes = '$xid' order by xid ";
  $result2 = mysql_query($sql2);
  $n = mysql_num_rows($result2);
  
  if ($n > 0) {
  $kolom = 1;
  while ($data2 = mysql_fetch_array($result2)){
    if ($kolom == 1) {
      $posisi = 'B';
    }
    elseif ($kolom == 2) {
      $posisi = 'C';
    }
    elseif ($kolom == 3) {
      $posisi = 'D';
    }
    // $excel->setActiveSheetIndex(0)->setCellValue($posisi.$numrow, $data2['gambar']);

    $xgambar = $data2['gambar'];
    list($width, $height) = getimagesize($xgambar);

    if($width > $height){
      $objDrawing2 = new PHPExcel_Worksheet_Drawing();
      $objDrawing2->setPath($xgambar);
      $objDrawing2->setCoordinates($posisi.$numrow);
      // $objDrawing2->setHeight(140);
      $objDrawing2->setWidth(105);
      $objDrawing2->setOffsetY(5);
      $objDrawing2->setWorksheet($excel->getActiveSheet());
    }
    elseif ($height > $width) {
      $objDrawing2 = new PHPExcel_Worksheet_Drawing();
      $objDrawing2->setPath($xgambar);
      $objDrawing2->setCoordinates($posisi.$numrow);
      $objDrawing2->setHeight(105);
      // $objDrawing2->setWidth(140);
      $objDrawing2->setOffsetY(5);
      $objDrawing2->setWorksheet($excel->getActiveSheet());
    }
    elseif ($height == $width) {
      $objDrawing2 = new PHPExcel_Worksheet_Drawing();
      $objDrawing2->setPath($xgambar);
      $objDrawing2->setCoordinates($posisi.$numrow);
      $objDrawing2->setHeight(65);
      $objDrawing2->setWidth(65);
      $objDrawing2->setOffsetY(5);
      $objDrawing2->setWorksheet($excel->getActiveSheet());
    }
  $kolom++;
  }
  }
  else{
    $objDrawing2 = new PHPExcel_Worksheet_Drawing();
    $objDrawing2->setPath('gambar/No_Image_Available.jpg');
    $objDrawing2->setCoordinates('B'.$numrow);
    // $objDrawing2->setHeight(90);
    $objDrawing2->setWidth(100);
    $objDrawing2->setOffsetY(5);
    $objDrawing2->setWorksheet($excel->getActiveSheet());
  }

  $excel->setActiveSheetIndex(0)->setCellValue('E'.$numrowKeterangan, "SEASON");
  $excel->setActiveSheetIndex(0)->setCellValue('F'.$numrowKeterangan, ":");
  $excel->setActiveSheetIndex(0)->setCellValue('G'.$numrowKeterangan, $data['nmseason']);
  $excel->setActiveSheetIndex(0)->setCellValue('E'.$numrowKeterangan = $numrowKeterangan + 1, "CUSTOMER");
  $excel->setActiveSheetIndex(0)->setCellValue('F'.$numrowKeterangan, ":");
  $excel->setActiveSheetIndex(0)->setCellValue('G'.$numrowKeterangan, $data['customer']);
  $excel->setActiveSheetIndex(0)->setCellValue('E'.$numrowKeterangan = $numrowKeterangan + 1, "RND");
  $excel->setActiveSheetIndex(0)->setCellValue('F'.$numrowKeterangan, ":");
  $excel->setActiveSheetIndex(0)->setCellValue('G'.$numrowKeterangan, $data['rnd']);
  $excel->setActiveSheetIndex(0)->setCellValue('E'.$numrowKeterangan = $numrowKeterangan + 1, "ARTIKEL");
  $excel->setActiveSheetIndex(0)->setCellValue('F'.$numrowKeterangan, ":");
  $excel->setActiveSheetIndex(0)->setCellValue('G'.$numrowKeterangan, $data['artikel']);
  $excel->setActiveSheetIndex(0)->setCellValue('E'.$numrowKeterangan = $numrowKeterangan + 1, "MATERIAL");
  $excel->setActiveSheetIndex(0)->setCellValue('F'.$numrowKeterangan, ":");
  $excel->setActiveSheetIndex(0)->setCellValue('G'.$numrowKeterangan, $data['material']);
  $excel->setActiveSheetIndex(0)->setCellValue('E'.$numrowKeterangan = $numrowKeterangan + 1, "COLOR");
  $excel->setActiveSheetIndex(0)->setCellValue('F'.$numrowKeterangan, ":");
  $excel->setActiveSheetIndex(0)->setCellValue('G'.$numrowKeterangan, $data['color']);
  $excel->setActiveSheetIndex(0)->setCellValue('E'.$numrowKeterangan = $numrowKeterangan + 1, "SIZE");
  $excel->setActiveSheetIndex(0)->setCellValue('F'.$numrowKeterangan, ":");
  $excel->setActiveSheetIndex(0)->setCellValue('G'.$numrowKeterangan, $data['size']);
  $excel->setActiveSheetIndex(0)->setCellValue('E'.$numrowKeterangan = $numrowKeterangan + 1, "SIDE RIGHT (Qty)");
  $excel->setActiveSheetIndex(0)->setCellValue('F'.$numrowKeterangan, ":");
  $excel->setActiveSheetIndex(0)->setCellValue('G'.$numrowKeterangan, $data['qtyright']);
  $excel->setActiveSheetIndex(0)->setCellValue('E'.$numrowKeterangan = $numrowKeterangan + 1, "SIDE LEFT (Qty)");
  $excel->setActiveSheetIndex(0)->setCellValue('F'.$numrowKeterangan, ":");
  $excel->setActiveSheetIndex(0)->setCellValue('G'.$numrowKeterangan, $data['qtyleft']);
  $excel->setActiveSheetIndex(0)->setCellValue('E'.$numrowKeterangan = $numrowKeterangan + 1, "RAK");
  $excel->setActiveSheetIndex(0)->setCellValue('F'.$numrowKeterangan, ":");
  $excel->setActiveSheetIndex(0)->setCellValue('G'.$numrowKeterangan, $data['rak']);
  $excel->setActiveSheetIndex(0)->setCellValue('E'.$numrowKeterangan = $numrowKeterangan + 1, "NAMA LAST");
  $excel->setActiveSheetIndex(0)->setCellValue('F'.$numrowKeterangan, ":");
  $excel->setActiveSheetIndex(0)->setCellValue('G'.$numrowKeterangan, $data['nama_last']);
  $excel->setActiveSheetIndex(0)->setCellValue('E'.$numrowKeterangan = $numrowKeterangan + 1, "TGL TERIMA");
  $excel->setActiveSheetIndex(0)->setCellValue('F'.$numrowKeterangan, ":");
  $excel->setActiveSheetIndex(0)->setCellValue('G'.$numrowKeterangan, $data['tgl']);
  $excel->setActiveSheetIndex(0)->setCellValue('E'.$numrowKeterangan = $numrowKeterangan + 1, "STATUS");
  $excel->setActiveSheetIndex(0)->setCellValue('F'.$numrowKeterangan, ":");
  $excel->setActiveSheetIndex(0)->setCellValue('G'.$numrowKeterangan, $data['status']);

  $excel->getActiveSheet()->mergeCells('A'.$numrow.':A'.$numrowKeterangan);
  $excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style_row);

  $excel->getActiveSheet()->mergeCells('B'.$numrow.':B'.$numrowKeterangan);
  $excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($style_row);

  $excel->getActiveSheet()->mergeCells('C'.$numrow.':C'.$numrowKeterangan);
  $excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($style_row);

  $excel->getActiveSheet()->mergeCells('D'.$numrow.':D'.$numrowKeterangan);
  $excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($style_row);

  $excel->getActiveSheet()->getStyle('A'.$numrowKeterangan)->applyFromArray($style_borderBottom);
  $excel->getActiveSheet()->getStyle('B'.$numrowKeterangan)->applyFromArray($style_borderBottom);
  $excel->getActiveSheet()->getStyle('C'.$numrowKeterangan)->applyFromArray($style_borderBottom);
  $excel->getActiveSheet()->getStyle('D'.$numrowKeterangan)->applyFromArray($style_borderBottom);
  $excel->getActiveSheet()->getStyle('E'.$numrowKeterangan)->applyFromArray($style_borderBottom);
  $excel->getActiveSheet()->getStyle('F'.$numrowKeterangan)->applyFromArray($style_borderBottom);
  $excel->getActiveSheet()->getStyle('G'.$numrowKeterangan)->applyFromArray($style_borderBottom);

  // $excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($style_borderTop);
  // $excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($style_borderTop);
  // $excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($style_borderTop);


  $numrow = $numrow + 13;

  $break = $numrow - 1;
   // Add page breaks every 6 rows
  if ($no % 4 == 0) {
    $excel->getActiveSheet()->setBreak( 'A' . $break, PHPExcel_Worksheet::BREAK_ROW );
  }

  $numrowKeterangan++;
  $no++;
}
  
  $rowLeftHorizontally = $numrowKeterangan - 1;
  // $excel->getActiveSheet()->getStyle('G5:G'.$numrowKeterangan)->applyFromArray($style_borderRight);
  $excel->getActiveSheet()->getStyle('G5:G'.$rowLeftHorizontally)->applyFromArray($style_rowLeftHorizontally);


// Set judul file excel nya
$excel->getActiveSheet(0)->setTitle("Laporan Master Heel");
$excel->setActiveSheetIndex(0);

// Set Orientation, size and scaling
$excel->setActiveSheetIndex(0);
$excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
$excel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
$excel->getActiveSheet()->getPageSetup()->setFitToPage(true);
$excel->getActiveSheet()->getPageSetup()->setFitToWidth(1);
$excel->getActiveSheet()->getPageSetup()->setFitToHeight(0);
$excel->getActiveSheet()->getPageSetup()->setRowsToRepeatAtTopByStartAndEnd(1, 4);
$excel->getActiveSheet()->freezePane('A5');

// FOOTER
$xname = $_SESSION[$domainApp."_myname"];
$xgroup = $_SESSION[$domainApp."_mygroup"];
$excel->getActiveSheet()->getHeaderFooter()->setOddFooter('&L Tgl Cetak : &D &T by '.$xname.' # '.$xgroup.' &R Halaman Ke : &P / &N');

// Proses file excel
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="Laporan Master Heel.xls"'); // Set nama file excel nya
header('Cache-Control: max-age=0');

$write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
$write->save('php://output');
?>

