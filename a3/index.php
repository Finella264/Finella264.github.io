<?php
      
require_once("tools.php");

if (!empty ($_POST))
{      
//clear button
unset ($_SESSION['cust'], $_SESSION['movie'], $_SESSION['seats']);      
    
$errorsFound = 0;

$emailError = '';
$email = $_POST['cust']['email'];

$nameError = '';
$name = $_POST['cust']['name'];

$mobile = $_POST['cust']['mobile'];
$mobileError = '';

$cardError = '';
$card = $_POST['cust']['card'];

$expiry1 = $_POST['cust']['expiry'];
$expiryError = '';
$expiry2 = $expiry1;
$expiry2 = explode('-', $expiry1);
$month = $expiry2[1];
$day = $expiry2[2];
$year = $expiry2[0];
$intMonth =(int)$month;
$intDay = (int)$day;
$intYear = (int)$year;

$date = date("Y-m-d", strtotime(" +1 month"));

$seatsError = '';
$seats1 = $_POST['seats']['STA'];
$seats2 = $_POST['seats']['STP'];
$seats3 = $_POST['seats']['STC'];
$seats4 = $_POST['seats']['FCA'];
$seats5 = $_POST['seats']['FCP'];
$seats6 = $_POST['seats']['FCC'];

$movieError = '';
$movie1 = $_POST['movie']['id'];
$movie2 = $_POST['movie']['hour'];
$movie3 = $_POST['movie']['day'];


// if email is empty or does not pass validation, increment $errorsFound
if ((empty ($email)) || (!filter_var($email, FILTER_VALIDATE_EMAIL)))
{
    $emailError = '<span style = "color:red">      Enter a valid email address</span>';
    $errorsFound++;
}
else 
{
    $cleanEmail = $email; 
    $_SESSION['cust']['email'] = $cleanEmail;
}

// repeat for other cust POST data, incrementing $errorsFound when validation fails
if ((empty ($name)) || (!preg_match("/^[a-zA-Z \-.']{1,100}$/", $name)))
{
    $nameError = '<span style = "color:red">      Enter a valid name</span>';
    $errorsFound++;
}
else
{
    $cleanName = $name; 
    $_SESSION['cust']['name'] = $cleanName;
}

if ((empty ($mobile)) || (!preg_match("/^(\(04\)|04|\+614)( ?\d){8}$/", $mobile)))
{
    $mobileError = '<span style = "color:red">      Enter a valid mobile number</span>';
    $errorsFound++;
}
else
{
    $cleanMobile = $mobile; 
    $_SESSION['cust']['mobile'] = $cleanMobile;
}

if ((empty ($card)) || (!preg_match("/^( ?\d){16}$/", $card)))
{
    $cardError = '<span style = "color:red">      Enter a valid card number</span>';
    $errorsFound++;
}
else
{
    $cleanCard= $card; 
    $_SESSION['cust']['card'] = $cleanCard;
}

if ((empty ($expiry1)) || (!checkdate($intMonth, $intDay, $intYear)) || ($expiry1 < $date))
{
    $expiryError = '<span style = "color:red">      Enter a valid date</span>';
    $errorsFound++;
}
else
{
    $cleanExpiry= $expiry1; 
    $_SESSION['cust']['expiry'] = $cleanExpiry;
}

if (empty ($seats1) && (empty($seats2)) && (empty($seats3)) && (empty($seats4)) && (empty($seats5)) && (empty($seats6))) 
{
    $seatsError = '<span style = "color:red">      Select seats</span>';
    $errorsFound++;
}
else
{
    $cleanSeats1= $seats1;
    $cleanSeats2= $seats2;
    $cleanSeats3= $seats3;
    $cleanSeats4= $seats4;
    $cleanSeats5= $seats5;
    $cleanSeats6= $seats6;
    $_SESSION['seats']['STA'] = $cleanSeats1;
    $_SESSION['seats']['STP'] = $cleanSeats2;
    $_SESSION['seats']['STC'] = $cleanSeats3;
    $_SESSION['seats']['FCA'] = $cleanSeats4;
    $_SESSION['seats']['FCP'] = $cleanSeats5;
    $_SESSION['seats']['FCC'] = $cleanSeats6;
}

$discount = 0;

if ($movie3 == 'MON' ||$movie3 == 'WED'  || ($movie3 != 'SAT' && $movie3 != 'SUN' && $movie2 == 12))
{
    $discount++;
    $salePrice1 = $seatPrices['DISC']['STA'] * $seats1;
    $salePrice2 = $seatPrices['DISC']['STP'] * $seats2;
    $salePrice3 = $seatPrices['DISC']['STC'] * $seats3;
    $salePrice4 = $seatPrices['DISC']['FCA'] * $seats4;
    $salePrice5 = $seatPrices['DISC']['FCP'] * $seats5;
    $salePrice6 = $seatPrices['DISC']['FCC'] * $seats6;
}
else 
{
    $salePrice1 = $seatPrices['FULL']['STA'] * $seats1;
    $salePrice2 = $seatPrices['FULL']['STP'] * $seats2;
    $salePrice3 = $seatPrices['FULL']['STC'] * $seats3;
    $salePrice4 = $seatPrices['FULL']['FCA'] * $seats4;
    $salePrice5 = $seatPrices['FULL']['FCP'] * $seats5;
    $salePrice6 = $seatPrices['FULL']['FCC'] * $seats6;
}

    $total = $salePrice1 + $salePrice2 + $salePrice3 + $salePrice4 + $salePrice5 + $salePrice6;
    
    $_SESSION['seats']['cost'] = $total;
 
if (empty ($movie1) && (empty($movie2)) && (empty($movie3))) 
{
    $movieError = '<span style = "color:red">      Select a movie</span>';
    $errorsFound++;
}
else
{
    $cleanMovie1= $movie1;
    $cleanMovie2= $movie2;
    $cleanMovie3= $movie3;
    $_SESSION['movie']['id'] = $cleanMovie1;
    $_SESSION['movie']['day'] = $cleanMovie2;
    $_SESSION['movie']['hour'] = $cleanMovie3;   
}   

// if no errors are found (ie all fields ok) forward to receipt.php
if ($errorsFound == 0) 
{
$fp = fopen("bookings.txt", "a");
flock($fp, LOCK_SH);
foreach ($_SESSION as $line)
fputcsv($fp, $line);
flock($fp, LOCK_UN);
fclose($fp);
}
    
header("Location: receipt.php");

}

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
 
    <?php
        php2js($seatPrices, 'seatPrices');
    ?>
       
    <style>
        <?php
        // This PHP code inserts CSS to style the "current page" link in the nav area
        include ("css/style.css");
        ?>
    </style>
      
  </head>


  <body>
      
 <!-- Ralph Breaks The Internet Modal -->
      <div id="Modal_ANM" class="modal" style = overflow: auto;>

            <!-- Modal content -->
            <div class="modal-content" >
            <h3 style = 'margin-top: 0px;'> Ralph Breaks The Internet<span class="close" onclick = "closeModal('ANM');">&times;</span></h3>
                
                <div>
                    <div class='panel'>
                        <div class='synopsis'>
                            <br>
                           
                            <p>"Ralph Breaks the Internet: Wreck-It Ralph 2" leaves Litwak's video arcade behind, venturing into the uncharted, expansive and thrilling world of the internet-which may or may not survive Ralph's wrecking. Video game bad guy Ralph (voice of John C. Reilly) and fellow misfit Vanellope von Schweetz (voice of Sarah Silverman) must risk it all by traveling to the world wide web in search of a replacement part to save Vanellope's video game, Sugar Rush. In way over their heads, Ralph and Vanellope rely on the citizens of the internet-the netizens-to help navigate their way, including a webite entrepreneur named Yesss (voice of Taraji P. Henson), who is the head algorithm and the heart and soul of trend-making site "BuzzzTube." </p>
                            <p>Director: Rich Moore, Phil Johnston </p>
                            <p>Main Cast: John C. Reilly, Alan Tudyk, Kristen Bell, Idina Menzel, Sarah Silverman, Auli'i Cravalho, Taraji P. Henson, Mandy Moore, Ed O'Neill, Jane Lynch, Kelly Macdonald</p>
                            <p>Classification: PG (Mild themes and animated violence)</p>
                            <p>Genre: Animation, Comedy </p>
                            <p>Release Date: Wednesday, 26 December 2018</p>
                            <p>Running Time: 112 Mins </p>
                        </div>

                        <div class='trailer'>
                            <video width='500' controls>
                                <source src='../../media/RalphBreakstheInternetOfficialTrailer.mp4' type='video/mp4'>
                                <source src='../../media/RalphBreakstheInternetOfficialTrailer.ogg' type='video/ogg'>Your browser does not support HTML5 video
                            </video>
                        </div>
                    </div>
                
                        <div style = 'text-align:center'; padding-bottom: 20px;>
                            
                            <h3 style = 'margin-top: 0px;'> Make a Booking:</h3>

                            <a href='#booking'>
                            <button onclick = "updateMovieDetails('ANM', 'MON', '12'); isFullOrDiscount('MON','12')" class = 'button' > Monday 12pm</button>
                            <button onclick = "updateMovieDetails('ANM', 'TUE', '12'); isFullOrDiscount('TUE','12')" class = 'button'> Tuesday 12pm</button>
                            <button onclick = "updateMovieDetails('ANM', 'WED', '18'); isFullOrDiscount('WED','18')" class = 'button'> Wednesday 6pm</button>
                            <button onclick = "updateMovieDetails('ANM', 'THU', '18'); isFullOrDiscount('THU','18')" class = 'button'> Thursday 6pm</button>
                            <button onclick = "updateMovieDetails('ANM', 'FRI', '18'); isFullOrDiscount('FRI','18')" class = 'button'> Friday 6pm</button>
                            <button onclick = "updateMovieDetails('ANM', 'SAT', '12'); isFullOrDiscount('SAT','12')" class = 'button'> Saturday 12pm</button>
                            <button onclick = "updateMovieDetails('ANM', 'SUN', '12'); isFullOrDiscount('SUN','12')" class = 'button'> Sunday 12pm</button>
                            </a>

                        </div>
                </div>
            </div>          
        </div>
   

     <!-- Boy Erased Modal -->
      <div id="Modal_AHF" class="modal" style = overflow: auto;>

            <!-- Modal content -->
            <div class="modal-content" >
            <h3 style = 'margin-top: 0px;'> Boy Erased<span class="close" onclick = "closeModal('AHF');">&times;</span></h3>
                
                <div>
                    <div class='panel'>
                        <div class='synopsis'>
                            <br>
                            <p>BOY ERASED tells the story of Jared (Hedges), the son of a Baptist pastor in a small American town, who is outed to his parents (Kidman and Crowe) at age 19. Jared is faced with an ultimatum: attend a conversion therapy program - or be permanently exiled and shunned by his family, friends, and faith. Boy Erased is the true story of one young man's struggle to find himself while being forced to question every aspect of his identity. </p>
                            <p>Director: Joel Edgerton </p>
                            <p>Main Cast: Joel Edgerton, Nicole Kidman, Russell Crowe, Xavier Dolan, Joe Alwyn, Lucas Hedges, Troye Sivan</p>
                            <p>Classification: MA15+ (A scene of strong sexual violence)</p>
                            <p>Genre: Biography, Drama </p>
                            <p>Release Date: Thursday, 8 November 2018 </p>
                            <p>Running Time: 115 Mins </p>
                        </div>

                        <div class='trailer'>
                            <video width='500' controls>
                                <source src='../../media/BoyErasedTrailer.mp4' type='video/mp4'>
                                <source src='../../media/BoyErasedTrailer.ogg' type='video/ogg'>Your browser does not support HTML5 video
                            </video>
                        </div>
                    </div>
                

                        <div style = 'text-align:center'; padding-bottom: 20px;>
                            
                            <h3 style = 'margin-top: 0px;'> Make a Booking:</h3>

                            <a href='#booking'>
                            <button onclick = "updateMovieDetails('AHF', 'WED', '12'); isFullOrDiscount('WED','12')" class = 'button' > Wednesday 12pm</button>
                            <button onclick = "updateMovieDetails('AHF', 'THU', '12'); isFullOrDiscount('THU','12')" class = 'button'> Thursday 12pm</button>
                            <button onclick = "updateMovieDetails('AHF', 'FRI', '12'); isFullOrDiscount('FRI','12')" class = 'button'> Friday 12pm</button>
                            <button onclick = "updateMovieDetails('AHF', 'SAT', '21'); isFullOrDiscount('SAT','21')" class = 'button'> Saturday 9pm</button>
                            <button onclick = "updateMovieDetails('AHF', 'SUN', '21'); isFullOrDiscount('SUN','21')" class = 'button'> Sunday 9pm</button>
                            </a>

                        </div>
                </div>
            </div>          
        </div>  
      
       <!-- The Girl In The Spider's Web Modal -->
      <div id="Modal_ACT" class="modal" style = overflow: auto;>

            <!-- Modal content -->
            <div class="modal-content" >
            <h3 style = 'margin-top: 0px;'> The Girl In The Spider's Web<span class="close" onclick = "closeModal('ACT');">&times;</span></h3>
                
                <div>
                    <div class='panel'>
                        <div class='synopsis'>
                            <br>
                            <p>Lisbeth Salander, the cult figure and title character of the acclaimed Millennium book series created by Stieg Larsson, will return to the screen in The Girl in the Spider's Web, a first-time adaptation of the recent global bestseller. Claire Foy (Breathe, The Crown) will take on the iconic role. </p>
                            <p>Director: Fede Alvarez </p>
                            <p>Main Cast: Claire Foy, Sverrir Gudnason, Claes Bang, Sylvia Hoeks, Cameron Britton</p>
                            <p>Classification: MA15+ (Strong themes and violence)</p>
                            <p>Genre: Crime, Drama </p>
                            <p>Release Date: Thursday, 8 November 2018 </p>
                            <p>Running Time: 115 Mins </p>
                        </div>

                        <div class='trailer'>
                            <video width='500' controls>
                                <source src='../../media/THEGIRLINTHESPIDERSWEBTrailer.mp4' type='video/mp4'>
                                <source src='../../media/THEGIRLINTHESPIDERSWEBTrailer.ogg' type='video/ogg'>Your browser does not support HTML5 video
                            </video>
                        </div>
                    </div>
                

                        <div style = 'text-align:center'; padding-bottom: 20px;>
                            
                            <h3 style = 'margin-top: 0px;'> Make a Booking:</h3>

                            <a href='#booking'>
                            <button onclick = "updateMovieDetails('ACT', 'WED', '21'); isFullOrDiscount('WED','21')" class = 'button' > Wednesday 9pm</button>
                            <button onclick = "updateMovieDetails('ACT', 'THU', '21'); isFullOrDiscount('THU','21')" class = 'button'> Thursday 9pm</button>
                            <button onclick = "updateMovieDetails('ACT', 'FRI', '21'); isFullOrDiscount('FRI','21')" class = 'button'> Friday 9pm</button>
                            <button onclick = "updateMovieDetails('ACT', 'SAT', '18'); isFullOrDiscount('SAT','18')" class = 'button'> Saturday 6pm</button>
                            <button onclick = "updateMovieDetails('ACT', 'SUN', '18'); isFullOrDiscount('SUN','18')" class = 'button'> Sunday 6pm</button>
                            </a>

                        </div>
                </div>
            </div>          
        </div>  
      
      
     <!-- A Star Is Born Modal -->
      <div id="Modal_RMC" class="modal" style = overflow: auto;>

            <!-- Modal content -->
            <div class="modal-content" >
            <h3 style = 'margin-top: 0px;'> A Star Is Born<span class="close" onclick = "closeModal('RMC');">&times;</span></h3>
                
                <div>
                    <div class='panel'>
                        <div class='synopsis'>
                            <br>
                           
                            <p>Jackson Maine, a country music star on the brink of decline, discovers a talented unknown named Ally. As the two begin a passionate love affair, Jackson coaxes Ally into the spotlight, catapulting her to stardom. But as Ally's career quickly eclipses his own, Jack finds it increasingly hard to handle his fading glory.</p>
                            <p>Director: Bradley Cooper </p>
                            <p>Main Cast: Bradley Cooper, Dave Chappelle, Sam Elliott, Lady Gaga, Andrew Dice Clay, Anthony Ramos, Bonnie Somerville</p>
                            <p>Classification: M (Mature themes, coarse language, drug use and sex scenes)</p>
                            <p>Genre: Musical </p>
                            <p>Release Date: Thursday, 18 October 2018</p>
                            <p>Running Time: 136 Mins </p>
                        </div>

                        <div class='trailer'>
                            <video width='500' controls>
                                <source src='../../media/ASTARISBORNTrailer.mp4' type='video/mp4'>
                                <source src='../../media/ASTARISBORNTrailer.ogg' type='video/ogg'>Your browser does not support HTML5 video
                            </video>
                        </div>
                    </div>
                

                        <div style = 'text-align:center'; padding-bottom: 20px;>
                            
                            <h3 style = 'margin-top: 0px;'> Make a Booking:</h3>

                            <a href='#booking'>
                            <button onclick = "updateMovieDetails('RMC', 'MON', '18'); isFullOrDiscount('MON','18')" class = 'button' > Monday 6pm</button>
                            <button onclick = "updateMovieDetails('RMC', 'TUE', '18'); isFullOrDiscount('TUE','18')" class = 'button'> Tuesday 6pm</button>
                            <button onclick = "updateMovieDetails('RMC', 'SAT', '15'); isFullOrDiscount('SAT','15')" class = 'button'> Saturday 3pm</button>
                            <button onclick = "updateMovieDetails('RMC', 'SUN', '15'); isFullOrDiscount('SUN','15')" class = 'button'> Sunday 3pm</button>
                            </a>

                        </div>
                </div>
            </div>          
        </div> 
      
      
    <header>
      <div class = title>
            <h1 style='color:navy;'>LUNARDO CINEMA</h1>
            <p>
                <img src='../../media/A2 Logo2.png' width='250' alt='company logo' />
            </p>
        </div>
    </header>

      
    <nav>
        <a href='#about_us' class = 'active'>About Us</a>
        <a href='#seats_and_prices'>Seats and Prices</a>
        <a href='#now_showing'>Now Showing</a>
        <a href='#booking'>Booking</a>
    </nav>

      
    <main>
      <article id = about_us>
            <div id='section-style'>
                <h2>About Us</h2>
                <p> <strong>Lunardo Cinema has reopened after MONTHS of extensive improvements and renovations! </strong></p>
                <p> <strong>We have INCREDIBLE new standard seats and reclinable first class seats! </strong></p>
                <p> <strong>The projection and sound systems are upgraded with 3D Dolby Vision projection and Dolby Atmos sound: </strong></p>
                <p><i>Dolby sound fills the Cinema with BREATHTAKING sound </i></p>
                <p><i>The sound comes from ALL directions, including overhead, to FILL the cinema with astonishing clarity, richness, detail, and depth</i></p>
                <p><i>Dolby Vision HDR brings extraordinary color, contrast, and brightness to the screen, transforming your viewing experience!</i></p>
            </div>
        </article>

        <article id= seats_and_prices>
            <div id='section-style'>
                <h2 >Seats and Prices</h2>
                <div class='seat-images'>
                    <img src='../../media/standard seat.png' alt='standard seat' class='image-resize'>
                </div>
                <h3 style='text-align:center;'>Standard seat</h3>
                <div class='seat-images'>
                    <img src='../../media/First class seating.png' class='image-resize' alt='first class seat' />
                </div>
                <h3 style='text-align:center;'>First class seat</h3>

                <div style='overflow-x:auto;'>
                    <table>
                        <p style="text-align:center;">The Cinema offers discounted pricing weekday afternoons (ie weekday matinée sessions) and all day on Mondays and Wednesdays. </p>
                        <thead>
                            <tr>
                                <th>SEAT TYPE</th>
                                <th>All day Monday and Wednesday <br> AND 12pm on Weekdays</th>
                                <th>All other times</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th>Standard Adult</th>
                                <td>$14.00</td>
                                <td>$19.80</td>
                            </tr>
                            <tr>
                                <th>Standard Concession</th>
                                <td>$12.50</td>
                                <td>$17.50</td>
                            </tr>
                            <tr>
                                <th>Standard Child</th>
                                <td>$11.00</td>
                                <td>$15.30</td>
                            </tr>
                            <tr>
                                <th>First Class Adult</th>
                                <td>$24.00</td>
                                <td>$30.00</td>
                            </tr>
                            <tr>
                                <th>First Class Concession</th>
                                <td>$22.50</td>
                                <td>$27.00</td>
                            </tr>
                            <tr>
                                <th>First Class Child</th>
                                <td>$21.00</td>
                                <td>$24.00</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </article>

        <article id=now_showing>
            <div id='section-style' style="text-align: center;">
                <h2>Now Showing</h2>
                
                    <!-- Trigger/Open The Modal -->
                <div id = "myBtn" class='movie-panel'>
                    
                    <img src='../../media/RalphBreaksTheInternet.png' width='125' alt='ralph' />
                    <h3>Ralph Breaks The Internet PG</h3>
                    <p> Monday 12pm</p>
                    <p> Tuesday 12pm</p>
                    <p> Wednesday 6pm</p>
                    <p> Thursday 6pm</p>
                    <p> Friday 6pm</p>
                    <p> Saturday 12pm</p>
                    <p> Sunday 12pm</p>
                </div>
       
                <!-- Trigger/Open The Modal -->
                <div id = "myBtn2" class='movie-panel'>
                    
                    <img src='../../media/BoyErased.png' width='125' alt='boy erased' />
                    <h3>Boy Erased MA15+</h3>
                    
                    <p> Wednesday 12pm</p>
                    <p> Thursday 12pm</p>
                    <p> Friday 12pm</p>
                    <p> Saturday 9pm</p>
                    <p> Sunday 12pm</p>  
                </div>
               
                <!-- Trigger/Open The Modal -->
                <div id = "myBtn3" class='movie-panel'> 
                
                
                    <img src='../../media/TheGirlInTheSpidersWeb.png' width='125' alt='spiders web' />
                    <h3>The Girl In The Spider's Web MA15+</h3>
                    <p> Wednesday 9pm</p>
                    <p> Thursday 9pm</p>
                    <p> Friday 9pm</p>
                    <p> Saturday 6pm</p>
                    <p> Sunday 6pm</p>
                </div>
                
                 <!-- Trigger/Open The Modal -->
                <div id = "myBtn4" class='movie-panel'> 
                
                    <img src='../../media/AStarIsBorn.png' width='125' alt='star is born' />
                    <h3>A Star Is Born M</h3>
                    <p> Monday 6pm</p>
                    <p> Tuesday 6pm</p>
                    <p> Saturday 3pm</p>
                    <p> Sunday 3pm</p>
                </div>

                <div style='overflow-x:auto;'>
                    <table>
                        <thead>
                            <tr>
                                <th>MOVIE TITLE</th>
                                <th>Mon - Tue</th>
                                <th>Wed - Fri</th>
                                <th>Sat - Sun</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th>Boy Erased</th>
                                <td>-</td>
                                <td>9pm</td>
                                <td>6pm</td>
                            </tr>
                            <tr>
                                <th>A Star Is Born</th>
                                <td>6pm</td>
                                <td>-</td>
                                <td>3pm</td>
                            </tr>
                            <tr>
                                <th>Ralph Breaks The Internet</th>
                                <td>12pm</td>
                                <td>6pm</td>
                                <td>12pm</td>
                            </tr>
                            <tr>
                                <th>The Girl In The Spider's Web</th>
                                <td>-</td>
                                <td>12pm</td>
                                <td>9pm</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </article> 
       
      
      

        <article id=booking>
            <div id='section-style'>
                <h2 >Booking</h2>
                <h3>Boy Erased </h3> 
                <h3>Wednesday 12pm</h3>

                <form action='index.php' method='post' enctype="application/x-www-form-urlencoded">

                    <input type = 'hidden' name = 'movie[id]' id = "movie_id" value = '' />
                    <input type='hidden' name='movie[hour]' id = "movie_hour" value='' />
                    <input type='hidden' name='movie[day]' id = "movie_day" value='' />
                    
                    <fieldset >
                        <legend style = "font-family: 'Domine', serif;" >Standard</legend>
                       
                        <p>Adults</p> 
      
                        <select name='seats[STA]' id = 'seats_STA' onchange = "calculatePrice()">
                            <option value="" selected>Please Select</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value='3'>3</option>
                            <option value='4'>4</option>
                            <option value='5'>5</option>
                            <option value='6'>6</option>
                            <option value='7'>7</option>
                            <option value='8'>8</option>
                            <option value='9'>9</option>
                            <option value='10'>10</option>
                        </select>

                        <p>Concession</p>
                        <select name='seats[STP]' id = 'seats_STP' onchange = "calculatePrice()">
                            <option value="" selected>Please Select</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value='3'>3</option>
                            <option value='4'>4</option>
                            <option value='5'>5</option>
                            <option value='6'>6</option>
                            <option value='7'>7</option>
                            <option value='8'>8</option>
                            <option value='9'>9</option>
                            <option value='10'>10</option>
                        </select>
                        
                        <p>Children</p>
                        <select name='seats[STC]' id = 'seats_STC' onchange = "calculatePrice()">
                            <option value="" selected>Please Select</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value='3'>3</option>
                            <option value='4'>4</option>
                            <option value='5'>5</option>
                            <option value='6'>6</option>
                            <option value='7'>7</option>
                            <option value='8'>8</option>
                            <option value='9'>9</option>
                            <option value='10'>10</option>
                        </select>
                        
                    </fieldset>

                    <fieldset style = 'margin-top :10px;'>
                        
                        <legend style = "font-family: 'Domine', serif;" >First Class</legend>

                        <p>Adults</p>
                        <select name='seats[FCA]' id = 'seats_FCA' onchange = "calculatePrice()">
                            <option value="" selected>Please Select</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value='3'>3</option>
                            <option value='4'>4</option>
                            <option value='5'>5</option>
                            <option value='6'>6</option>
                            <option value='7'>7</option>
                            <option value='8'>8</option>
                            <option value='9'>9</option>
                            <option value='10'>10</option>
                        </select>

                        <p>Concession</p>
                        <select name='seats[FCP]' id = 'seats_FCP' onchange = "calculatePrice()">
                            <option value="" selected>Please Select</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value='3'>3</option>
                            <option value='4'>4</option>
                            <option value='5'>5</option>
                            <option value='6'>6</option>
                            <option value='7'>7</option>
                            <option value='8'>8</option>
                            <option value='9'>9</option>
                            <option value='10'>10</option>
                        </select>

                        <p>Children</p>
                        <select name='seats[FCC]' id = 'seats_FCC' onchange = "calculatePrice()">
                            <option value="" selected>Please Select</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value='3'>3</option>
                            <option value='4'>4</option>
                            <option value='5'>5</option>
                            <option value='6'>6</option>
                            <option value='7'>7</option>
                            <option value='8'>8</option>
                            <option value='9'>9</option>
                            <option value='10'>10</option>
                        </select>
                    </fieldset>
                    
                    <p>
                        <label for='name'>Name</label><br><br>
                        <input type='text' id='name' name='cust[name]' value='' required pattern = "[a-zA-Z \-.']{1,100}"/><?php echo $nameError;?>
                    </p>
                    <p>
                        <label for='email'>Email</label><br><br>
                        <input type='email' id='email' name='cust[email]' value=' ' required/><?php echo $emailError;?>
                    </p>
                    <p>
                        <label for='mobile'>Mobile</label><br><br>
                        <input type='tel' id='mobile' name='cust[mobile]' value='' required pattern  ='(\(04\)|04|\+614)( ?\d){8}'/><?php echo $mobileError;?>
                    </p>
                    <p>
                        <label for='credit card'>Credit Card</label><br><br>
                        <input type='text' id='credit card' name='cust[card]' value='' required pattern ='^( ?\d){16}$'/><?php echo $cardError;?>
                    </p>
                    <p>
                        <label for='expiry'>Expiry</label><br><br>
                        <input type='date' id='expiry' name='cust[expiry]' value='' required min='2019-03-15'/><?php echo $expiryError;?>
                    </p>

                    <p>Total $ <span id = price></span></p>

                    <input type='submit' name='order' value='Order' style = "font-family: 'Domine', serif;'"><?php echo $seatsError;?><?php echo $movieError;?>
                </form>
            </div>
        </article>
    </main>

    <footer>
      <div>&copy;<script>
        document.write(new Date().getFullYear());
      </script> 
          
          <p><strong><em>Lunardo Cinema 126 High St. Prahran 3181 Phone:9384&nbsp;3361 Email:enquiries@lunardocinema.com</em></strong>
            </p>
            <i>Finella Michael s3666910,
                <a href ='https://github.com/FinellaM/wp'>https://github.com/FinellaM/wp,</a></i> Last modified
            <?= date ("Y F d  H:i", filemtime($_SERVER['SCRIPT_FILENAME'])); ?>.
            <p><a href ='../../wp/a3/References.txt'>Link to References</a></p>
        </div>
        <div>Disclaimer: This website is not a real website and is being developed as part of a School of Science Web Programming course at RMIT University in Melbourne, Australia.</div>
      <div>Maintain links to your <a href='products.txt'>products spreadsheet</a> and <a href='orders.txt'>orders spreadsheet</a> here. <button id='toggleWireframeCSS' onclick='toggleWireframe()'>Toggle Wireframe CSS</button></div>   
    </footer>
      
      <?php 
      
      echo 'POST';
      preShow($_POST);
     
      echo 'SESSION(shopping cart)';
      preShow($_SESSION); 
      
      echo 'GET';
      preShow($_GET);

      echo 'PRINT MY CODE';
      printMyCode();
      
      ?>
      
  </body>
</html>
