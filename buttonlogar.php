
<a href='#' data-email='$v->email' data-senha='$v->senha' class='btn btn-primary btn-mini logar' title='Logar na conta do Usuário'><i class='icon-off icon-white'></i></a>

<script type="text/javascript">

    $(document).on('click', '.logar', function(){
       var login = $(this).attr('data-email');
       var senha = $(this).attr('data-senha');

       $.ajax({
        type: "POST",
        url: "<?php echo base_url('')?>index.php/instaladores/autlog",
        data: {login: login, senha: senha},
        success: function(data)
        {
            data = JSON.parse(data);
            if (data.success){
                window.open('<?php echo base_url('')?>index.php/home/instalador', '_blank');
            }else{
                alert('Erro ao logar');
            }
        }
    });
   });

</script>
