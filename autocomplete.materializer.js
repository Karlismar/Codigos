$(document).ready(function() {
        $(function() {
            var valor = $('.cnae-id').val();
            $.ajax({
                dataType: "json",
                type: 'GET',
                url: "{{route('cnae')}}",
                beforeSend: function() {
                    $(".cnae").val("BUSCANDO...");
                },
                success: function(response) {
                    $(".cnae").val("");
                    var countryArray = response;
                    var dataCountry = {};
                    for (var i = 0; i < countryArray.length; i++) {
                        dataCountry[countryArray[i].codigo + ' - ' + countryArray[i].descricao] = countryArray[i].flag;
                    }
                    if (valor) {
                        for (var j = 0; j < response.length; ++j) {
                            if (response[j].id == valor) {
                                $('.cnae').val(response[j].codigo + ' - ' + response[j].descricao);
                                break;
                            }
                        }
                    }
                    $('.cnae').autocomplete({
                        data: dataCountry,
                        limit: 6,
                        onAutocomplete: function(val) {
                            var array = val.split(' - ')
                            $('.cnae-id').val(parseInt(array[0]))
                        },
                    });
                }
            });
        });
    });
