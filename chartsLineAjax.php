
<?php
//FUNCAO QUE RETORNA OS MINUTOS E TRANSFORMA EM SEGUNDOS 
    public function totalParadas(){

        date_default_timezone_set('America/Sao_Paulo');
        $end  = date('d-m-Y');
        $init = date('d-m-Y', strtotime("-7 days"));
        $boards[] = $placa;
        $tipo = 0;
        $interval = '00:01:00';

        $dados = $this->relatorio->timeStop($init, $end, $boards, $tipo, $token, $interval);
        $cont = 1;
        $data;
        foreach ($dados as $key){
            foreach ($key as $r) {
                list($hrs,$mts,$sgd) = explode(':', $r['duration']);
                $calc = $hrs * 3600 + $mts * 60 + $sgd;
                $data[] = array(
                    'y' => $calc,
                    'x' => $cont++
                );

            }

        }


        echo json_encode($data);

    }

    ?>

      <script type="text/javascript">

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
        $("#data").html('<img src="" height="130" width="130">');
        $.ajax({
         url: '<?php echo base_url('controller/funcao')?>',
         type:'GET',
         data: {placa:plac},
         dataType: 'json',
         success: function(r){
            $("#data").html('<canvas class="my-4 w-100" id="myChart" width="900" height="200"></canvas>');
            var resposta = r;
            resposta.pop();
            var result = [];
            var labels = [];
            var i = 0;
            for (i; i<resposta.length; i++) {
               result.push({y:resposta[i].y,x:resposta[i].x});
               labels.push(resposta[i].x);
           }

           var data = result.map(e => +e.y);
           var total = i+"<?php echo lang('paradas')?>";
           var ctx = document.getElementById("myChart").getContext('2d');
           var dur = "<?php echo lang('duracao')?>";
           var parada = "<?php echo lang('parada')?>";
           var myChart = new Chart(ctx, {
             type: 'line',
             data: {
              labels: labels,
              datasets: [{
               label: dur,
               data: data,
               backgroundColor: 'transparent',
               borderColor: '#007bff',
               borderWidth: 3,
               pointBackgroundColor: '#007bff'

           }]
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
                    data.datasets[0].label+": "+secondsToTime(data.datasets[0].data[tooltipItem.index].toFixed(2)),


                    ];
                }
            }
        },
        scales: {
            xAxes: [{
             ticks: {
                callback: function(value) {
                    return value + "º "+ parada;
                }
            }

        }],
        yAxes: [{
            ticks: {
                callback: function(value, index, values) {
                    return  secondsToTime(value);
                }
            },
            time: {
              minUnit: 'millisecond'
          }
      }]
  },
  title: {
    display: true,
    text: total
},

},
});

       },
       error: function(json){
        console.log(json);
    }
});

    });

</script>