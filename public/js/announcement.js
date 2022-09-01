$.ajaxSetup({
    headers:
    {
        'X-CSRF-Token': $('input[name="_token"]').val()
    }
});

$(document).ready(function () {
    // Run Bootstrap Material Design
    $('body').bootstrapMaterialDesign();
    
    _masks();
});

function _masks() {
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

// Input File
$(function () {
    // Input File Image
    $('#image').change(function() {
        var numFiles = $(this).get(0).files.length;
        if(numFiles > 1) {
            $('.file-name-image').html(numFiles + ' arquivos selecionados');
        } else {
            $('.file-name-image').html(numFiles + ' arquivo selecionado');
        }
    });

    // Input File Video
    $('#video').change(function() {
        var numFiles = $(this).get(0).files.length;
        $('.file-name-video').html(numFiles + ' arquivo selecionado');
    });
});

// Buscar Subcategorias
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