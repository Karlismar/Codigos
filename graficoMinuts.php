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
    var result = [<?php
     $cont = 1;
     foreach ($relatorio as $key){
        foreach ($key as $r) {
         echo '{y:hmsToSeconds("'.$r["duration"].'") ,x:"'.$cont++.'"},';
     }

 } ?>];

 var labels = [<?php
   $cont = 1;
   foreach ($relatorio as $key){
    foreach ($key as $r) {
        if($cont){
         echo ','.$cont++;
     }
     else{
        echo $cont++;
    }
}
}

?>];
var data = result.map(e => +e.y);
var total = "<?php echo $cont.lang('paradas'); ?>";
var ctx = document.getElementById("myChart").getContext('2d');
var myChart = new Chart(ctx, {
   type: 'line',
   data: {
      labels: labels,
      datasets: [{
         label: 'Duração',
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
                return value + 'º Parada';
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

</script>