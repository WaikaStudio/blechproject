//initialization
$(document).ready(function() {
  
  $('#colorbox').show();
  $(".container3").hide();
  
  function quoteR () {
    $(".container1").show();
    $(".container2").hide();
    $(".container3").hide();
  }
 
  function quoteS () {
    $(".container1").hide();
    $(".container2").show();
    $(".container3").hide();
  }

  function quoteT () {
    $(".container1").hide();
    $(".container2").hide();
    $(".container3").show();
  }
 
  $("#quote2").on('click', quoteStatus.getQ);
  $("#quote1").on('click', quoteR);
  $("#quote2").on('click', quoteS);
  $("#quote3").on('click', quoteT);

  quoteStatus.init();
  quoteOrder.init();

  quoteStatus.getQ();
  quoteOrder.getM();
  
  RegisterQuotes.initCaptcha();
  RegisterQuotes.init();

});
