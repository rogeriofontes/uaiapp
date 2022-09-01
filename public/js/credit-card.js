$.ajaxSetup({
  headers:
  {
    'X-CSRF-Token': $('input[name="_token"]').val()
  }
});

$(document).ready(function(){
  // Run Bootstrap Material Design
  $('body').bootstrapMaterialDesign();

  _masks();
});

function _masks(){
  $('.cpf').mask('000.000.000-00', {reverse: false});
}