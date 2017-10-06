<?php
    
    $host = '127.0.0.1';

    $db = 'test';

    $user = 'root';

    $pass = '';

    $charset = 'utf8';

    $dsn = "mysql:host=$host;dbname=$db;charset =$charset";

    $pdo = new PDO ($dsn,$user,$pass);

    date_default_timezone_set('America/Mexico_City'); // CDT

    $current_date = date('d');

    $current_month = date('m');

    $current_year = date('Y');

    // echo $current_date . '<br />';

    // echo $current_month. '<br />';
    
    // echo $current_year. '<br />';

    $totalCount = 0;

    $sql = "SELECT barcode, expdate FROM barcodetest";

    $stmt = $pdo->prepare($sql);

    $stmt->execute();

    while($row = $stmt->fetch(PDO::FETCH_ASSOC))
    {
             $barcodeVal = $row['barcode'];
             $expVal = $row['expdate'];

             $slashCount = substr_count($expVal, '/');

             // echo 'SLASH COUNT: '. $slashCount . '<br />';

             $expMonth = substr($expVal, 0,2) . '<br />';


            if($slashCount === 1)
            {
                $expYear = substr($expVal,3,4);
            }

            else if($slashCount === 2)
            {
                $expYear = substr($expVal,6,4);
            }
            
           
        
            if($expYear <= $current_year)
            {
                // echo ' EXP MONTH : '. $expMonth. ' & EXP YEAR : '. $expYear .'<br />';
                if($expMonth < $current_month)
                {
                    //echo 'EXPIRED'. '<br />';
                    
                    echo $barcodeVal . '<br />';
                    
                    $sql1 = "DELETE FROM barcodetest WHERE barcode = :myBarcode";
                    
                    $stmt1 = $pdo->prepare($sql1);
                    
                    $stmt1->bindParam(':myBarcode',$barcodeVal, PDO::PARAM_STR);
                    
                    $stmt1->execute();
                    
                    $totalCount++;
                    
                    
                    
                }
            }
         // echo '<br / >-------------------------------------<br />';
           
    }
     echo $totalCount. ' records purged!';
?>