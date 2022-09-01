
// Navigation tabs
$('.to-tab-info').on('click', function(){
  $('.tab-info').click();
});

$('.to-tab-address').on('click', function(){
  $('.tab-address').click();
});

function showMaps(){
    var latitude = $('#latitude').val();
    var longitude = $('#longitude').val();
  
    if(latitude != "" && longitude != ""){
        initialize(latitude, longitude);
    }else{
        initialize(-20.553944419013746, -48.57018103034977);
    }
  
    google.maps.event.addListener(marker, 'drag', function () {
        geocoder.geocode({ 'latLng': marker.getPosition() }, function (results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                if (results[0]) {
                    $('#latitude').val(marker.getPosition().lat());
                    $('#longitude').val(marker.getPosition().lng());
                }
            }
        });
    });
}
  
var geocoder;
var map;
var marker;


function initialize(latitude, longitude) {
    var options = {
        mapTypeId: 'roadmap'
    };

    map = new google.maps.Map(document.getElementById("mapa"), options);

    geocoder = new google.maps.Geocoder();

    marker = new google.maps.Marker({
        map: map,
        draggable: true,
    });

    var location = new google.maps.LatLng(latitude, longitude);
    marker.setPosition(location);
    map.setCenter(location);
    map.setZoom(16);
};


function carregarEnderecoMapa(endereco) {
    geocoder.geocode({ 'address': endereco + ', Brasil', 'region': 'BR' }, function (results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
            if (results[0]) {
                var latitude = results[0].geometry.location.lat();
                var longitude = results[0].geometry.location.lng();

                $('#latitude').val(latitude);
                $('#longitude').val(longitude);
        
                console.log(latitude + " " + longitude);

                var location = new google.maps.LatLng(latitude, longitude);
                marker.setPosition(location);
                map.setCenter(location);
                map.setZoom(16);
            }
        }
    });
};
  
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
                    carregarEnderecoMapa(unescape(resultadoCEP.logradouro) + " - " + unescape(resultadoCEP.bairro) + ", "  + unescape(resultadoCEP.cidade) + "/" + resultadoCEP.uf + " - " + obj.val())
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
                        carregarEnderecoMapa(unescape(resultadoCEP.logradouro) + " - " + unescape(inputValue) + ", "  + unescape(resultadoCEP.cidade) + "/" + resultadoCEP.uf + " - " + obj.val());
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

$('#cpf_cnpj').on('change', function(){
  var obj = $(this);
  if(obj.val() != ''){
    $.ajax({
      url: URL + '/get-company',
      type:'post',
      dataType:'json',
      data:{cpf_cnpj:obj.val()},
      success:function(result) {
        if(result){
          window.location = URL + '/store/' + result.id + '/edit';
        }
      }
    });
  }
});
