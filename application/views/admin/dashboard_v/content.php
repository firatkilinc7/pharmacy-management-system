<?php $user_permission = get_user_permission();?>

<section class="panel">
    <header class="panel-heading">
        <h2 class="panel-title">Dashboard</h2>
    </header>
	
	<div class="panel-body">
		<div class="col-md-3">
			<div class="card">
				<div class="card-body">
					<h5 class="card-title">Satış Miktarı <span>| Günlük</span></h5>
					<div class="d-flex align-items-center">
						  <h3 class="mt-xs"><?php echo $gunluk_satis ?> ₺</h3>
						  <span class="text-success small pt-1 fw-bold"><?php echo $dune_gore_fark ?>%</span> <span class="text-muted small pt-2 ps-1"><?php echo ($dune_gore_fark > 0) ? "artış" : "azalış" ?> (geçen güne göre)</span>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-3">
			<div class="card">
				<div class="card-body">
					<h5 class="card-title">Satış Miktarı <span>| Haftalık</span></h5>
					<div class="d-flex align-items-center">
						  <h3 class="mt-xs"><?php echo $haftalik_satis ?> ₺</h3>
						  <span class="text-success small pt-1 fw-bold"><?php echo $onceki_haftaya_gore_fark ?>%</span> <span class="text-muted small pt-2 ps-1"><?php echo ($onceki_haftaya_gore_fark > 0) ? "artış" : "azalış" ?> (geçen haftaya göre)</span>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-3">
			<div class="card">
				<div class="card-body">
					<h5 class="card-title">Satış Miktarı <span>| Aylık</span></h5>
					<div class="d-flex align-items-center">
						  <h3 class="mt-xs"><?php echo $aylik_satis ?> ₺</h3>
						  <span class="text-success small pt-1 fw-bold"><?php echo $onceki_aya_gore_fark ?>%</span> <span class="text-muted small pt-2 ps-1"><?php echo ($onceki_aya_gore_fark > 0) ? "artış" : "azalış" ?> (geçen aya göre)</span>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-3">
			<div class="card info-card sales-card">	
				<div class="card-body">
					<h5 class="card-title">Satış Miktarı <span>| Yıllık</span></h5>
					<div class="d-flex align-items-center">
						  <h3 class="mt-xs"><?php echo $yillik_satis ?> ₺</h3>
						  <span class="text-success small pt-1 fw-bold"><?php echo $onceki_yila_gore_fark ?>%</span> <span class="text-muted small pt-2 ps-1"><?php echo ($onceki_yila_gore_fark > 0) ? "artış" : "azalış" ?> (geçen yıla göre)</span>
					</div>
				</div>
			</div>
		</div>
		
		<div>
			<?php 
				$yil = date('Y');
			
				for($ilk_siparis_yili; $ilk_siparis_yili <= $yil; $ilk_siparis_yili++){?>
					
					<a href="<?php echo base_url("dashboard/".$ilk_siparis_yili) ?>" class="btn btn-xl btn-primary"><?php echo $ilk_siparis_yili ?></a>
					
				<?php } ?>
		</div>
		
		<div id="column_aylik" style="float:left"></div>
		<div id="pie_eczacilar" style="float:left"></div>
	
	</div>
</section>





<script type="text/javascript">

google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(drawChart);

function drawChart() {
  var data = google.visualization.arrayToDataTable([
         ['Ay', 'Toplam Satış', { role: 'style' }],
         ['Ocak', <?php echo $yillik_satislar[0] ?>, '#b87333'],            
         ['Şubat', <?php echo $yillik_satislar[1] ?>, 'silver'],            
         ['Mart', <?php echo $yillik_satislar[2] ?>, 'gold'],
         ['Nisan', <?php echo $yillik_satislar[3] ?>, 'gold'],
         ['Mayıs', <?php echo $yillik_satislar[4] ?>, 'gold'],
         ['Haziran', <?php echo $yillik_satislar[5] ?>, 'gold'],
         ['Temmuz', <?php echo $yillik_satislar[6] ?>, 'gold'],
         ['Ağustos', <?php echo $yillik_satislar[7] ?>, 'gold'],
         ['Eylül', <?php echo $yillik_satislar[8] ?>, 'gold'],
         ['Ekim', <?php echo $yillik_satislar[9] ?>, 'gold'],
         ['Kasım', <?php echo $yillik_satislar[10] ?>, 'gold'],
         ['Aralık', <?php echo $yillik_satislar[11] ?>, 'gold'],
      ]);

  var options = {'title': "Yıllık Satış", 'width':550, 'height':400};
  var chart = new google.visualization.ColumnChart(document.getElementById('column_aylik'));
  
  chart.draw(data, options);
}
</script>



<script type="text/javascript">

google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(drawChart2);

function drawChart2() {
  var data = google.visualization.arrayToDataTable([
  ['Üye Rolü', 'Üye Sayısı'],
  <?php
		$i = 0;
		foreach($eczacilar as $eczaci){
			echo "[\"{$eczaci->full_name}\", {$eczacilar_aylik_satis[$i][$eczaci->user_name]}],";
			$i++;
		}
	?>
]);

  var options = {'title':'Eczacılara Göre Aylık Satış', 'width':550, 'height':400};
  var chart = new google.visualization.PieChart(document.getElementById('pie_eczacilar'));
  
  chart.draw(data, options);
}
</script>

