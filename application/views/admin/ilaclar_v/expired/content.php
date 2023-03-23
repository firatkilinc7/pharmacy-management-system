<section class="panel">
    <header class="panel-heading">
        <h2 class="panel-title">Tarihi Geçmiş İlaçlar Listesi</h2>
    </header>
    <div class="panel-body">

        <?php if(empty($expired_ilaclar)) { ?>
			<div class="alert alert-info text-center">
				<p>Tarihi geçmiş ilaç bulunmamaktadır.</p>
			</div>
			
        <?php } else { ?>
		
			<div class="table-responsive">
				<table class="table table-bordered table-striped mb-none">
					<thead>
						<th>Durum</th>
						<th>Barkod No</th>
						<th>İlaç Adı</th>
						<th>Stokta Bulunan Adet</th>
						<th>İlacın Bulunduğu Raf</th>
						<th>SGK İndirim Oranı (%)</th>
						<th>Son Kullanma Tarihi</th>
						<th>İlaç Fiyatı</th>
						<th>İndirimli Fiyatı</th>
						<th>İlaç Resmi</th>
						<th>İşlem</th>
					</thead>
					
					<tbody>

						<?php foreach($expired_ilaclar as $expired_ilac) { ?>
							<tr>
								<td class="text-center"><?php echo $expired_ilac->istendi == "1" ? "Depodan İstendi" : "Bekliyor"; ?></td>
								<td><?php echo $expired_ilac->barkod; ?></td>
								<td><?php echo $expired_ilac->ilac_adi; ?></td>
								<td class="text-center"><?php echo $expired_ilac->stok; ?></td>
								<td class="text-center"><?php echo $expired_ilac->raf_numarasi; ?></td>
								<td class="text-center">%<?php echo $expired_ilac->sgk_indirim; ?></td>                
								<td class="text-center"><?php echo $expired_ilac->expired_date; ?></td>                
								<td class="text-center"><?php echo $expired_ilac->ilac_fiyati; ?></td>                
								<td class="text-center"><?php echo $expired_ilac->indirimli_fiyat; ?></td>
								<td class="text-center w100">
									<img width="150" src="<?php echo get_picture("images/$viewFolder",$expired_ilac->img_url, "900x600"); ?>" alt="<?php echo $expired_ilac->ilac_adi?>" class="img-rounded">
								</td>
								<td class="text-center w300">
									<button
										data-url="<?php echo base_url("ilaclar/delete/$expired_ilac->id"); ?>"
										class="btn btn-sm btn-danger btn-outline remove-btn">
										<i class="fa fa-trash"></i> Sistemden Sil
									</button>
									<a href="<?php echo base_url("ilaclar/delete_stock/$expired_ilac->id"); ?>" class="btn btn-sm btn-primary btn-outline"><i class="fa fa-pencil-square-o"></i> Stoğu Kapat</a>
									
								</td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		<?php } ?>
	</div>
</section>