<?php
  include("../../connection.php");
  include("../../endec.php");
  include("akses.php");
  require_once('calendar/classes/tc_calendar.php');   
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN""http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    
  <title>Form Preview MP</title>
  <META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <meta http-equiv="expires" content="0">
  <META HTTP-EQUIV="PRAGMA" CONTENT="NO-CACHE">
</head>


<!-- <script type="text/javascript" src="js/jquery-latest.js"></script> -->
<script type="text/javascript" src="js/jquery.tablesorter.js"></script>
<script language="javascript" src="calendar/calendar.js"></script>

<link rel="stylesheet" href="../../theme/south-street/jquery-ui-1.8.13.custom.css">
<!-- <script src="../../js/jquery-1.5.1.js"></script> -->
<script src="../../js/ui/jquery.ui.core.js"></script>
<script src="../../js/ui/jquery.ui.widget.js"></script>
<script src="../../js/ui/jquery.ui.datepicker.js"></script>
<link rel="stylesheet" href="css/demos.css">

<!-- MODAL DIALOG -->
<script type="text/javascript" src="../../js/jquery.js"></script>
<script type="text/javascript" src="../../js/jquery-ui.js"></script>
<link rel="stylesheet" href="../../css/jquery-ui.css"/>

<!--AUTOCOMPLETE-->

<?php
  $xrdm = date("YmdHis");
  echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"css/style.css?verion=$xrdm\" />";
  echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"css/frmstyle.css?version=$xrdm\" />";
?>
<link href="calendar/calendar.css" rel="stylesheet" type="text/css">
  
<script type="text/javascript" src="js/frm1.js?<?=$xrdm?>"></script>
<style>
.photo {
width: 300px;
text-align: center;
}
.photo .ui-widget-header {
margin: 1em 0;
}
.map {
width: 125px;
height: 125px;
}
.ui-tooltip {
max-width: 1024px;
}
</style>
<body>
  <table id="tabelview" width="100%"  border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td>
        <table width="100%"  border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td colspan="2">
              <div align="left">
                <span style="font-size: 14px;font:Arial, Helvetica, sans-serif;font-weight: bold;">
                    Form Preview MP
                </span>
                <hr/>
              </div>
            </td>
          </tr>
        </table>
      </td>
    </tr>
    <tr>
      <td>
        <div id="areasearch">
        <fieldset class="info_fieldset"><legend>Search</legend>
          <form id="ajax-contact-form" action="#">
            <table width="100%"  border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td>
                  <div style="text-align: center;">
                    <span>No. MP</span>
                    <input type="text" id="innomp" onkeydown="enterfind(event)">
                    <INPUT id="cmdfind" class="buttongofind" type="button" name="nmcmdfind" value="Find" onclick="check_mp()"/>
                    <select id="exporttype" style="display: none;">
                      <option value="pdf" selected>Pdf</option>
                    </select>
                    <INPUT id="cmdexport" class="buttonexport" type="button" name="nmcmdexport" value="Export" onclick="check_mp2()"/>
                    <br/>
                  </div>
                </td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
            </table>
          </form>
        </fieldset>
      </div>
      </td>
    </tr>
    
    <tr>
      <td>
        <div id="frmloading" align="center">
          <img src="img/ajax-loader.gif" />
        </div>
        <div id="frmbody">
          <div id="frmcontent">
          </div>
        </div>
      </td>
    </tr>
  </table>

  <div id="dialog-open" class="dialog-open"></div>

  <FORM id="formexport" name="nmformexport" action="export.php" method="post" onsubmit="window.open ('', 'NewFormInfo', 'scrollbars,width=730,height=500')" target="NewFormInfo">
    <input id="indata" name="indata" type="hidden" value=""/>
    <input id="instatus" name="instatus" type="hidden" value=""/>
  </FORM> 

</body>

</html>
<?php
mysql_close($conn);
?>