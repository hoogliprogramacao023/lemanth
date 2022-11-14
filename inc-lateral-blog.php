

				 		<!-- SIDEBAR -->
						<aside id="sidebar" class="col-lg-4">


							<!-- SEARCH FIELD --> 
							

							<!--<div id="txt-widget" class="sidebar-div mb-50">-->
							<!--	<h5 class="h5-sm gold-color">Nossos Especialistas</h5>-->
							<!--	<div class="txt-widget-unit mb-15 clearfix d-flex align-items-center">-->
							<!--		<div class="txt-widget-avatar">-->
							<!--			<img src="<?php echo SITE_URL;?>/img/<?php echo $especialistaIndividual->foto;?>" alt="<?php echo $especialistaIndividual->url_amigavel;?>" title="<?php echo $especialistaIndividual->url_amigavel;?>">-->
							<!--		</div>-->
							<!--		<div class="txt-widget-data">-->
							<!--			<h5 class="h5-md gold-color"><?php echo $especialistaIndividual->nome;?></h5>	-->
							<!--			<span><?php echo $especialistaIndividual->especialidade;?></span>	-->
							<!--			<p class="blue-color"><?php echo $especialistaIndividual->telefone;?></p>	-->
							<!--		</div>-->
							<!--	</div>-->
							<!--	<p class="p-sm"><?php echo $especialistaIndividual->breve;?></p>-->
							<!-- 	<a href="<?php echo SITE_URL;?>/especialista/<?php echo $especialistaIndividual->url_amigavel;?>" class="btn btn-orange orange-hover">Ver Mais</a> -->
							<!--</div>-->

							<!-- <div class="blog-categories sidebar-div mb-50">
								<h5 class="h5-sm gold-color">Categories</h5>
								<ul class="blog-category-list clearfix">
									<li><a href="#"><i class="fas fa-angle-double-right blue-color"></i> Elderly Care</a> <span>(5)</span></li>
									<li><a href="#"><i class="fas fa-angle-double-right blue-color"></i> Lifestyle</a> <span>(13)</span></li>
									<li><a href="#"><i class="fas fa-angle-double-right blue-color"></i> Medical</a> <span>(6)</span></li>
									<li><a href="#"><i class="fas fa-angle-double-right blue-color"></i> Treatment </a> <span>(8)</span></li>
									<li><a href="#"><i class="fas fa-angle-double-right blue-color"></i> Pharma</a> <span>(12)</span></li>
								</ul>
							</div> -->


							<!-- POPULAR POSTS -->
							<div class="popular-posts sidebar-div mb-50">
									
								<!-- Title -->
								<h1 class="h5-sm">Posts Recentes</h1>

								<ul class="popular-posts">
								
									<!-- Popular post #1 -->
									<?php foreach($outrosBlog as $outroBlog){?>
									<li class="clearfix d-flex align-items-center">

										<!-- Image -->
										<img class="img-fluid" src="<?php echo SITE_URL;?>/img/<?php echo $outroBlog->foto;?>" alt="<?php echo $outroBlog->descricao_imagem;?>" title="<?php echo $outroBlog->legenda_imagem;?>" width="150" />

										<!-- Text -->
										<div class="post-summary">
											<a href="<?php echo SITE_URL;?>/blog/<?php echo $outroBlog->url_amigavel;?>"><?php echo $outroBlog->titulo;?></a>
										</div>

									</li>
									<?php }?>
								
								</ul>

							</div>

						<div class="sidebar-timetable sidebar-div mb-50">
								<h5 class="h5-md mb-20"><?php echo $textoLateral->titulo;?></h5>
								<p class="p-sm"><?php echo $textoLateral->texto;?></p>
								<a href="<?php echo SITE_URL;?>/contato" class="btn btn-bege bege-hover mt-10"><?php echo $textoLateral->titulo2;?></a>
							</div>


							<!-- IMAGE WIDGET -->						
							<!--<div class="image-widget sidebar-div mb-50">-->
							<!--	<a href="<?php echo SITE_URL;?>/sobre">-->
							<!--		<img class="img-fluid" src="<?php echo SITE_URL;?>/images/frase.jpg" alt="Frase Lateral" title="Frase Lateral" />-->
							<!--	</a>																		-->
							<!--</div>-->


						</aside>	<!-- END SIDEBAR -->