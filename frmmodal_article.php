<link rel="stylesheet" href="css/table.css">
<?php
  include("../../connection.php");

  if(isset($_POST['article'])){
    $article = $_POST['article'];
  }
?>
<script type="text/javascript">
    // $(document).ready(function() {
    //   $("#table_article").focus();
    //   $("#table_article tbody tr").className = "";

    // // var rows = document.getElementById("table_gudang").children[1].children;
    //   // var rows = document.getElementById("table_article").children[1].children;
    //   var rows = $("#table_article tbody tr");
    //   var selectedRow = 0;
    //   var baris = 1;
    //   $( "#table_article" ).keydown(function(e) {
    //     e.preventDefault();
    //     rows[selectedRow].classList.remove("highlight");
        
    //     if(e.keyCode == 38){
    //       selectedRow--;
    //       baris--;
    //     } 
    //     else if(e.keyCode == 40){  
    //       selectedRow++;
    //       baris++;
    //     }
    //     else if (e.keyCode == 13){
    //       var nomp = $('#table_article tr:eq('+baris+') td:eq(0)').text();
    //       $("#txtdata0").val(nomp);
    //       $("#dialog-open").dialog("close");
    //     }
    //     else if(e.keyCode == 27){  
    //       $("#dialog-open").dialog("close");
    //     }
        
    //     if(selectedRow >= rows.length){
    //         selectedRow = 0;
    //         baris = 1;
    //     } 
    //     else if(selectedRow < 0){
    //         selectedRow = rows.length-1;
    //         baris =  rows.length;
    //     }
        
    //     rows[selectedRow].className += "highlight";
    //   });
    // rows[0].className += "highlight"; 
    // });

    function select(nomp) {
      $("#txtdata0").val(nomp);
      $("#dialog-open").dialog("close");
    }
</script>

<div>
  <fieldset class="info_fieldset"><legend>Search</legend>
    <table id="table_article" class="table" tabindex="0" style="width: 100%; margin-top: 10px; margin-bottom: 10px;">
      <thead>
        <tr style="background-color: lightgray; font-size: 9pt;">
          <th align="center">No. MP</th>
          <th align="center">Season</th>
          <th align="center">Art. Produksi</th>
          <th align="center">Warna</th>
          <th align="center">Shoe Last / Heel</th>
        </tr>
      </thead>
      <tbody>
        <?php
          $sql = "SELECT 
                  a.mpno, a.article, a.colour, a.`last`, (SELECT season FROM rpprgrsh WHERE nomp = a.mpno) AS season
                  FROM clmphead a 
                  WHERE a.article LIKE '%".$article."%' AND a.dateiss IS NOT NULL
                  ORDER BY a.mpno";
          $res = mysql_query($sql,$conn);
          $row = mysql_num_rows($res);

          // if ($row > 0) {
            while ($data = mysql_fetch_array($res)) {
        ?>
              <tr onclick="select('<?=$data["mpno"]?>')" onMouseOver="this.className='highlight'" onMouseOut="this.className='normal'" style="cursor: pointer;">
                <td><?=$data["mpno"]?></td>
                <td><?=$data["season"]?></td>
                <td><?=$data["article"]?></td>
                <td><?=$data["colour"]?></td>
                <td><?=$data["last"]?></td>
              </tr>
        <?php
            }
          // }
        ?>
      </tbody>
    </table>
  </fieldset>
</div>