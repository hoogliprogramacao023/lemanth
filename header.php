<?php 
require_once "Class/servicos.class.php";
$servicosHeader = Servicos::getInstance(Conexao::getInstance());
$puxaServicosHeader = $servicosHeader->rsDados();

?>
			<header id="header" class="header">
				<!-- MOBILE HEADER -->
			    <div class="wsmobileheader clearfix">
			    	<a id="wsnavtoggle" class="wsanimated-arrow"><span></span></a>
			    	<a href="<?php echo SITE_URL;?>"><span class="smllogo"><img src="<?php echo SITE_URL;?>/img/<?php echo $infoSistema->logo_mobile;?>" alt="mobile logo" title="mobile logo" width="180"/></span></a>
			    <!--	<a href="tel:123456789" class="callusbtn"><i class="fas fa-phone"></i></a> -->
			 	</div>

			  	<div class="wsmainfull menu clearfix">
    				<div class="wsmainwp clearfix">

    					<div class="desktoplogo"><a href="<?php echo SITE_URL;?>"><img src="<?php echo SITE_URL;?>/img/<?php echo $infoSistema->logo_principal;?>"  alt="logo menu" title="logo menu" width="180"></a></div>

      					<nav class="wsmenu clearfix">
						  <ul class="wsmenu-list">
                                 <li class="nl-simple" aria-haspopup="true"><a href="<?php echo SITE_URL;?>">Home</a></li>
                               <li class="nl-simple" aria-haspopup="true"><a href="<?php echo SITE_URL;?>/sobre">Sobre</a></li>
                               <li aria-haspopup="true"><a href="#">Serviços <span class="wsarrow"></span></a>
					            	<div class="wsmegamenu clearfix ">
					              		<div class="container-fluid">
					                		<div class="row">

					                			<?php foreach($puxaServicosHeader as $puxaTreinamentoHeader){?>
					                			<ul class="col-lg-3 col-md-12 col-xs-12 link-list">
					           			<li ><a href="<?php echo SITE_URL;?>/servico/<?php echo $puxaTreinamentoHeader->url_amigavel;?>"><?php echo $puxaTreinamentoHeader->titulo;?></a></li>
					           			</ul>
					           			<?php }?>
							              
					                		</div>
					              		</div>
					            	</div>
					          	</li>
							   <!--<li aria-haspopup="true"><a href="#">Serviços <span class="wsarrow"></span></a>-->
					     <!--      		<ul class="sub-menu">-->
					     <!--      		    <?php foreach($puxaServicosHeader as $puxaTreinamentoHeader){?>-->
					     <!--      			<li aria-haspopup="true"><a href="<?php echo SITE_URL;?>/servico/<?php echo $puxaTreinamentoHeader->url_amigavel;?>"><?php echo $puxaTreinamentoHeader->titulo;?></a></li>-->
					     <!--      			<?php }?>-->
					              	
					     <!--      		</ul>-->
					     <!--     	</li>-->
							   <li class="nl-simple" aria-haspopup="true"><a href="<?php echo SITE_URL;?>/blog">Blog</a></li>
								<li class="nl-simple" aria-haspopup="true"><a href="<?php echo SITE_URL;?>/contato">Contato</a></li>
        					</ul>
        				</nav>

    				</div>
    			</div>	
			</header>	