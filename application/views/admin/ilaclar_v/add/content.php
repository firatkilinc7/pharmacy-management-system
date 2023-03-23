<div class="row">
  <div class="col-lg-12">
    <section class="panel">
      <header class="panel-heading">
        <div class="panel-actions"> </div>
        <h2 class="panel-title">İlaç Ekle</h2>
      </header>
      <div class="panel-body">
        <form class="form-horizontal form-bordered" action="<?php echo base_url("ilaclar/save"); ?>" method="post" enctype="multipart/form-data" method="post">
          <div class="form-group">
            <label class="col-md-2 control-label">Barkod No</label>
            <div class="col-md-6">
              <input class="form-control" placeholder="İlacın barkod numarasını girin" name="barkod" value="<?php echo isset($form_error) ? set_value("barkod") : ""; ?>">
              <?php if(isset($form_error)){ ?>
              <small class="pull-right input-form-error"> <?php echo form_error("barkod"); ?></small>
              <?php } ?>
            </div>
          </div>

          <div class="form-group">
            <label class="col-md-2 control-label">İlaç Adı</label>
            <div class="col-md-6">
             <input class="form-control" placeholder="İlacın adını girin" name="ilac_adi" value="<?php echo isset($form_error) ? set_value("ilac_adi") : ""; ?>">
             <?php if(isset($form_error)){ ?>
             <small class="pull-right input-form-error"> <?php echo form_error("ilac_adi"); ?></small>
             <?php } ?>
           </div>
         </div>

         <div class="form-group">
           <label class="col-md-2 control-label">Stok Durumu</label>
           <div class="col-md-6">
             <input class="form-control" type="number" placeholder="İlacın stokta bulunan adedini girin" name="stok" value="<?php echo isset($form_error) ? set_value("stok") : ""; ?>">
             <?php if(isset($form_error)){ ?>
             <small class="pull-right input-form-error"> <?php echo form_error("stok"); ?></small>
             <?php } ?>
           </div>
         </div>

		 <div class="form-group">
            <label class="col-md-2 control-label">İlacın Bulunduğu Raf</label>
            <div class="col-md-6">
             <input class="form-control" placeholder="İlacın bulunduğu raf" name="raf_numarasi" value="<?php echo isset($form_error) ? set_value("raf_numarasi") : ""; ?>">
             <?php if(isset($form_error)){ ?>
             <small class="pull-right input-form-error"> <?php echo form_error("raf_numarasi"); ?></small>
             <?php } ?>
           </div>
         </div>

         <div class="form-group">
          <label class="col-md-2 control-label">SGK İndirim Oranı (%)</label>
          <div class="col-md-6">
			<input class="form-control" type="number" oninput="sgkIndirim()" placeholder="İlacın SGK indirim oranını girin" name="sgk_indirim" id="sgk_indirim">
			<?php if(isset($form_error)){ ?>
            <small class="pull-right input-form-error"> <?php echo form_error("sgk_indirim"); ?></small>
            <?php } ?>
          </div>
        </div>

        <div class="form-group">
          <label class="col-md-2 control-label">Son Kulanma Tarihi</label>
          <div class="col-md-6">
           <input class="form-control" type="date" placeholder="İlacın son kullanma tarihini girin" name="expired_date">
           <?php if(isset($form_error)){ ?>
           <small class="pull-right input-form-error"> <?php echo form_error("expired_date"); ?></small>
           <?php } ?>
         </div>
       </div>
		
		<div class="form-group">
          <label class="col-md-2 control-label">İlaç Fiyatı (İndirimsiz)</label>
          <div class="col-md-6">
			<input class="form-control" type="number" oninput="sgkIndirim()" placeholder="İlacın indirimsiz fiyatını girin" name="ilac_fiyati" id="ilac_fiyati">
			<?php if(isset($form_error)){ ?>
            <small class="pull-right input-form-error"> <?php echo form_error("ilac_fiyati"); ?></small>
            <?php } ?>
          </div>
        </div>
		
		<div class="form-group">
          <label class="col-md-2 control-label">İlaç Fiyatı (SGK İndirimli)</label>
          <div class="col-md-6">
			<input readonly class="form-control" type="number" step="0.001" placeholder="İlacın SGK indirimli fiyatı bilgileri girdikten sonra hesaplanır" name="indirimli_fiyat" id="indirimli_fiyat">
          </div>
        </div>
		
		<div class="form-group image_upload_container">
		  <label class="col-md-2 control-label">İlaç Görseli Seçiniz</label>
          <div class="col-md-6">
            <input type="file" name="img_url" class="form-control">
          </div>
        </div>

      <div class="form-group ">
        <div class="col-md-2 pull-right">
           <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
          <button type="submit" class="btn btn-primary btn-md btn-outline">Kaydet</button>
          <a href="<?php echo base_url("ilaclar"); ?>" class="btn btn-md btn-danger btn-outline">İptal</a>
        </div>
      </div>
    </form>
  </div>
</section>
</div>
</div>

<script>
	function sgkIndirim(){
		var indirim = document.getElementById("sgk_indirim").value;
		var ilacFiyat = document.getElementById("ilac_fiyati").value;
		
		
		var indirimliFiyat = ilacFiyat - (ilacFiyat * indirim/100);
		document.getElementById("indirimli_fiyat").value = indirimliFiyat.toFixed(2);
		

		
	}
</script>
