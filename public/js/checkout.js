$.ajaxSetup({
  headers:
  {
    'X-CSRF-Token': $('input[name="_token"]').val()
  }
});

$(document).ready(function (){
  // Run Bootstrap Material Design
  $('body').bootstrapMaterialDesign(); 

  _masks();
});

// Máscaras
function _masks(){
  $('.date').mask('00/00/0000');
  $('.time').mask('00:00:00');
  $('.date_time').mask('00/00/0000 00:00:00');
  $('.cep').mask('00000-000');
  $('.phone').mask('(00) 00000-0000');
  $('.phone_with_ddd').mask('(00) 0000-000#0');
  $('.cpf').mask('000.000.000-00', {reverse: true});
  $('.cnpj').mask('00.000.000/0000-00', {reverse: true});
  $('.money').mask('000.000.000.000.000,00', {reverse: true});
  $('.money2').mask("00.000.000,00", {reverse: true});
}

// Verificação CEP
$('.cep').on('blur',function(){
  var obj = $(this);
  if(obj.val() != '') {
      $.ajax({
          url: URL + '/get-cep',
          type:'post',
          dataType:'json',
          data:{cep:obj.val()},
          success:function(resultadoCEP) {
              if (resultadoCEP.resultado == 0) {
                  swal({
                      title: "Desculpe =(",
                      text: "Não foi encontrado nenhum endereço para este CEP!\nCaso ele realmente exista, clique SIM para preencher o endereço manualmente!",
                      type: "warning",
                      showCancelButton: true,
                      confirmButtonClass: "btn-danger",
                      confirmButtonText: "Sim, preencher manualmente",
                      cancelButtonText: "Não, tentar outro!",
                      closeOnConfirm: true,
                      closeOnCancel: true
                  },
                  function(isConfirm) {
                      if (isConfirm) {
                          $('#neighborhood').removeAttr('readonly');
                          $('#state').removeAttr('readonly');
                          $('#complement').removeAttr('readonly');
                          $('#city').removeAttr('readonly');
                          $('#number').removeAttr('readonly');
                          $('#address').removeAttr('readonly');
                      } else {
                          obj.focus();
                          $('#cep').val('');
                      }
                  });           
              } else if (resultadoCEP.resultado == 1) {
                  $('#neighborhood').removeAttr('readonly');
                  $('#neighborhood').attr('value', resultadoCEP.bairro);
                  $('#state').removeAttr('readonly');
                  $('#state').attr('value', resultadoCEP.uf);
                  $('#complement').removeAttr('readonly');
                  $('#city').removeAttr('readonly');
                  $('#city').attr('value', resultadoCEP.cidade);
                  $('#city_id').attr('value', resultadoCEP.city_id);
                  $('#number').removeAttr('readonly');
                  $('#address').removeAttr('readonly');
                  $('#address').val(unescape(resultadoCEP.logradouro));
              } else if (resultadoCEP.resultado == 2) {
                  swal({
                      title: "Atenção",
                      text: "Este Cep é Unico, por favor insira o bairro manualmente! Caso digitou errado, você pode cancelar e tentar novamente.",
                      type: "input",
                      showCancelButton: true,
                      confirmButtonClass: "btn-danger",
                      confirmButtonText: "Sim, preencher manualmente",
                      cancelButtonText: "Não, tentar outro!",
                      closeOnConfirm: false,
                      closeOnCancel: true,
                      inputPlaceholder: "Bairro"
                  },
                  function (inputValue) {
                      if (inputValue === false) return false;
                      if (inputValue === "") {
                          swal.showInputError("Por favor, digite o bairro para continuar!");
                          return false
                      }
                      $('#neighborhood').removeAttr('readonly');
                      $('#neighborhood').attr('value', inputValue);
                      $('#state').removeAttr('readonly');
                      $('#state').attr('value', resultadoCEP.uf);
                      $('#complement').removeAttr('readonly');
                      $('#city').removeAttr('readonly');
                      $('#city').attr('value', resultadoCEP.cidade);
                      $('#city_id').attr('value', resultadoCEP.city_id);
                      $('#number').removeAttr('readonly');
                      $('#address').removeAttr('readonly');
                      swal.close()
                  });
              }
          }
      });
  } else {
      swal('Ops', 'Para que o endereço seja completado automaticamente você deve preencher o campo CEP!');
  }
  return false;
});