function updateMovieDetails(movie_id, movie_day, movie_hour) 
{
    document.getElementById('movie_id').value = movie_id;
                    
    document.getElementById('movie_hour').value = movie_hour;
        
    document.getElementById('movie_day').value = movie_day;
                    
}

window.onscroll = function ()
{
    let navlinks = document.getElementsByTagName("nav")[0].children;
    let articles = document.getElementsByTagName("main")[0].children;
    last = articles[articles.length - 1].getBoundingClientRect().top;
    if (last <= 300)
    {
        navlinks[navlinks.length - 1].classList.add("active");
        for (j = 0; j < navlinks.length - 1; j++)
        navlinks[j].classList.remove("active");
    }
        else
    {
        navlinks[articles.length - 1].classList.remove("active");
        for (i = 1; i < articles.length; i++)
        {
            prev = articles[i - 1].getBoundingClientRect().top;
            next = articles[i].getBoundingClientRect().top;
            log = prev + ' ' + next;
            if (prev <= 300 && next > 300)
            {
                navlinks[i - 1].classList.add("active");
            }
            else
            {
                navlinks[i-1].classList.remove("active");
            }
        }
    }
}


// Get the modal
var modal = document.getElementById('Modal_ANM');
var modal2 = document.getElementById('Modal_AHF');
var modal3 = document.getElementById('Modal_ACT');
var modal4 = document.getElementById('Modal_RMC');

// Get the button that opens the modal
var btn = document.getElementById("myBtn");
var btn2 = document.getElementById("myBtn2");
var btn3 = document.getElementById("myBtn3");
var btn4 = document.getElementById("myBtn4");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 
btn.onclick = function() {
  modal.style.display = "block";
}
btn2.onclick = function() {
  modal2.style.display = "block";
}
btn3.onclick = function() {
  modal3.style.display = "block";
}
btn4.onclick = function() {
  modal4.style.display = "block";
}


function closeModal(movie_id) {
  document.getElementById('Modal_'+movie_id).style.display = "none";
}


// checks if sessions are discounted
var discount;
function isFullOrDiscount(movie_day, movie_hour) 
{
  if (movie_day == 'MON' ||movie_day == 'WED'  || (movie_day != 'SAT' && movie_day != 'SUN' && movie_hour == 12))
  {
      discount = true;
  }
  else 
  {
      discount = false;
  }
}


// calculates seat price totals
function calculatePrice() 
{
      salePrice = 0;
        
      // check input for all six seat types
	  var numSeats = parseInt(document.getElementById('seats_STA').value);
      if (isNaN(numSeats)) 
      {
      }
      else
      {
          if (discount == true) // check output of isFullOrDiscount(movie_day, movie_hour) 
          {
            salePrice = seatPrices['DISC']['STA'] * numSeats;
            document.getElementById('price').innerHTML = salePrice.toFixed(2);
          }
          else
          {
            salePrice = seatPrices['FULL']['STA'] * numSeats;
            document.getElementById('price').innerHTML = salePrice.toFixed(2);
          }
      }
      
      var numSeats2 = parseInt(document.getElementById('seats_STP').value);
      if (isNaN(numSeats2))
      {
      }
      else
          if (discount == true)  
          {
            salePrice += seatPrices['DISC']['STP'] * numSeats2;
            document.getElementById('price').innerHTML = salePrice.toFixed(2);
          }
          else
          {
            salePrice += seatPrices['FULL']['STP'] * numSeats2;
            document.getElementById('price').innerHTML = salePrice.toFixed(2);
          }
        
      var numSeats3 = parseInt(document.getElementById('seats_STC').value);
      if (isNaN(numSeats3))
      {
      }
      else
          if (discount == true)  
          {
            salePrice += seatPrices['DISC']['STC'] * numSeats3;
            document.getElementById('price').innerHTML = salePrice.toFixed(2);
          }
          else
          {
            salePrice += seatPrices['FULL']['STC'] * numSeats3;
            document.getElementById('price').innerHTML = salePrice.toFixed(2);
          }
       
      var numSeats4 = parseInt(document.getElementById('seats_FCA').value);
      if (isNaN(numSeats4))
      {
      }
      else
          if (discount == true)  
          {
            salePrice += seatPrices['DISC']['FCA'] * numSeats4;
            document.getElementById('price').innerHTML = salePrice.toFixed(2);
          }
          else
          {
            salePrice += seatPrices['FULL']['FCA'] * numSeats4;
            document.getElementById('price').innerHTML = salePrice.toFixed(2);
          } 
        
      var numSeats5 = parseInt(document.getElementById('seats_FCP').value);
      if (isNaN(numSeats5))
      {
      }
      else
          if (discount == true)  
          {
            salePrice += seatPrices['DISC']['FCP'] * numSeats5;
            document.getElementById('price').innerHTML = salePrice.toFixed(2);
          }
          else
          {
            salePrice += seatPrices['FULL']['FCP'] * numSeats5;
            document.getElementById('price').innerHTML = salePrice.toFixed(2);
          }  
        
      var numSeats6 = parseInt(document.getElementById('seats_FCC').value);
      if (isNaN(numSeats6))
      {
      }
      else
          if (discount == true)  
          {
            salePrice += seatPrices['DISC']['FCC'] * numSeats6;
            document.getElementById('price').innerHTML = salePrice.toFixed(2);
          }
          else
          {
            salePrice += seatPrices['FULL']['FCC'] * numSeats6;
            document.getElementById('price').innerHTML = salePrice.toFixed(2);
          } 
        
}



    
      

