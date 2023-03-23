<section class="panel">
    <header class="panel-heading">
        <a href="<?php echo base_url("ilaclar/new_form"); ?>" class="btn btn-outline btn-primary btn-xs pull-right"> <i class="fa fa-plus"></i> Yeni Ekle</a>
        <h2 class="panel-title">İlaç Listesi</h2>
    </header>
    <div class="panel-body">

        <?php if(empty($ilaclar)) { ?>
			<div class="alert alert-info text-center">
				<p>Burada herhangi bir veri bulunmamaktadır. Eklemek için lütfen <a href="<?php echo base_url("ilaclar/new_form"); ?>">tıklayınız</a></p>
			</div>
			
        <?php } else { ?>
		
			<div class="table-responsive">
				<table class="table table-bordered table-striped mb-none">
					<thead>
						<th class="w50">id</th>
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
								<td class="w50 text-center"><?php echo $ilac->id; ?></td>
								<td><?php echo $ilac->barkod; ?></td>
								<td><?php echo $ilac->ilac_adi; ?></td>
								<td class="text-center"><?php echo $ilac->stok; ?></td>
								<td class="text-center"><?php echo $ilac->raf_numarasi; ?></td>
								<td class="text-center">%<?php echo $ilac->sgk_indirim; ?></td>                
								<td class="text-center"><?php echo $ilac->expired_date; ?></td>                
								<td class="text-center"><?php echo $ilac->ilac_fiyati; ?></td>                
								<td class="text-center"><?php echo $ilac->indirimli_fiyat; ?></td>
								<td class="text-center w100">
									<img width="150" src="<?php echo get_picture("images/$viewFolder",$ilac->img_url, "900x600"); ?>" alt="<?php echo $ilac->ilac_adi?>" class="img-rounded">
								</td>
								<td class="text-center w200">
									<button
										data-url="<?php echo base_url("ilaclar/delete/$ilac->id"); ?>"
										class="btn btn-sm btn-danger btn-outline remove-btn">
										<i class="fa fa-trash"></i> Sil
									</button>
									<a href="<?php echo base_url("ilaclar/update_form/$ilac->id"); ?>" class="btn btn-sm btn-primary btn-outline"><i class="fa fa-pencil-square-o"></i> Düzenle</a>
									
								</td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		<?php } ?>
	</div>
</section>