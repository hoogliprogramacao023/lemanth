<?php 
require_once "Class/textos.class.php";
$textosRodape 	= Textos::getInstance(Conexao::getInstance());
$textoRodape = $textosRodape->rsDados(4);?>
			<footer id="footer-3" class="bg-image pt-40 footer division pb-40">
				<div class="container">
					<div class="row">	
						<div class="col-md-6 col-lg-3">
							<div class="footer-info mb-40">
							<h5 class="white-color mb-40">Sobre</h5>
								<p class="p-sm mt-40"><?php echo $textoRodape->texto;?></p>
							</div>	
						</div>
						<div class="col-md-6 col-lg-3 ">
							<div class="footer-links mb-40 pt-10">
								<h5 class="white-color mb-40">Site Map</h5>
								<ul class="foo-links clearfix">
									<li><a href="<?php echo SITE_URL;?>">Home</a></li>
									<li><a href="<?php echo SITE_URL;?>/sobre">Quem somos</a></li>
									<li><a href="<?php echo SITE_URL;?>/blog">Blog</a></li>
									<li><a href="<?php echo SITE_URL;?>/contato">Contato</a></li>					
								</ul>
							</div>
						</div>
						<div class="col-md-6 col-lg-3 ">
							<div class="footer-box mb-40 pt-10">
								<h5 class="white-color mb-40">Nossa localização</h5>
								<p><?php echo $infoSistema->endereco;?></p> 
								<p>CEP: <?php echo $infoSistema->cep_loja;?></p>
								<p class="foo-email mt-20"><a href="mailto:<?php echo $infoSistema->email1;?>"><?php echo $infoSistema->email1;?></a></p>
								<p class="white-color"><?php echo $infoSistema->telefone1;?></p>
								<p class="white-color"><?php echo $infoSistema->telefone2;?></p>
							</div>
						</div>
						<div class="col-md-6 col-lg-3 ">
							<div class="footer-links mb-40 pt-10 ">
								<h5 class="white-color mb-40">Siga-nos</h5>
								<div class="footer-socials-links mt-20">
									<ul class="foo-socials text-center clearfix">
										<?php if(isset($infoSistema->instagram) && !empty($infoSistema->instagram)){?>
                                    <li><a href="<?php echo $infoSistema->instagram;?>" target="_blank" class="ico-instagram"><i class="fab fa-instagram"></i></a></li>	
                                    <?php }?>
                                    <?php if(isset($infoSistema->youtube) && !empty($infoSistema->youtube)){?>
                                    <li><a href="<?php echo $infoSistema->youtube;?>" target="_blank" class="ico-youtube"><i class="fab fa-youtube"></i></a></li>	
                                    <?php }?>
                                    <?php if(isset($infoSistema->twitter) && !empty($infoSistema->twitter)){?>
                                    <li><a href="<?php echo $infoSistema->twitter;?>" target="_blank" class="ico-twitter"><i class="fab fa-twitter"></i></a></li>
                                    <?php }?>
									<?php if(isset($infoSistema->linkedln) && !empty($infoSistema->linkedln)){?>
                                    <li><a href="<?php echo $infoSistema->linkedln;?>" target="_blank" class="ico-linkedin"><i class="fab fa-linkedin-in"></i></a></li>
                                    <?php }?>
                                    <?php if(isset($infoSistema->facebook) && !empty($infoSistema->facebook)){?>
                                    <li><a href="<?php echo $infoSistema->facebook;?>" target="_blank" class="ico-facebook"><i class="fab fa-facebook-f"></i></a></li>
                                    <?php }?>
									</ul>									
								</div> 
							</div>
						</div>
					</div>
					<div class="bottom-footer">
						<div class="row">
							<div class="col-md-3 logo-rodape">
								<img src="<?php echo SITE_URL;?>/img/<?php echo $infoSistema->logo_rodape;?>" width="180" alt="Logo Rodapé" title="Logo Rodapé" class="logo" style="filter: brightness(100);">
							</div>
							<div class="col-md-9">
							<?php include "copy.php";?>
							</div>
						</div>
					</div>
				</div>
			</footer>
			<?php include"flutuante/flutuante.php"?>
			