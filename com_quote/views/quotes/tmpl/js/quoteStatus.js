var quoteStatus = (function () {

  var quotesStatus = "";
  var created = "";
  var db = Object.create(Object.prototype);
  var dataAddToCart = [];

  function getQuotes() {
    //user id
    var id = $("#uid").val();

    $.ajax({
      url: '../../../components/com_quote/helpers/getQuotes.php',
      type: 'POST',
      dataType: 'json',
      data: { id: id },
      success: function (data) {
        if (data.length > 0) {
          loadData(data);
          table();
        }
        else {
          $('.flashMssg').html("You have not quotes yet!");
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
    var ith = $('<div class="table-bordered col s2 m1 center-align" style="background:#B1B1B1">');
    var sth = $('<div class="table-bordered col s4 m2 center-align" style="background:#B1B1B1">');
    var crh = $('<div class="table-bordered col s6 m3 center-align" style="background:#B1B1B1">');

    dP.append(rh
      .append(ith.append("<strong>#</strong>"))
      .append(sth.append("<strong>status</strong>"))
      .append(crh.append("<strong>date</strong>")));

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
      var it = $(`<button data-i="${ i+1 }" style="margin-top:0px;height:27px;" class="it btn-small table-bordered center-align col s2 m1">`);
      var st = $('<div class="table-bordered col s4 m2 center-align">');
      var cr = $('<div class="table-bordered col s6 m3 center-align">');

      dP.append(r
        .append(it.append(quoteid))
        .append(st.append(state))
        .append(cr.append(created)));
    }
    $('.flashMssg').html(dP);
  }

  function items() {

    $("#QTable").show();
    $('#itemsTabla').empty();

    var dT = $(document.createDocumentFragment());

    var i = $(this).data('i');
    i--;

    for (var j = 0; j < db[i].items.length; j++) {

      var tr  = $(`<tr id="quoteid" data-quoteid="${ db[i].quoteid }">`);
      var tda = $(`<td class="center-align id">${ db[i].items[j].id }</td>`); //item number
      var tdb = $(`<td class="center-align">${ db[i].items[j].brand   }</td>`); //brand
      var tdn = $(`<td class="center-align pid" data-pid="${db[i].items[j].productid}">${ db[i].items[j].pserial }</td>`); //part number
      var tdq = $(`<td class="center-align qnty">${ db[i].items[j].quantity}</td>`); //parts quantity
      var tdp = $(`<td class="center-align">${ db[i].items[j].price   }</td>`); //price
      var tdc = $('<td class="center-align"></td>'); //check

      //VALIDATE if the item has price and the quote has status active      
      if(db[i].items[j].price > 0 && db[i].state === '1'){
        var check = $('<input class="addCart" type="checkbox">');
      } else {
        var check = $('<input class="addCart" type="checkbox" disabled>');
      }

      tdc.append(check);

      dT.append(tr
       .append(tda)
       .append(tdb)
       .append(tdn)
       .append(tdq)
       .append(tdp)
       .append(tdc));
    }
    $('#itemsTabla').html(dT);
  }

  function dateMoment(created) {

    var d = new Date(created);
    
    return `${d.getDate()}/${d.getMonth() + 1}/${d.getFullYear()}`;
  }

  function comprar() {

    var id = $(this).parent().siblings(".id").html();
    var pid = $(this).parent().siblings(".pid").data("pid");
    var qnty = $(this).parent().siblings(".qnty").html();

    // build datosForm
    if (this.checked) {
      dataAddToCart[id] = [id, pid, qnty, true];
    } else {
      dataAddToCart[id][3] = false;
    }

    var nCheck = $('input:checkbox.addCart:checked').length;

    if(nCheck > 0) {
      $(".btnAddCart").show();
    }
    else if(nCheck === 0) {
      $(".btnAddCart").hide();
    }

  }

  function addCI () {
    var d = dataAddToCart;
    for (var i = 0; i < d.length; i++) {
      //validar if true toBuy
      if(d[i] !== undefined && d[i][3]){
        updateCart(d[i][1],d[i][2]);
      }
    }

    var qid = $('#quoteid').data('quoteid');
    closeQuote(qid);
    location.reload();
  }

  function updateCart(a, b) {

    $.ajax({
      url: 'index.php/en/parts/product/updatecart',
      type: 'POST',
      data: { 
        hikashop_cart_type_1_0: 'cart',
        product_id: a,
        module_id:'0',
        add: b,
        ctrl: 'product',
        task: 'updatecart',
        return_url:'aHR0cHM6Ly9sb2NhbGhvc3QvdWVtYXBhMi9pbmRleC5waHAvZW4vcmVudGFs'
        },
    });
  }

  function closeQuote(qid) {
    $.post('../../../components/com_quote/helpers/closeQuote.php', { quoteid: qid } );
  }

  function init() {

    $("#QTable").hide();

    $(".btnAddCart").hide();

    $("body").on('click', '.it', items);

    $("body").on('change', "input:checkbox.addCart", comprar);

    $(".btnAddCart").on('click', addCI);
  }

  //Interface!
  return {
    init: init,
    getQ: getQuotes
  };
})();