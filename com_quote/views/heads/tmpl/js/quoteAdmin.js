// IIFE
var quoteAdmin = (function () {

  var inputVal = "", db = "", x = "";

  function q1() {
    
    $('.searchResult').empty();
    $('.QTable').hide();
    $('.btnUpdate').hide();
    //After Update Quote Hide: Updated Succesfull Mssg
    $('.mssgResult').hide();

    var input = `<input type="number" data-o="1" id="quote_request_input" name="quote_request" value="" required style="width:50px">`;
    $('#quote_r').html(input);
  }

  function q2() {
    
    $('.searchResult').empty();
    $('.QTable').hide();
    $('.btnUpdate').hide();
    //After Update Quote Hide: Updated Succesfull Mssg
    $('.mssgResult').hide();

    var input = `<input type="text" data-o="2" id="quote_request_input" name="quote_request" value="" required>`;
    $('#quote_r').html(input);
  }

  function q3() {
    
    $('.searchResult').empty();
    $('.QTable').hide();
    $('.btnUpdate').hide();
    //After Update Quote Hide: Updated Succesfull Mssg
    $('.mssgResult').hide();

    var input = `
    <select name="status" data-o="3" id="quote_request_select" style="width: 100%">
      <option value="">--Select--</option>
      <option value="0">Ordered</option>
      <option value="1">Active</option>
      <option value="2">Closed</option>
    </select>`;
    $('#quote_r').html(input);
  }

  function getQuote(e) {

    //After Update Quote: Hide Updated Succesfull Mssg
    $('.mssgResult').hide();

    var n = e.target.value;

    if(n === undefined) {
      n = e.target.options.selectedIndex;
      inputVal = e.target.options[n].value;
    } else {
      inputVal = n;
    }
    searchQuote(this.dataset.o);
  }

  function searchQuote(c) {

    var s;

    switch (c) {
      case "1": s = "id";
      break;
      case "2": s = "username";
      break;
      case "3": s = "status";
      break;
      default: s = "";
      break;
    }

    $.ajax({
      url: `../../../components/com_quote/helpers/searchQuote_${ s }.php`,
      type: 'POST',
      data: { inputVal: inputVal },
      dataType: 'json',
      beforeSend: function(){
        $('.searchResult').html('Searching...');
        $('#itemTabla').empty();
        $("#ITable").hide();      

      },
      success: function (data) {
        if (!data.error) {
          loadData(data);
          table();
        }
      }
    });
  }

  function loadData (data) {
    db = data;
  }

  function table() {

    var dP = $(document.createDocumentFragment());
    
    var rh = $('<div class="row">');

    var ith = $('<div class="table-bordered col s2 m1 center-align">');
    var sth = $('<div class="table-bordered col s4 m2 center-align">');
    var crh = $('<div class="table-bordered col s6 m3 center-align">');

    dP.append(rh
      .append(ith.append("#"))
      .append(sth.append("status"))
      .append(crh.append("date")));

    for (var i = 0; i < db.length; i++) {

      var quoteid = db[i].quoteid;
      var state   = db[i].state;
      created = dateMoment(db[i].created);

      switch (state) {
        case "0": state = "Ordered";
        break;
        case "1": state = "Active";
        break;
        default: state = "Closed";
        break;
      }

      var r = $('<div class="row">');

      //button quoteid:number
      var it = $(`<button data-i="${ i+1 }" style="margin-top:0px;height:27px;" class="ite btn-small table-bordered center-align col s2 m1">`);
      var st = $('<div class="table-bordered col s4 m2 center-align">');
      var cr = $('<div class="table-bordered col s6 m3 center-align">');

      dP.append(r
        .append(it.append(quoteid))
        .append(st.append(state))
        .append(cr.append(created)));
    }
    $('.searchResult').html(dP);
  }

  function item() {

    $("#ITable").show();
    $('.btnUpdate').show();
    $('.mssgResult').hide();

    var dT = $(document.createDocumentFragment());

    var i = $(this).data('i');
    i--;

    for (var j = 0; j < db[i].items.length; j++) {
      
      var tr  = $(`<tr id="quoteid" data-uid="${ db[i].uid }" data-quoteid="${ db[i].quoteid }">`);
      var tda = $(`<td class="center-align id">${ db[i].items[j].id }</td>`); //item number
      var tdb = $(`<td class="center-align">${ db[i].items[j].brand }</td>`); //brand
      var tdn = $(`<td class="center-align pid" data-pid="${db[i].items[j].productid}">${ db[i].items[j].pserial }</td>`); //part number
      var tdq = $(`<td class="center-align qnty">${ db[i].items[j].quantity}</td>`); //parts quantity
      var tdp = $(`<td class="center-align price"></td>`); //price
      
      var pserial = db[i].items[j].pserial;
      var pserial = pserial.toString();
      var price = db[i].items[j].price;
      var price = parseInt(price);

      var n = db[i].items[j].id;

      if( price <= 0 ) {
        getPriceFromHKS(pserial, n);
      } 
      else {
        var p = price;
      }
      var input = $(`<input type="number" min="1" 
      class="pq M" id="${ db[i].items[j].id }" style="height:15px;width:70px;" 
      value="${ p }">`);

      dT.append(tr
       .append(tda)
       .append(tdb)
       .append(tdn)
       .append(tdq)
       .append(tdp.append(input)));
    }
    $('#itemTabla').html(dT);
  }

  function getPriceFromHKS(pserial, n) {

    var productCode = pserial; 
    var price = 0;

    $.ajax({
      url: '../../../components/com_quote/helpers/getProduct.php',
      type: 'POST',
      data: { productCode: productCode },
      dataType: 'json',
      success: function (data) {
        if (data.length !== 0) {
          price = parseInt(data.price_value);
          $(`#${ n }`).val(price.toFixed(2));
        
        } else {
            $('.mssgResult').show();
            $('.btnUpdate').hide();
        }
      }
    });

  }

  function dateMoment(created) {

    var d = new Date(created);
    
    return `${d.getDate()}/${d.getMonth() + 1}/${d.getFullYear()}`;
  }

  function quoteUpdateDOM() {

    var items = [];

    var quoteid = $('#quoteid').data('quoteid');
    var uid     = $('#quoteid').data('uid');

    $('#itemTabla').each(function() {
      $(this).children('tr').each(function(){
        $(this).children('td:nth-child(1)').each(function() {
          
          var id = $(this).html();
          var price = $(this).siblings('.price').children('input').val();
          items.push([id, price]);
        
        });
      });
    });

    var arr = [quoteid, items];

    quoteUpdate(arr);
    sendMailUpdate(uid, quoteid);
  }


  function quoteUpdate(arr) {

    var quote = arr;

    $.ajax({
      url: '../../../components/com_quote/helpers/updateQuotes.php',
      type: 'POST',
      data: { quote: quote },
      // dataType: 'json',
      success: function (data) {
        $('.mssgUpdate').html(data);
      }
    });
  }
  
  function sendMailUpdate(uid, quoteid) {

    var itemsQuote = $('.sendTableMail').html();

    //let's make a copy of table for being modified!

    $('.copyTable').append(itemsQuote);

    $('.copyTable .x').remove();

    var quoteData = $('.copyTable').html().toString();

    $.ajax({
      url: '../../../components/com_quote/helpers/sendMailUpdate.php',
      type: 'POST',
      data: { 
              quoteid: quoteid,
              uid: uid,
              userItems: quoteData
             },
      // dataType: 'json',
      success: function (data) {
        $('.mssgMailUpdate').html(data);
      }
    });
  }

  function init() {

    $("#q1").change(q1);

    $("#q2").change(q2);

    $("#q3").change(q3);

    $("body").on('keyup', '#quote_request_input', getQuote);

    $("body").on('change', '#quote_request_select', getQuote);

    $("body").on('click', '.ite', item);

    $('body').on('click', '.btnUpdate', quoteUpdateDOM)

  }

  //Interface!
  return {
    init: init
  };

})();
