
<a href='#' data-email='$v->email' data-senha='$v->senha' class='btn btn-primary btn-mini logar' title='Logar na conta do Usuário'><i class='icon-off icon-white'></i></a>

<script type="text/javascript">

    $(document).on('click', '.logar', function(){
       var login = $(this).attr('data-email');
       var senha = $(this).attr('data-senha');

       $.ajax({
        type: "POST",
        //CONTROLLER PARA AUTENTICAR USUARIO
        url: "<?php echo base_url('')?>index.php/controller/funcao",
        data: {login: login, senha: senha},
        success: function(data)
        {
            data = JSON.parse(data);
            if (data.success){
                //CONTROLLER DE ACESSO A CONTA DO USUARIO
                window.open('<?php echo base_url('')?>index.php/controller/funcao', '_blank');
            }else{
                alert('Erro ao logar');
            }
        }
    });
   });

</script>

<!-- FUNCAO QUE RETORNA OS DADOS DE AUTENTICAO -->

<?php


public function funcao(){

     if(model($param1, $param2)){

        echo '{"success":true}';
    }
    else{
        echo '{"success":false}';
    }
}



?>
