/*
 *   Painel V2
 *   INSPINIA + Laravel - Agência DW3
 *   version 1.0.0
 *
 */

$.ajaxSetup({
    headers:
    {
        'X-CSRF-Token': $('input[name="_token"]').val()
    }
});    

$(document).ready(function () {
    $(document).tooltip({
        selector: "[data-toggle=tooltip]",
        container: "body"
    });

    _masks();
    _phone9();
});

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
    $('.money2').mask("#.##0,00", {reverse: true});
  }

  //Função de Máscara para telefone com 9 dígitos
function _phone9(){
    var SPMaskBehavior = function (val) {
        return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
      },
      spOptions = {
        onKeyPress: function(val, e, field, options) {
            field.mask(SPMaskBehavior.apply({}, arguments), options);
          }
      };
      
      $('.phones').mask(SPMaskBehavior, spOptions);
}

  //verificando o tipo de pessoa e colocando a máscara
$('#type_person').on('change', function(){
    if($(this).val() == 'J'){
      $('#cpf_cnpj').mask('00.000.000/0000-00', {reverse: true});
    }else if($(this).val() == 'F'){
      $('#cpf_cnpj').mask('000.000.000-00', {reverse: true});
    }
  });

// Buscar subcategorias
$('[name=product_category_id]').on('change', function() {
    var productCategoryId = $(this).val();

    $.ajax({
        url: URL + '/get-product-subcategories',
        type:'post',
        dataType:'json',
        data:{product_category_id:productCategoryId},
        success:function(result) {
            if (result.length) {
                $('[name=product_sub_category_id]').empty();
                $('[name=product_sub_category_id]').append(
                    '<option selected="selected" value="">Selecione</option>'
                );

                for (var i = 0; i < result.length; i++) { 
                    $('[name=product_sub_category_id]').append(
                        '<option value="' + result[i].id + '">' + result[i].subcategory + '</option>'
                    );
                }
                $('[name=product_sub_category_id]').removeAttr('disabled');
            } else {
                $('[name=product_sub_category_id]').empty();
                $('[name=product_sub_category_id]').append(
                    '<option selected="selected" value="">Nenhuma subcategoria encontrada</option>'
                );
                $('[name=product_sub_category_id]').removeAttr('disabled');
            }
        }
    });
});

Dropzone.options.myAwesomeDropzone = {
    maxFilesize: 1,
    maxFiles: 20,
    dictMaxFilesExceeded: "Máximo de fotos permitido é {{maxFiles}}",
    acceptedFiles:"image/*",
    dictInvalidFileType: "Somente fotos JPG/PNG",
    dictFileTooBig: "Este arquivo 'é muito grande ({{filesize}}MB). Tamanho máximo: {{maxFilesize}}MB.",
    init: function() {
        var _this = this;
        
        $('.dropGallery').each(function(){
          var obj = $(this);
          var mockFile = { name: obj.attr('media'), size: obj.attr('size') };
          _this.emit("addedfile", mockFile);
          _this.createThumbnailFromUrl(mockFile, obj.attr('storage'));
          _this.emit("complete", mockFile);
          var removeButton = Dropzone
            .createElement("<span class='glyphicon glyphicon-trash btn-del-dropzone' aria-hidden='true' title='Apagar imagem'></span>");
          mockFile.previewElement.appendChild(removeButton);
          
          removeButton.addEventListener("click", function(e) {
            e.preventDefault();
            e.stopPropagation();
            bootbox.confirm({
            message: "Você realmente quer excluir essa foto?",
              buttons: {
                  confirm: {
                      label: 'Sim'
                  },
                  cancel: {
                      label: 'Não',
                      className: 'btn-danger'
                  }
              },
              callback: function (result) {
                  if(result)
                  {
                    $.ajax({
                      type: 'DELETE',
                      dataType: 'JSON',
                      url:  URL + "/media/" + obj.attr('mediaid'),
                      data:{},
                      success: function(data){
                        if(data)
                        { 
                          _this.removeFile(mockFile);
                        }
                        else
                        {
                          bootbox.alert("Desculpe, ocorreu um erro ao deletar esta foto.", function() {});
                        }
                      }
                    });
                    
                  }
              }
            });
          });    
        });
        
  
        this.on("addedfile", function(file) {
          var removeButton = Dropzone
                              .createElement("<span class='glyphicon glyphicon-trash btn-del-dropzone' aria-hidden='true' title='Apagar imagem'></span>");
  
          file.previewElement.appendChild(removeButton);
  
          removeButton.addEventListener("click", function(e) {
            e.preventDefault();
            e.stopPropagation();
            bootbox.confirm({
            message: "Você realmente quer excluir essa foto?",
              buttons: {
                  confirm: {
                      label: 'Sim'
                  },
                  cancel: {
                      label: 'Não',
                      className: 'btn-danger'
                  }
              },
              callback: function (result) {
                  if(result)
                  {
                    $.ajax({
                      type: 'DELETE',
                      dataType: 'JSON',
                      url:  URL + "/media/" + file.name,
                      data:{},
                      success: function(data){
                        if(data)
                        { 
                          _this.removeFile(file);
                        }
                        else
                        {
                          bootbox.alert("Desculpe, ocorreu um erro ao deletar está foto.", function() {});
                        }
                      }
                    });
                    
                  }
              }
            });
          });        
        });
    }
};

// Atualizar status dos interesses
$(document).on('click', '.update-interest-status',function() {
    var obj = $(this);
    var parent = $(this).parent();

    $.ajax({
        url: URL + '/update-interest-status',
        type:'post',
        dataType:'json',
        data:{product_has_interest_id:obj.attr('product-has-interest-id'), status:obj.attr('status')},
        success:function(result) {
            if (result) {
                $('[data-toggle="tooltip"]').tooltip('destroy');
                parent.find('.update-interest-status').remove();

                if (obj.attr('status') == '0') {
                    parent.append(
                        '<a title="Vendido" data-toggle="tooltip" data-placement="top" href="#" class="btn-warning btn btn-xs m-l-xs update-interest-status" product-has-interest-id="' + obj.attr('product-has-interest-id') + '" status="1"> <i class="fa fa-dollar fa-fw"></i></a>' + 
                        '<a title="Cancelado" data-toggle="tooltip" data-placement="top" href="#" class="btn-danger btn btn-xs m-l-xs update-interest-status" product-has-interest-id="' + obj.attr('product-has-interest-id') + '" status="2"> <i class="fa fa-ban fa-fw"></i></a>'
                    );
                    parent.closest('tr').find('.td-status').text('Negociando');
                } else if (obj.attr('status') == '1') {
                    parent.append(
                        '<a title="Cancelado" data-toggle="tooltip" data-placement="top" href="#" class="btn-danger btn btn-xs m-l-xs update-interest-status" product-has-interest-id="' + obj.attr('product-has-interest-id') + '" status="2"> <i class="fa fa-ban fa-fw"></i></a>' + 
                        '<a title="Negociando" data-toggle="tooltip" data-placement="top" href="#" class="btn-primary btn btn-xs m-l-xs update-interest-status" product-has-interest-id="' + obj.attr('product-has-interest-id') + '" status="0"> <i class="fa fa-briefcase fa-fw"></i></a>'
                    );
                    parent.closest('tr').find('.td-status').text('Vendido');
                } else {
                    parent.append(
                        '<a title="Vendido" data-toggle="tooltip" data-placement="top" href="#" class="btn-warning btn btn-xs m-l-xs update-interest-status" product-has-interest-id="' + obj.attr('product-has-interest-id') + '" status="1"> <i class="fa fa-dollar fa-fw"></i></a>' + 
                        '<a title="Negociando" data-toggle="tooltip" data-placement="top" href="#" class="btn-primary btn btn-xs m-l-xs update-interest-status" product-has-interest-id="' + obj.attr('product-has-interest-id') + '" status="0"> <i class="fa fa-briefcase fa-fw"></i></a>'
                    );
                    parent.closest('tr').find('.td-status').text('Cancelado');
                }

                $('[data-toggle="tooltip"]').tooltip();
            } else {
                alert('Ops, ocorreu algum problema.');
            }
        }
    });

    return false;
});