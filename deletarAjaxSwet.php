 <a href="#" onclick="delete_abs('<?php echo $del->id ?>')" data-id="" role="button" class="btn btn-danger" title=""><i class="fa fa-trash-o"></i> </a>




 <script type="text/javascript">
	var title =  "<?php echo lang('vc_y')?>";
	var text = "<?php echo lang('aviso_del')?>";
	var feito = "<?php echo lang('feito')?>";
	var sucess = "<?php echo lang('deletado_suc')?>";
	var erro = "<?php echo lang('erro_ex')?>";
	var tente = "<?php echo lang('tente_n')?>";
	var sim = "<?php echo lang('sim')?>";
	var nao = "<?php echo lang('nao')?>";
	function delete_abs(id){      
		swal({
			title: title,
			text: text,
			icon: "warning",
			buttons: true,
			dangerMode: true,
			buttons: [nao, sim],
		})
		.then((willDelete) => {
			if (willDelete) {
				$.ajax({
					url : "<?php echo base_url('')?>index.php/controller/funcao",
					type : "POST",
					dataType : "JSON",
					data: {id: id},
					beforeSend: function(){
						$('#response').html('');

					},
					success : function(data)
					{

						if (data.success){
							window.location.replace('<?php echo base_url('')?>index.php/controller/funcao');
							swal(feito, sucess, "success");
						}else{
							swal(erro, tente, "error");
						}


						$('#response').html("");
					},
					error : function(jqXHR, textStatus, errorThrown)
					{
						swal(erro, tente, "error");
					}
				});
			}
		});
	}
</script>