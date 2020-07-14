<?php
session_start();

// Put your PHP functions and modules here

error_reporting( E_ERROR | E_WARNING | E_PARSE );

$movieObject =
[
    "AHF" => "Boy Erased",
    "ACT" => "The Girl in the Spider's Web",
    "ANM" => "Ralph Breaks the Internet",
    "RMC" => "A Star is Born",
];

$hourObject =
[
    "12" => "12pm",
    "18" => "6pm",
    "15" => "3pm",
    "21" => "9pm",
];

$seatObject = 
[
    "STA" => "Standard Adult",
    "STP" => "Standard Concession",
    "STC" => "Standard Child",
    "FCA" => "First Class Adult",
    "FCP" => "First Class Concession",
    "FCC" => "First Class Child",
];

$dayObject =
[
    "MON" => "Monday",
    "TUE" => "Tuesday",
    "WED" => "Wednesday",
    "THU" => "Thursday",
    "FRI" => "Friday",
    "SAT" => "Saturday",
    "SUN" => "Sunday",
];

$seatPrices = 
[
  "DISC" => 
  [
    "STA" => 14,
    "STP" => 12.5,
    "STC" => 11,
    "FCA" => 24,
    "FCP" => 22.5,
    "FCC" => 21,
  ],
    
  "FULL" => 
  [
    "STA" => 19.8,
    "STP" => 17.5,
    "STC" => 15.3,
    "FCA" => 30,
    "FCP" => 27,
    "FCC" => 24,
  ],
];

$moviesObject = 
[
   'ACT' =>
    [
        'title' => "The Girl in the Spider's Web",
        'rating' => 'MA15+',
        'description' => '<p>TBA/p>',
        'screenings' => 
        [
            'WED' => 21,
            'THU' => 21,
            'FRI' => 21,
            'SAT' => 18,
            'SUN' => 18,
        ]
    ],

    'RMC' =>
    [
        'title' =>  "A Star is Born",
        'rating' => 'M',
        'description' => '<p>TBA/p>',
        'screenings' => 
        [
            'MON' => 18,
            'TUE' => 18,
            'SAT' => 15,
            'SUN' => 15,
        ]
    ],

    'ANM' =>
    [
        'title' =>  "Ralph Breaks the Internet",
        'rating' => 'PG',
        'description' => '<p>TBA/p>',
        'screenings' => 
        [
            'MON' => 12,
            'TUE' => 12,
            'WED' => 18,
            'THU' => 18,
            'FRI' => 18,
            'SAT' => 12,
            'SUN' => 12,
        ]
    ],

    'AHF' =>
    [
        'title' =>  "Boy Erased",
        'rating' => 'MA15+',
        'description' => '<p>TBA/p>',
        'screenings' => 
        [
            'WED' => 12,
            'THU' => 12,
            'FRI' => 12,
            'SAT' => 21,
            'SUN' => 12,
        ]
    ]
];

$screeningsObject =
[
    'movie' => 'Boy Erased',
    'day' => 'WED',
    'time' => 12,
    'seats' =>
    [
         "STA" => 'TBC',
         "STP" => '',
         "STC" => '',
         "FCA" => '',
         "FCP" => '',
         "FCC" => '',
    ],
    'price' => ''  
];

// "preShow()" function prints data and shape/structure of data:
function preShow($arr, $returnAsString=false ) {
  $ret  = '<pre>' . print_r($arr, true) . '</pre>';
  if ($returnAsString)
    return $ret;
  else 
    echo $ret; 
}

// Output your current file's source code:
function printMyCode() {
  $lines = file($_SERVER['SCRIPT_FILENAME']);
  echo "<pre class='mycode'><ol>";
  foreach ($lines as $line)
     echo '<li>'.rtrim(htmlentities($line)).'</li>';
  echo '</ol></pre>';
}

// A "php associative array to javascript object" function
// NOTE: Handles multidimensional arrays and objects
function php2js( $arr, $pricesArrayPHP ) {
  $lineEnd="";
  echo "<script>\n";
  echo "  var $pricesArrayPHP = ".json_encode($arr, JSON_PRETTY_PRINT);
  echo "</script>\n\n";
}

/*function styleCurrentNavLink( $css ) {
  $here = $_SERVER['SCRIPT_NAME']; 
  $bits = explode('/',$here); 
  $filename = $bits[count($bits)-1]; 
  echo "<style>nav a[href$='$filename'] { $css }</style>";
}*/

?>