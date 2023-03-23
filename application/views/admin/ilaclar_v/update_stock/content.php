<div class="row">
  <div class="col-lg-12">
    <section class="panel">
      <header class="panel-heading">
        <div class="panel-actions"> </div>
        <h2 class="panel-title"><b><?php echo $ilac->ilac_adi; ?></b> <em>adlı ilacın stoğunu düzenliyorsunuz.</em> </h2>
      </header>
      <div class="panel-body">
        <form class="form-horizontal form-bordered" action="<?php echo base_url("ilaclar/update_stock/$ilac->id"); ?>" method="post" method="post">

         <div class="form-group">
          <label class="col-md-2 control-label">Barkod No</label>
          <div class="col-md-10">
            <input disabled class="form-control" placeholder="Barkod no giriniz" name="barkod" value="<?php echo isset($form_error) ? set_value("barkod") : $ilac->barkod ; ?>">
          </div>
        </div>

        <div class="form-group">
         <label class="col-md-2 control-label">İlaç Adı</label>
         <div class="col-md-10">
          <input disabled class="form-control" placeholder="İlacın adını girin" name="ilac_adi" value="<?php echo isset($form_error) ? set_value("ilac_adi") : $ilac->ilac_adi; ?>">
        </div>
      </div>

      <div class="form-group">
        <label class="col-md-2 control-label">Stok Durumu</label>
        <div class="col-md-10">
          <input class="form-control" type="number" placeholder="İlacın stok durumunu girin" name="stok" value="<?php echo isset($form_error) ? set_value("stok") : $ilac->stok; ?>">
          <?php if(isset($form_error)){ ?>
          <small class="pull-right input-form-error"> <?php echo form_error("stok"); ?></small>
          <?php } ?>
        </div>
        </div>
		
		<div class="form-group">
         <label class="col-md-2 control-label">İlacın Bulunduğu Raf</label>
         <div class="col-md-10">
          <input disabled class="form-control" placeholder="İlacın adını girin" name="raf_numarasi" value="<?php echo isset($form_error) ? set_value("raf_numarasi") : $ilac->raf_numarasi; ?>">
        </div>
        </div>
		
	   <div class="form-group">
          <label class="col-md-2 control-label">SGK İndirim Oranı (%)</label>
          <div class="col-md-6">
			<input disabled class="form-control" type="number" placeholder="İlacın SGK indirim oranını girin" name="sgk_indirim" value="<?php echo $ilac->sgk_indirim?>">
          </div>
        </div>

        <div class="form-group">
          <label class="col-md-2 control-label">Son Kullanma Tarihi</label>
          <div class="col-md-6">
           <input disabled class="form-control" type="date" placeholder="İlacın son kullanma tarihini girin" name="expired_date" value="<?php echo $ilac->expired_date?>">
         </div>
       </div>
	   
	   <div class="form-group">
          <label class="col-md-2 control-label">İlaç Fiyatı</label>
          <div class="col-md-6">
			<input disabled class="form-control" type="number" placeholder="İlacın indirimsiz fiyatını girin" name="ilac_fiyati" value="<?php echo $ilac->ilac_fiyati?>">
          </div>
        </div>
		
		<div class="form-group">
          <label class="col-md-2 control-label">İndirimli fiyat</label>
          <div class="col-md-6">
			<input disabled class="form-control" type="number" placeholder="İlacın SGK indirim oranını girin" name="indirimli_fiyat" value="<?php echo $ilac->indirimli_fiyat?>">
          </div>
        </div>
		
		<div class="form-group image_upload_container">
			<label class="col-md-2 control-label">İlaç Görseli</label>
			<div class="col-md-2 image_upload_container">
				<img src="<?php echo get_picture("images/$viewFolder", $ilac->img_url,"900x600"); ?>" alt="<?php echo $ilac->ilac_adi ?>" class="img-responsive">
			</div>
		</div>

        <div class="form-group ">
          <div class="col-md-3">
             <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
            <button type="submit" class="btn btn-primary btn-md">Güncelle</button>
            <a href="<?php echo base_url("ilaclar"); ?>" class="btn btn-md btn-danger btn-outline">İptal</a>
          </div>
        </div>
      </form>
    </div>
