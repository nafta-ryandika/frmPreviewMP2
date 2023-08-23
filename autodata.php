<?php

    include("../../configuration.php");
    include("../../connection.php");
    
//    echo "bxxx";
        if (isset($_POST['infilter'])) {
            if ($_POST['infilter'] != '') {
                $infilter = $_POST['infilter'];
            }
        }
        
	$sqlbrg="select
                    *
                    from
                    nama_table
                    group by kd_table 
                    ORDER BY kd_table";
//        echo $sqlbrg;
	$resultbrg = mysql_query($sqlbrg) or die(mysql_error());
	
	if($resultbrg)
	{
            while($rowbrg=mysql_fetch_array($resultbrg))
		{
			$data .= $rowbrg['data1']."|";
		}
                
                echo rtrim($data,'|');
        }
?>