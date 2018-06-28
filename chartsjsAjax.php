  <script type="text/javascript">
  function hmsToSeconds(hms){
   var a = hms.split(':'); 
   var seconds = (+a[0]) * 60 * 60 + (+a[1]) * 60 + (+a[2]); 
   moment.unix(seconds).format("hh:mm a");
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

var placa = location.search.slice(1);
var plac = placa.split('placa=')[1];
var dur = "<?php echo lang('duracao')?>";
$(document).ready(function() {
    $.ajax({
     url: '<?php echo base_url('veiculos/tempParado')?>',
     type:'GET',
     data: {placa:plac},
     dataType: 'json',
     success: function(resposta){

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
                  backgroundColor: ["#3e95cd", "#8e5ea2"],
                  data: [par,mov]
              }
              ]
          },
          options: {
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