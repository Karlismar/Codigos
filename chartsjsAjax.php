<!-- FUNÇÃO QUE RETORNA OS DADOS PARA O GRAFICO -->
<?php
        public function tempParado(){

         $dados['DADOS'] = $this->model->duncao();
         $movendo;
         $parado;
         foreach ($dados as $key) {
             $movendo = $key['movendo'];
             $parado = $key['parado'];
         }

         $data = array(

            'movendo' => $movendo,
            'parado'  => $parado
        );

        echo json_encode($data);

    }
?>

<!-- SCRIT DO GRAFICO CHARTS.JS doughnut -->

<script type="text/javascript">

  function hmsToSeconds(hms){
   var a = hms.split(':'); 
   var seconds = (+a[0]) * 60 * 60 + (+a[1]) * 60 + (+a[2]); 
   return seconds;
}

function secondsToTime(seconds){
    horas = parseInt(seconds/3600);
    if(horas < 10){
        horas = "0"+String(horas);
    }
    seconds = seconds-(horas*3600);
    minutos = parseInt(seconds/60);
    if(minutos < 10){
        minutos = "0"+String(minutos);
    }
    seconds = seconds-(minutos*60);
    if(seconds < 10){
        seconds = "0"+String(seconds);
    }
    return String(horas)+":"+String(minutos)+":"+String(seconds);
}

// FUNÇÃO QUE RECUPERA VALOR PASSADO PELA URL 

var placa = location.search.slice(1);

// RETIRA O NOME DO ATRIBURO PASSADO PELA URL

var plac = placa.split('placa=')[1];

var dur = "<?php echo lang('duracao')?>";
$(document).ready(function() {
    // CARREGA IMG GIF NA DIV
    $("#tparado").html('<img src="<?php echo base_url('urldaimagem')?>" height="130" width="130">');
    $.ajax({
     url: '<?php echo base_url('controller')?>',
     type:'GET',
     data: {placa:plac},
     dataType: 'json',
     success: function(resposta){
        // CARREGA O GRAFICO NA DIV
        $("#tparado").html(' <canvas class="my-4 w-100" id="pizza" width="1000" height="400"></canvas>');
        var mov = hmsToSeconds(resposta.movendo);
        var par = hmsToSeconds(resposta.parado);
        
        var paradoL = "<?php echo lang('Parado') ?>"+" "+resposta.parado;
        var movendoL = "<?php echo lang('Movendo') ?>"+" "+resposta.movendo;

        new Chart(document.getElementById("pizza"), {
            type: 'doughnut',
            data: {
              labels: [paradoL, movendoL],
              datasets: [
              {
                  label: "",
                  backgroundColor: ["#e83a3a", "#5be244"],
                  data: [par,mov]
              }
              ]
          },
          options: {
            // ALTERA O CONTEUDO DO TOOLTIPS
            tooltips: {
                mode: 'nearest',
                intersect: false,
                custom: function(tooltip) {
                    if (!tooltip) return;

                    tooltip.displayColors = false;
                },
                callbacks: {
                    label: function(tooltipItem, data) {
                        var datasetLabel = data.datasets[tooltipItem.datasetIndex].label || 'Other';
                        var label = data.labels[tooltipItem.index];
                        return [
                        data.datasets[0].label+dur+": "+secondsToTime(data.datasets[0].data[tooltipItem.index].toFixed(2)),


                        ];
                    }
                }
            },
            title: {
                display: true
            }
        }
    });
    },
    error: function(json){
        console.log(json);
    }
});

});
</script>