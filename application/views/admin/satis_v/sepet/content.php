<section class="panel">
    <header class="panel-heading">
        <h2 class="panel-title">Sepet</h2>
    </header>
    <div class="panel-body">
	
        <?php if(empty($sepet_ilaclar)) { ?>
			<div class="alert alert-info text-center">
				<p>Sepette hiç ürün yok.</p>
			</div>
			
        <?php } else { ?>
			<div class="row-md-4 mb-sm">
				<a href="<?php echo base_url("satis/sepeti-temizle"); ?>" class="btn btn-sm btn-dark btn-outline mb-xs ml-sm"><i class="fa fa-trash"></i>  Sepeti Temizle</a>
				<select name="sgk_changer" onchange="change_sgk()" id="sgk_changer" style="float:right; margin-top: -6px">
			
					<option value="0" <?php echo $sgkDurumu == 0 ? "selected" : "" ?> >Sosyal Güvence Yok</option>
					<option value="1" <?php echo $sgkDurumu == 1 ? "selected" : "" ?> >Sosyal Güvence Var</option>
			
				</select>
			</div>
			
			
			<div class="table-responsive">
				<table class="table table-bordered table-striped mb-none">
					<thead>
						<th>Barkod</th>
						<th>Ürün Adı</th>
						<th>Ürün Fiyatı <?php echo $sgkDurumu == 0 ? "(SGK'SIZ)" : "(SGK'LI)" ?></th>
						<th>Adet</th>
						<th>Toplam Fiyatı</th>
						<th>İşlem</th>
						
					</thead>
					
					<tbody>
						
						<?php foreach($sepet_ilaclar as $ilac) { ?>
							<tr>
								<td class="w50 text-center"><?php echo $ilac["barkod"]; ?></td>
								<td><?php echo $ilac["name"]; ?></td>
								<td><?php echo $ilac["price"]; ?></td>
								<td class="text-center"><?php echo $ilac["qty"]; ?></td>
								<td class="text-center"><?php echo $ilac["subtotal"]; ?></td>
								<td class="text-center w200">
									<button class="btn btn-sm btn-danger btn-outline remove-item" id="<?php echo $ilac["rowid"] ?>"><i class="fa fa-trash"></i> Sil</button>
								</td>
								
							</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		<?php } ?>
	
	<div class="w200 mt-md" style="float: right;">
			
			<div class="w200 text-center" style="font-size: 18px;">
				<p>Toplam Fiyat:  <b><?php echo $toplamFiyat ?> TL</b></p>
			</div>
			<div class="w200 text-center">
				<a href="<?php echo base_url("satis/sepet/sepeti-onayla")?>" class="btn btn-sm btn-primary btn-outline"><i class="fa fa-check"></i> Sepeti Onayla</a>
			</div>
			
		</div>
	
	
	</div>
	
</section>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script>
	$(document).on('click', '.remove-item', function(){
		var ilac = $(this).attr("id");
		$.ajax({
			url:"<?php echo base_url(); ?>satis/sepetten-cikar",
			method:"POST",
			data:{
				'delete' : ilac,
				'<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>',
			},
			success:function(data){
			 alert("Product removed from Cart");
			 window.location.replace("<?php echo base_url()?>/satis/sepet");
			}
	   });
	});
	
	function change_sgk(){

		var select = document.getElementById("sgk_changer");
		var selvalue = select.value;
		window.location.replace(<?php echo "\"".base_url("satis/sepet")."/\"" ?> + selvalue);
	}
	
</script>