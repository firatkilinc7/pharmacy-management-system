<section class="panel">
    <header class="panel-heading">
        <h2 class="panel-title">İlaç Satış</h2>
    </header>
    <div class="panel-body">
	
        <?php if(empty($ilaclar)) { ?>
			<div class="alert alert-info text-center">
				<p>Hiç ilaç bulunamadı.</p>
			</div>
			
        <?php } else { ?>
		
		<form class="form-horizontal form-bordered" action="<?php echo base_url("satis/filtrele"); ?>" method="post" method="post">
			<div class="row-md-4 mb-sm">
					<label class="col-md-2 mt-sm" style="max-width: fit-content">Barkod No: </label>
					<input class="form-control mb-xs w200" style="display:unset" type="number" placeholder="Barkod no girin..." name="barkod" value="<?php echo isset($barkod) ? $barkod : "" ?>">
					
					<label class="col-md-0 mt-sm ml-sm mr-sm" style="max-width: fit-content">İlaç Adı: </label>
					<input class="form-control mb-xs w200" style="display:unset" type="text" placeholder="İlaç adı girin..." name="ilac_adi" value="<?php echo isset($ilac_adi) ? $ilac_adi : "" ?>">
					
					<button type="submit" class="btn btn-dark btn-sm w100 btn-outline mb-xs ml-sm"><i class="fa fa-filter"></i> Filtrele</button>
					<a href="<?php echo base_url("satis"); ?>" class="btn btn-sm btn-primary btn-outline mb-xs ml-sm"><i class="fa fa-trash"></i> Filtreyi Temizle</a>
			</div>
			<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
			
		</form>
		
			<div class="table-responsive">
				<table class="table table-bordered table-striped mb-none">
					<thead>
						<th>Barkod No</th>
						<th>İlaç Adı</th>
						<th>Stokta Bulunan Adet</th>
						<th>İlacın Bulunduğu Raf</th>
						<th>SGK İndirim Oranı (%)</th>
						<th>Son Kullanma Tarihi</th>
						<th>İlaç Fiyatı</th>
						<th>İndirimli Fiyat</th>
						<th>İlaç Resmi</th>
						<th>İşlem</th>
					</thead>
					
					<tbody>

						<?php foreach($ilaclar as $ilac) { ?>
							<tr>
								<td><?php echo $ilac->barkod; ?></td>
								<td><?php echo $ilac->ilac_adi; ?></td>
								<td class="text-center"><?php echo $ilac->stok; ?></td>
								<td class="text-center"><?php echo $ilac->raf_numarasi; ?></td>
								<td class="text-center">%<?php echo $ilac->sgk_indirim; ?></td>                
								<td class="text-center"><?php echo $ilac->expired_date; ?></td>                
								<td class="text-center"><?php echo $ilac->ilac_fiyati; ?></td>                
								<td class="text-center"><?php echo $ilac->indirimli_fiyat; ?></td>
								<td class="text-center w100">
									<img width="150" src="<?php echo get_picture("images/ilaclar_v",$ilac->img_url, "900x600"); ?>" alt="<?php echo $ilac->ilac_adi?>" class="img-rounded">
								</td>
								<td class="text-center w200">
									<input class="form-control mb-xs w100" style="display:unset" type="number" placeholder="Adet" name="ilac_adet" id="<?php echo $ilac->id ?>">	
									<button type="button" class="btn btn-success btn-sm w100 btn-outline sepete-ekle"
										data-id="<?php echo $ilac->id ?>" 
										data-barkod="<?php echo $ilac->barkod ?>" 
										data-adi="<?php echo $ilac->ilac_adi ?>" 
										data-fiyat="<?php echo $ilac->ilac_fiyati ?>" 
										data-stok="<?php echo $ilac->stok ?>" 
									><i class="fa fa-shopping-basket"></i>Sepete Ekle</button>
								</td>
								
							</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		<?php } ?>
	</div>
</section>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script>
	
	$(document).ready(function(){
		
		$(".sepete-ekle").click(function(){
			var id = $(this).data("id");
			var barkod = $(this).data("barkod");
			var ilacAdi = $(this).data("adi");
			var ilacFiyat = $(this).data("fiyat");
			var quantity = $('#' + id).val();
			var stok = $(this).data("stok");
			
			if(quantity > stok){
				alert("Bu ilaç stoklarda " + stok + " adet bulunmaktadır. Daha fazla eklenemez.")
			}else{
				if(quantity < 1){
					alert("Adet değeri en az 1 olmalı.")
				}else{
					$.ajax({
						url: "<?php echo base_url(); ?>sepete-ekle",
						method:"POST",
						data:{
							'id'       : id,
							'barkod'   : barkod,
							'ilacAdi'  : ilacAdi,
							'ilacFiyat': ilacFiyat,
							'quantity' : quantity,
							'<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>',
						},
						success:function(){
						 alert("Ürün sepete başarıyla eklendi.");
						}
				   });		
				}
			}
		})
	});


</script>