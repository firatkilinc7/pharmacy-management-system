<section class="panel">
    <header class="panel-heading">
        <h2 class="panel-title">İlaç İste</h2>
    </header>
    <div class="panel-body">

        <?php if(empty($expired_and_stockout)) { ?>
			<div class="alert alert-info text-center">
				<p>Tarihi geçmiş veya stoğu bitmiş hiç ilaç yok.</p>
			</div>
			
        <?php } else { ?>
		
			<div class="table-responsive">
				<table class="table table-bordered table-striped mb-none">
					<thead>
						<th class="w100">Sebebi</th>
						<th>Barkod No</th>
						<th>İlaç Adı</th>
						<th>Stokta Bulunan Adet</th>
						<th>İlacın Bulunduğu Raf</th>
						<th>Son Kullanma Tarihi</th>
						<th>İlaç Fiyatı</th>
						<th>İlaç Resmi</th>
					</thead>
					
					<tbody>
					
						<?php foreach($expired_and_stockout as $ilaclar) { ?>
							<tr>
								<td class="w50 text-center"><?php echo $ilaclar->stok == 0 ? "Stoğu Bitmiş" : "Tarihi Geçmiş" ?></td>
								<td><?php echo $ilaclar->barkod; ?></td>
								<td><?php echo $ilaclar->ilac_adi; ?></td>
								<td class="text-center"><?php echo $ilaclar->stok; ?></td>
								<td class="text-center"><?php echo $ilaclar->raf_numarasi; ?></td>              
								<td class="text-center"><?php echo $ilaclar->expired_date; ?></td>                
								<td class="text-center"><?php echo $ilaclar->ilac_fiyati; ?></td>                
								<td class="text-center w100">
									<img width="150" src="<?php echo get_picture("images/$viewFolder",$ilaclar->img_url, "900x600"); ?>" alt="<?php echo $ilaclar->ilac_adi?>" class="img-rounded">
								</td>
								
							</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		<?php } ?>
		
		<div class="w200 mt-md" style="float: right;">
			
			<div class="w200 text-center">
				<a href="<?php echo base_url("ilaclar/ilac-iste/onayla")?>" class="btn btn-sm btn-dark btn-outline w200"><i class="fa fa-check"></i> İlaçları İste</a>
			</div>
			
		</div>
		
	</div>
</section>