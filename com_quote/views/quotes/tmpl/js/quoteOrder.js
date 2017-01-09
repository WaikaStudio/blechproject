// IIFE
var quoteOrder = (function () {

  var n_item = 0;
  var part_number = "";
  var part_quantity = 0;
  var product_id = 0;
  var price = 0;
  var toBuy = false;

  var selectManufacturer = "";

  var i = 0;
  var ii = 0;

  var datosForm = [];
  var data = [];

  var id = 0;

  function addRows (e) {
    e.preventDefault();

    n_item = i + 1;
    part_number = $("#part").val();
    part_quantity = parseInt($("#qnty").val());
    selectManufacturer = $("#selectManufacturer").val();

    //Validations
    // if input brand or part number and quantity empty
    if( messageValidate() )
      return true;
    
    // ? product has already been added
    if(datosForm.length === 0 || !productExists()) {
      //modify view
      addItems();
      //modify data
      data = [ n_item,
               part_number, 
               part_quantity,
               product_id,
               price,
               true,
               selectManufacturer,
               toBuy ];

      datosForm[i] = data;
      i++;
      ii++;
      //show send button
      ii === 1 ? $('.btnSend').show():true;
      
      //AJAX calls to get Product Data from the server
      getProduct(part_number);
      getDocument(part_number);
    }

  }

  function productExists () {
    //Validate if already exists product in data
    //if exists return item otherwise return array []
    var item = datosForm.filter(productAlreadyAdd.bind(this, part_number));
    if(item.length > 0) { 
      var id = item[0][0]; 
    } else { 
      var id = 0;
    }

    if(item.length === 0 ){
      return false;
    }
    else if(item[0][5] === true) {

      style = { "background-color": "#ffe", 
                "border-left": "5px solid #ccc",
                "outline": "10"
            };

      
      //Modify Data
      var v = parseInt($("#qnty").val());
      datosForm[id-1][2] += v;
      //Modify View
      $(`#pq${ id }`).val(datosForm[id-1][2]);

      $(`#${ id }`).css(style).attr('tabindex',-1).focus();
      
      return true;
    }
    else if(item[0][5] === false) {

      //Modify Data
      v = parseInt($("#qnty").val());
      datosForm[id-1][2] = v;

      //change false to true in datosForm
      datosForm[id-1][5] = true;

      //Modify View
      //change item value in view
      $(`#pq${ id }`).val(datosForm[id-1][2]);
      
      //show item again
      $(`#${id}`).show();

      //Delete Control Add Again
      ii++;
      
      return true;
    }
  }

  function addItems() {
    //Show table
    $("#PTable").show();

    var dF = $(document.createDocumentFragment());

    var tr  = $(`<tr id="${ n_item }">`);
    var tda = $(`<td class="center-align id">${ n_item }</td>`);       //item number
    var tdb = $(`<td class="center-align brand${ n_item } ">${ selectManufacturer }</td>`);    //brand
    var tdn = $(`<td class="center-align">${ part_number }</td>`);             //part number
    var tdq = $(`<td class="center-align"></td>`); //part quantity
    var tdp = $(`<td class="center-align price${ n_item }"></td>`);    //price
    var tdi = $(`<td class="center-align x image${ n_item }"></td>`);    //image
    var tdd = $(`<td class="center-align x document${ n_item }"></td>`); //document
    var tdc = $(`<td class="center-align x check${ n_item }"></td>`);    //check
    var tdbutton = $('<td class="x">');
    
    var button = $('<button class="btnDeleteRow button-error btn-small">x</button>');
    var check = $('<input class="addToCart" type="checkbox">');

    var b = $(`<input type="number" min="1" id="pq${ n_item }" class="pq M" style="height:30px;width:55px;" value="${ part_quantity }">`);
    
    var div = $('<div class="centered">');

    tdbutton.append(button);
    tdc.append(check);

    dF.append(tr
      .append(tda)
      .append(tdb)
      .append(tdn)
      .append(tdq.append(b))
      .append(tdp)
      .append(tdi)
      .append(tdd)
      .append(tdc)
      .append(tdbutton));

    $('#TBody').append(dF);

    //reset of inputs
    $("#part").val("");
    $("#qnty").val("");
  }


  function messageValidate(m) {
    //message validation control

    var m = $("#selectManufacturer").find("option:selected").val();

    if(m === "no") {
      $('#mSb').fadeIn(() => $(this).show());
      return true;
    }
    else {
      $('#mSb').hide();
    }

    if(part_number === "" || part_quantity === "") {
      $('#mSp').fadeIn(() => $(this).show());
      return true;
    }
    else {
      $('#mSp').hide();
    }
  }

  function deleteRows () {

    $(this).parent().parent().fadeOut('slow', () => {

      id = $(this).parent().siblings(".id").html();
      //delete in data
      deleteRowId(id);
      ii -= 1;
      if(ii === 0) {
        datosForm = [];
        $("#PTable").hide();
        $('.btnSend').hide();
      }
      $(`#${id}`).hide().addClass('x');
    
    });
  }

  function deleteRowId (id) {
    var ids = parseInt(id);
    datosForm[ids-1][5] = false;
  }
  
  function sendForm () {
    //data to be send
    var id = $("#uid").val();
    var datos = datosForm.filter(datosIsTrue);
    // var brandId   = $("#selectManufacturer").find("option:selected").data("brandid");
    // var brandName = $("#selectManufacturer").find("option:selected").data("brandname");
    
    if(datos.length === 0) {
      return true;
    }
    
    $.ajax({
      url: '../../../components/com_quote/helpers/ctrlquote.php',
      type: 'POST',
      data: { id: id,
        datos: datos },
      dataType: 'json',
      beforeSend: function(){
        $('#loading').show();
      },
      success: function (data) {
        if (!data.error) {

          $('#loading').hide();
          $('.btnSend').hide();
          $('#successMessage').show().html(data.mess_submit);
          
          var itemsQuote = $('.sendTableMail').html();

          //let's make a copy of table for being modified!

          $('.copyTable').append(itemsQuote);

          $('.copyTable .x').remove();

          var quoteData = $('.copyTable').html().toString();

          sendMail('sendMailA', data.quoteid, quoteData);
          sendMail('sendMailC', data.quoteid, quoteData);

        }
      }
    });
  }

  function sendMail(user, quoteid, quoteData) {

    var userName = $("#uname").val();
    var userEmail = $("#umail").val();

    var OEMParts = $("#oem").val();
    
    $.ajax({
      url: `../../../components/com_quote/helpers/${ user }.php`,
      type: 'POST',
      data: { quoteid: quoteid,
              userName: userName,
              userEmail: userEmail,
              userItems: quoteData,
              OEMParts: OEMParts },
      success: function (data) {
        if (!data.error) {

          $('#successMessageMail').html("Mail Has Been Send!");
        }
      }
    });

  }


  function getManufacturer() {

    $.get("../../../components/com_quote/helpers/getManufacturer.php", function( data ) {

      $("#selectManufacturer").append(data);

    });

  }

  function getProduct(id) {

    var productCode = id;

    $.ajax({
      url: '../../../components/com_quote/helpers/getProduct.php',
      type: 'POST',
      data: { productCode: productCode },
      dataType: 'json',
      success: function (data) {
        if (data.length !== 0) {
          //llevar control del id de producto y precio en data
          var price_value = data.price_value;
          price_value = parseInt(price_value);

          datosForm[i-1][3] = data.product_id || 0;
          datosForm[i-1][4] = price_value.toFixed(2) || 0;

          $(`.price${n_item}`).html(price_value.toFixed(2));
          
          //Small modal
          var dFm = $(document.createDocumentFragment());
          
          var modal = $(`<img class="myImg" id="myImg" src="../../../media/com_hikashop/upload/${ data.file_path }" alt="Image" width="40" height="30">`);
          
          dFm.append(modal);

          $(`.image${ n_item }`).append(dFm);
        }
        else {
          $(`.price${n_item}`).html('--');
          $(`.image${n_item}`).html('--');
          $(`.check${n_item}`).html('--');
        }
      }
    });
  }

  function getDocument(id) {

    var productCode = id;

    $.ajax({
      url: '../../../components/com_quote/helpers/getDocument.php',
      type: 'POST',
      data: { productCode: productCode },
      dataType: 'json',
      success: function (data) {
        if (data.length !== 0) {

          var dFdoc = $(document.createDocumentFragment());

          var pdf = $(`<a target="_blank" href="../../../media/com_hikashop/upload/safe/${data.file_path}">PDF</a>`);

          dFdoc.append(pdf);

          $(`.document${ n_item }`).append(dFdoc);
        }
        else {
          $(`.document${ n_item }`).html('--');
        }
      }
    });
  }


  function showModal (){

    $('#myModal').show();

    var src = $(this).attr("src");

    $("#img01").attr({src: src});
  }

  function closeModal () { 
    
    $("#myModal").hide();

  }

  function comprar() {

    id = $(this).parent().siblings(".id").html();

    if (this.checked) {
      datosForm[id-1][7] = true;
    } else {
      datosForm[id-1][7] = false;
    }

    var nCheck = $('input[type=checkbox]:checked').length;

    if(nCheck > 0) {
      $(".btnToBuy").show();
    }
    else if(nCheck === 0) {
      $(".btnToBuy").hide();
    }

    // if($('input[type=checkbox]:checked').length) { … }
  }

  function  addCartItems () {
    var d = datosForm;
    for (var i = 0; i < d.length; i++) {
    // validar if true toBuy
      if(d[i][7]){
        updateCart(d[i][3],d[i][2]);
      }
    }
    // location.reload();
  }

  function updateCart(a, b) {

    $.ajax({
      url: 'index.php/us/parts/product/updatecart',
      type: 'POST',
      data: { hikashop_cart_type_1_0: 'cart',
              product_id: a,
              module_id:'0',
              add: b,
              ctrl: 'product',
              task: 'updatecart',
              return_url:'aHR0cHM6Ly9sb2NhbGhvc3QvdWVtYXBhMi9pbmRleC5waHAvZW4vcmVudGFs'
      },
      success:function (data) {
        
      }
    });
  }

  function M() {
    
    //Modify View
    var m = $(this).val();
    //Modify Data
    var id = $(this).parent().siblings('.id').html();
    datosForm[id-1][2] = m;
  }

  //Filters
  function datosIsTrue (arr) {
    if(arr[5] === true) 
      return arr;
  }

  function productAlreadyAdd (partNumber, arr) {
    if(arr[1] === partNumber) 
      return true;
  }

  function init() {

    $(".btnToBuy").on('click', addCartItems);    

    //submit form
    $(".btnSend").on('click', sendForm);

    //Listen 
    $(".btnAddRow").on('click', addRows);

    //Listen 
    $("body").on('click', '.btnDeleteRow', deleteRows);

    $("body").on('click', '.myImg', showModal);

    $(".close").on('click', closeModal);

    $("body").on('change', "input:checkbox.addToCart", comprar);

    $("body").on('change', '.M', M);

  }

  //Interface!
  return {
    init: init,
    getM: getManufacturer
  };

})();