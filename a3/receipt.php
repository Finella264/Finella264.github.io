<?php

      require_once("tools.php");

$fp = fopen('bookings.txt', "r");
flock($fp, LOCK_SH);
$headings = fgetcsv($fp);
while ($alineofcells = fgetcsv($fp)) {
  $records[] = $alineofcells;
}
flock($fp, LOCK_UN);
fclose($fp);

$date = date("d-m-Y");

$name = $records[0][1];
$email = $records[0][0];
$mobile = $records[0][2];

$movieName = $records[2][0];
if ($movieName == 'RMC')
    $movieName = 'A Star Is Born';
if ($movieName == 'ACT')
    $movieName = "The Girl in the Spider's Web";
if ($movieName == 'ANM')
    $movieName = 'Ralph Breaks the Internet';
if ($movieName == 'AHF')
    $movieName = 'Boy Erased';

$movieHour = $records[2][1];
$movieDay = $records[2][2];

$STAseats = $records[1][0];
$STPseats = $records[1][1];
$STCseats = $records[1][2];
$FCAseats = $records[1][3];
$FCPseats = $records[1][4];
$FCCseats = $records[1][5];

$total = $records[1][6];
$decimalTotal = number_format((float)$total, 2, '.', '');  // Outputs -> 105.00

$GST = $total/11;
$decimalGST = number_format((float)$GST, 2, '.', '');

?>

<!DOCTYPE html>
<html lang='en'>
  <head>
     
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Assignment 3</title>

    <!-- Keep wireframe.css for debugging, add your css to style.css -->
    <link id='wireframecss' type="text/css" rel="stylesheet" href="../wireframe.css" disabled>
    <link id='stylecss' type="text/css" rel="stylesheet" href="css/style.css">
    <script src='../wireframe.js'></script>
      
    <link href='https://fonts.googleapis.com/css?family=Major+Mono+Display' rel='stylesheet'>

    <link href="https://fonts.googleapis.com/css?family=Domine" rel="stylesheet">
    
    <script 
        type = "text/javascript" src="tools.js" defer>
    </script>

    <style>
      
        <?php
        // This PHP code inserts CSS to style the "current page" link in the nav area
        include ("css/style.css");
        ?>
      
    </style>
    
      
  </head>


<body>
      
    <header>
       <div class = title>
            <h1 style='color:navy;'>LUNARDO CINEMA</h1>
            <p>
                <img src='../../media/A2 Logo2.png' width='250' alt='company logo' />
            </p>
        </div>
    </header>
      
    <h2>RECEIPT</h2>
      <p>ABN number: 00 123 456 789 </p>
      <p>126 High St. Prahran 3181</p>
      <p>Phone: 9384 3361</p>
      <p>Email: enquiries@lunardocinema.com</p>
      <br>
      <p>Date: <?php echo $date;?></p>
      <p>Name: <?php echo $name;?></p>
      <p>Email: <?php echo $email;?></p>
      <p>Mobile: <?php echo $mobile;?></p>
      <br>
      <p>Movie: <?php echo $movieName;?></p>
      <p>Time: <?php echo $movieHour;?>:00</p>
      <p>Day: <?php echo $movieDay;?></p>
      <br>
<table>
  <tr>
    <td>Standard Adults</td>
    <td><?php echo $STAseats;?></td>
  </tr>
  <tr>
    <td>Standard Concession</td>
    <td><?php echo $STPseats;?></td>
  </tr>
  <tr>
    <td>Standard Children</td>
    <td><?php echo $STCseats;?></td>
  </tr>
  <tr>
    <td>First Class Adults</td>
    <td><?php echo $FCAseats;?></td>
  </tr>
  <tr>
    <td>First Class Concession</td>
    <td><?php echo $FCPseats;?></td>
  </tr> 
  <tr>
    <td>First Class Children</td>
    <td><?php echo $FCCseats;?></td>
  </tr> 
  <tr>
    <td>GST included</td>
    <td>($<?php echo $decimalGST;?>)</td>
  </tr> 
  <tr>
    <td>Total</td>
    <td>$<?php echo $decimalTotal;?></td>
  </tr>  
</table>
      
<br> 
     
<h2>Movie Ticket</h2>
<p>Date: <?php echo $date;?></p>
<p>Movie: <?php echo $movieName;?></p>
<p>Time: <?php echo $movieHour;?>:00</p>
<p>Day: <?php echo $movieDay;?></p>   
 
<table>
  <tr>
    <td>Standard Adults</td>
    <td><?php echo $STAseats;?></td>
  </tr>
  <tr>
    <td>Standard Concession</td>
    <td><?php echo $STPseats;?></td>
  </tr>
  <tr>
    <td>Standard Children</td>
    <td><?php echo $STCseats;?></td>
  </tr>
  <tr>
    <td>First Class Adults</td>
    <td><?php echo $FCAseats;?></td>
  </tr>
  <tr>
    <td>First Class Concession</td>
    <td><?php echo $FCPseats;?></td>
  </tr> 
  <tr>
    <td>First Class Children</td>
    <td><?php echo $FCCseats;?></td>
  </tr> 
</table>   
      
</body>
</html>
    