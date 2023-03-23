<?php $user_permission = get_user_permission()?>

<aside id="sidebar-left" class="sidebar-left">
	
	<div class="sidebar-header">
		<div class="sidebar-title">Menü</div>
		<div class="sidebar-toggle hidden-xs" data-toggle-class="sidebar-left-collapsed" data-target="html" data-fire-event="sidebar-left-toggle">
			<i class="fa fa-bars" aria-label="Toggle sidebar"></i>
		</div>
	</div>
	
	<div class="nano">
		<div class="nano-content">
			<nav id="menu" class="nav-main" role="navigation">
				<ul class="nav nav-main">
					
					<!-- BÜTÜN KULLANICILAR İÇİN GÖZÜKÜR!!-->
					<?php if($user_permission>0){?>
						
						<li>
							<a href="<?php echo base_url('dashboard') ?>">
								<i class="fa fa-home" aria-hidden="true"></i>
								<span>Ana Sayfa</span>
							</a>
						</li>
						
						<li><a href="<?php echo base_url('ilaclar'); ?>"><i class="fa fa-medkit" aria-hidden="true"></i>İlaçlar</a></li>
						
						<li><a href="<?php echo base_url('stockout'); ?>"><i class="fa fa-medkit" aria-hidden="true"></i>Stokta Biten İlaçlar</a></li>
					
						<li><a href="<?php echo base_url('expired'); ?>"><i class="fa fa-medkit" aria-hidden="true"></i>Tarihi Geçen İlaçlar</a></li>
						
						<li><a href="<?php echo base_url('ilaclar/ilac-iste'); ?>"><i class="fa fa-truck" aria-hidden="true"></i>İlaç İste</a></li>
						
						<li><a href="<?php echo base_url('satis'); ?>"><i class="fa fa-cart-plus" aria-hidden="true"></i>İlaç Satışı</a></li>
						
					<?php }?>
								
					
					<!-- SADECE ADMİN İÇİN GÖZÜKÜR!!-->
					<?php if($user_permission==2){?>
					
					<li><a href="<?php echo base_url('kullanicilar'); ?>"><i class="fa fa-user-md" aria-hidden="true"></i>Kullanıcılar</a></li>
					
					
					<?php }?>
					
				</ul>
			</nav>
			
			
		</div>
		
	</div>
	
</aside>

<style>

	li {
	  padding: 1rem;
	  transition-duration: 0.5s;
	}

</style>