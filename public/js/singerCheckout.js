function getBrand() {
  PagSeguroDirectPayment.getBrand({
    cardBin: $("#card_number").val().replace(/[^\d]+/g,''),
    success: function(response) {

      if (response.brand.cvvSize > 0){
        $("#cvv").attr('readonly', false);
      } else {
        $("#cvv").attr('readonly', true);
      }
      
      $("#expiry_mm").attr('readonly', false);
      $("#expiry_aa").attr('readonly', false);

      $("#creditCardBrand").val(response.brand.name);
      $('.divError').css('display', 'none');
      $('.divCardNumber').removeClass('has-error');
      $('.divCardNumber').addClass('has-success');
      $('.spanIconCardNumber').removeClass('glyphicon-remove');
      $('.spanIconCardNumber').addClass('glyphicon-ok');
      $(".bandeiraCartao").html('<img src="https://stc.pagseguro.uol.com.br/public/img/payment-methods-flags/68x30/' + response.brand.name + '.png" />');
      $(".cardFlag").val('https://stc.pagseguro.uol.com.br/public/img/payment-methods-flags/68x30/' + response.brand.name + '.png');
    },
    error: function(response) {
      $('.divError').css('display', 'block');
      $('.divCardNumber').removeClass('has-success');
      $('.divCardNumber').addClass('has-error');
      $('.spanIconCardNumber').removeClass('glyphicon-ok');
      $('.spanIconCardNumber').addClass('glyphicon-remove');

      $("#card_number").focus();
    },
    complete: function(response) {

    }
  });

  $(document).on('click', '.btn-credit-card', function(){
    var obj = $(this);
    obj.disabled = true;
    PagSeguroDirectPayment.createCardToken({
      cardNumber: $("#card_number").val().replace(/[^\d]+/g,''),
      brand: $("#creditCardBrand").val(),
      cvv: $("#cvv").val(),
      expirationMonth: $("#expiry_mm").val(),
      expirationYear: $("#expiry_aa").val(), 
      success: function (response) {
        $("#creditCardToken").val(response.card.token); 
        $('#senderHash').val(PagSeguroDirectPayment.getSenderHash());
        obj.closest('#formCreditCard').submit();
      },
      error: function (response) {
        $.each(response.errors, function(i, j){
          alert(i + ": " + j);
        });
      },
      complete: function (response) {

      }
    });
    return false;
  });
}