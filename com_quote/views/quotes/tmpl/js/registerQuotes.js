var RegisterQuotes = (function () {

  var captchavalue;

	function captcha(){
    var copia = $("#txtcopia").val();
    if(copia == captchavalue){
    	return true;
    } else {
      return false;
    }
  }

  function getCAPTCHA(){

    $.get("../../../components/com_quote/helpers/CAPTCHA.php", function( data ) {
			
      captchavalue = data;
			makeCAPTCHA(data);
		
    });
  }

  function makeCAPTCHA(code){

		var c=document.getElementById("myCanvas");
		var ctx=c.getContext("2d");

		ctx.font="12px Georgia";
		ctx.fillText("Captcha:",5,20);
		ctx.font="16px Verdana";
		var gradient=ctx.createLinearGradient(0,0,c.width,0);
		gradient.addColorStop("0","magenta");
		gradient.addColorStop("0.5","orange");
		gradient.addColorStop("1.0","red");
		ctx.fillStyle=gradient;
		ctx.fillText(code,40,55);
  }
	
	function validate(){

		captcha() ?  AJAXRegQuot() : alert(" please, insert a correct Captcha");
	}

	function reset_form(){

		$('#name_RegOrder').val("");
		$('#email_RegOrder').val("");
		$('#phone_RegOrder').val("");
		$('#model_RegOrder').val("");
		$('#serial_RegOrder').val("");
		$('#description_RegOrder').val("");
	
  }

	function AJAXRegQuot(){

		var a = $('#name_RegOrder').val();
		var b = $('#email_RegOrder').val();
		var c = $('#phone_RegOrder').val();
		var d = $('#model_RegOrder').val();
		var f = $('#brand_RegOrder').val();
		var g = $('#serial_RegOrder').val();
		var h = $('#description_RegOrder').val();
		

    // Register Quote by Description
    $.ajax({
      url: '../../../components/com_quote/helpers/ctrlquoteDescription.php',
      type: 'POST',
      data: { 

        name:        a,
        email:       b,
        phone:       c,
        model:       d,
        brand:       f,
        serial:      g,
        description: h

      },
      // dataType: 'json',
      beforeSend: function(){
        $('#loading').show();
      },
      success: function (data) {
        console.log("cool...");
      }
    });

	}

  function getManufacturer() {

    $.get("../../../components/com_quote/helpers/getManufacturer.php", function( data ) {

      $("#brand_RegOrder").append(data);

    });

  }

	function init() {
		
    $('#btn-reset').on('click', reset_form);
		
    $('#btn-RegOrder').on('click', validate);

    getManufacturer();
	}

	return {
    init: init,
    initCaptcha: getCAPTCHA
  }

})();