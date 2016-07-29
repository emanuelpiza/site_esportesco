 <?php  
 
    header('Content-Type: text/html; charset=utf-8');
    session_start();

    ob_start();
    include('./admin/dbcon/dbcon.php');

    include ("./classes/PHPExcel/IOFactory.php");  
    $html="oi<table border='1'>";  
    $objPHPExcel = PHPExcel_IOFactory::load('./times/tabelas/BoletimBenteler.xlsx');  
    $partidas = $objPHPExcel->getSheetByName("Partidas"); 
    $highestRow = $partidas->getHighestRow();  
    for ($row=2; $row<=$highestRow; $row++)  
    {  
        if (mysqli_real_escape_string($mysqli, $partidas->getCellByColumnAndRow(0, $row)->getValue()) <> null ){
            $html.="<tr>";  
            $name = mysqli_real_escape_string($mysqli, $partidas->getCellByColumnAndRow(0, $row)->getValue());  
            $email = mysqli_real_escape_string($mysqli, $partidas->getCellByColumnAndRow(1, $row)->getValue());  
            $sql = "INSERT INTO tbl_excel(excel_name, excel_email) VALUES ('".$name."', '".$email."')";  
            mysqli_query($mysqli, $sql);  
            $html.= '<td>'.$name.'</td>';  
            $html .= '<td>'.$email.'</td>';  
            $html .= "</tr>";           
        }
    }  
    $jogadores = $objPHPExcel->getSheetByName("Jogadores"); 
    $highestRow = $jogadores->getHighestRow();  
    for ($row=2; $row<=$highestRow; $row++)  
    {  
        $html.="<tr>";  
        if (mysqli_real_escape_string($mysqli, $jogadores->getCellByColumnAndRow(0, $row)->getValue()) <> null ){
            $name = mysqli_real_escape_string($mysqli, $jogadores->getCellByColumnAndRow(0, $row)->getValue());  
            $email = mysqli_real_escape_string($mysqli, $jogadores->getCellByColumnAndRow(1, $row)->getValue());  
            $sql = "INSERT INTO tbl_excel(excel_name, excel_email) VALUES ('".$name."', '".$email."')";  
            mysqli_query($mysqli, $sql);  
            $html.= '<td>'.$name.'</td>';  
            $html .= '<td>'.$email.'</td>';  
            $html .= "</tr>";           
        }
    }  
    $html .= '</table>';  
    echo $html;  
    echo '<br />Data Inserted';  
 ?>  