<?php include "includes.php";
include "Class/textos.class.php";

$textos 	= Textos::getInstance(Conexao::getInstance());

$texto = $textos->rsDados(19);

/**** ALTERAR OS CAMPOS ABAIXO ****/
// informar as chaves do ReCaptcha abaixo:
$chave_de_site = '6Le3jccbAAAAAA35WxF9URLY6I0BUQKuc8TL43YT';
$chave_secreta = '6Le3jccbAAAAACL4iAOcJ8dj8rTMhgSdNkkR69Y_';

// definir
//$destinatario = 'adrianodevops@gmail.com';
$destinatario = 'contato@lemanth.com.br';
$remetente = 'contato@lemanth.com.br';
$assunto = 'Contato pelo site';
$redirecionar_para = '/sucesso';
/**** FIM DAS ALTERAÇÕES ****/

if (isset($_POST['acao']) && $_POST['acao'] == "enviarMensagem")
{
	// incluir a funcionalidade do recaptcha
	require_once('recaptchalib.php');

	$erros = [];
	if (empty($_POST['nome']))
		$erros[] = 'Nome não preenchido';

	if (empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
		$erros[] = 'E-mail não preenchido ou inválido';

	if (empty($_POST['telefone']))
		$erros[] = 'Telefone não preenchido';


	if (empty($_POST['mensagem']))
		$erros[] = 'Mensagem não fornecida';

	// verificar a chave secreta
	$response = null;
	$reCaptcha = new ReCaptcha($chave_secreta);

	if ($_POST['g-recaptcha-response'])
		$response = $reCaptcha->verifyResponse($_SERVER['REMOTE_ADDR'], $_POST['g-recaptcha-response']);

	if ($response == null || !$response->success)
		$erros[] = 'Erro na verificação do Recaptcha';

	if (!$erros)
	{
		$ip = $_SERVER['REMOTE_ADDR'];
		$reverso = gethostbyaddr($ip);
		if ($reverso == $ip)
			$origem = $ip;
		else
			$origem = "$ip ($reverso)";
		$de = "\"$_POST[nome]\" <$_POST[email]>";

		$corpo = "De: $de
Telefone: $_POST[telefone]
Assunto: $_POST[assunto]
Mensagem:
$_POST[mensagem]";

		$headers = "From: $remetente\n";
		$headers .= "Reply-To: $de";

		if (mail($destinatario, $assunto, $corpo, $headers, "-f$remetente"))
		{
			header("Location: $redirecionar_para");
			exit;
		}
		else
			$erros[] = 'Erro ao mandar seu e-mail, por favor tente novamente mais tarde';
	}
}

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no" />
	<?php include "description.php";?>
	<link href="<?php echo SITE_URL;?>/css/bootstrap.min.css?v=<?php echo version;?>" rel="stylesheet" />
	<!-- FONT ICONS -->
	<link href="https://use.fontawesome.com/releases/v5.7.2/css/all.css?v=<?php echo version;?>" rel="stylesheet" />
	<link href="<?php echo SITE_URL;?>/css/flaticon.css?v=<?php echo version;?>" rel="stylesheet" />
	<!-- PLUGINS STYLESHEET -->
	<link href="<?php echo SITE_URL;?>/css/menu.css?v=<?php echo version;?>" rel="stylesheet" />
	<link href="<?php echo SITE_URL;?>/css/dropdown-effects/fade-down.css?v=<?php echo version;?>" media="all" rel="stylesheet" id="effect" />
	<link href="<?php echo SITE_URL;?>/css/animate.css?v=<?php echo version;?>" rel="stylesheet" />
	<!-- TEMPLATE CSS -->
	<link href="<?php echo SITE_URL;?>/css/style.css?v=<?php echo version;?>" rel="stylesheet" />
	<!-- RESPONSIVE CSS -->
	<link href="<?php echo SITE_URL;?>/css/responsive.css?v=<?php echo version;?>" rel="stylesheet" />
	<?php include "inc-tagmanager-head.php";?>
	<script src="https://www.google.com/recaptcha/api.js?hl=pt-BR"></script>
</head>
	<body>
		<?php include "inc-tagmanager-body.php";?>
		<div id="page" class="page">
				<?php include "header.php";?>
			<!-- CONTACTS-1
			============================================= -->
			<section id="contacts-1" class="wide-60 contacts-section division" >				
				<div class="container">
					<div class="row">	
						<div class="col-lg-11 offset-lg-1 section-title">	
							<h1 id="contato" class="h3-md"><?php echo $texto->titulo;?></h1>	
							<p><?php echo $texto->texto;?></p>
						</div>
					</div>
					<div class="row">	
                        <!-- CONTACTS INFO -->
		 				<div class="col-md-5 col-lg-4 d-none d-sm-block   .d-none .d-md-block .d-lg-none">

		 					<!-- General Information -->
		 					<div class="contact-box mb-40">
								<h5 class="h5-sm">Informações gerais</h5>
								<p><?php echo $infoSistema->endereco;?></p> 
								<p>CEP: <?php echo $infoSistema->cep_loja;?></p>
								<p>Telefone: <br><?php echo $infoSistema->telefone1;?></p>
								<p>E-mail: <a href="mailto:<?php echo $infoSistema->email1;?>"><?php echo $infoSistema->email1;?></a></p>
		 					</div>
						</div>	<!-- END CONTACTS INFO -->

				 		<div class="col-md-7 col-lg-8 ">
				 			<div class="form-holder mb-40">
				 				<form name="contactForm" class="row contact-form" method="POST" style="background: #f7f7f7!important; border-radius:10px;" >
				 				     <div class="col-lg-12 contact-form-msg text-center">
					                	<div class="sending-msg">
					                	<?php
if (!empty($erros))
{
?>
		<div class="alert alert-danger" role="alert">
			Seu contato não foi enviado:
			<ul class="mb-0">
<?php
	foreach ($erros as $erro)
		echo '<li>' . htmlspecialchars($erro) . "</li>\n";
?>
			</ul>
		</div>
<?php
}
?>
					                	</div>
					                </div> 
				                    <div id="input-name" class="col-md-12 col-lg-6">
					                	<input type="text" required name="nome" class="form-control name" placeholder="Seu Nome*"  style="background-color: #fff;"> 
					                </div>
					                        
					                <div id="input-email" class="col-md-12 col-lg-6">
					                	<input type="text" required name="email" class="form-control email" placeholder="Seu E-mail*"  style="background-color: #fff;"> 
					                </div>

					                <div id="input-phone" class="col-md-12 col-lg-6">
					                	<input type="tel" required name="telefone" class="form-control phone" placeholder="Seu Telefone*"  style="background-color: #fff;"> 
					                </div>	

					                <div id="input-subject" class="col-md-12 col-lg-6">
					                	<input type="text" required name="assunto" class="form-control subject" placeholder="Assunto*"  style="background-color: #fff;"> 
					                </div>					                          
					                        
					                <div id="input-message" class="col-md-12 col-lg-12 input-message">
					                	<textarea class="form-control message" name="mensagem" required rows="6" placeholder="Sua Mensagem..."  style="background-color: #fff;"></textarea>
					                </div> 
					                <div class="col-md-12 col-lg-12">
										<div class="g-recaptcha" data-sitekey="<?php echo $chave_de_site; ?>"></div>
									</div>
					                                            
					                <!-- Contact Form Button -->
					                <div class="col-lg-12 col-md-12  mt-15 form-btn mb-30">  
					                	<button type="submit" class="btn btn-bege bege-hover  submit" >Enviar mensagem</button> 
					                </div>
					                                                              <input type="hidden" name="acao" value="enviarMensagem">
					                <!-- Contact Form Message -->
					                
				                                              
				                </form> 

				 			</div>	
				 		</div> 	<!-- END CONTACT FORM -->	
				 		<!-- CONTACTS INFO -->
		 				<div class="col-md-5 col-lg-4 d-block d-sm-none">

		 					<!-- General Information -->
		 					<div class="contact-box mb-40">
								<h5 class="h5-sm">Informações Gerais</h5>
								<p><?php echo $infoSistema->endereco;?></p> 
								<p>CEP: <?php echo $infoSistema->cep_loja;?></p>
								<p>Telefone: <br><?php echo $infoSistema->telefone1;?></p>
								<p>E-mail: <a href="mailto:<?php echo $infoSistema->email1;?>"><?php echo $infoSistema->email1;?></a></p>
		 					</div>
						</div>	<!-- END CONTACTS INFO -->


				 	</div>	  
 

				</div>	   <!-- End container -->		
			</section>	<!-- END CONTACTS-1 -->
		
		<?php include "footer.php";?>
		</div>	<!-- END PAGE CONTENT -->
		<script src="<?php echo SITE_URL;?>/js/jquery-3.3.1.min.js?v=<?php echo version;?>"></script>
		<script src="<?php echo SITE_URL;?>/js/bootstrap.min.js?v=<?php echo version;?>"></script>	
		<script src="<?php echo SITE_URL;?>/js/modernizr.custom.js?v=<?php echo version;?>"></script>		
		<script src="<?php echo SITE_URL;?>/js/menu.js?v=<?php echo version;?>"></script>
		<script src="<?php echo SITE_URL;?>/js/sticky.js?v=<?php echo version;?>"></script>
		<script src="<?php echo SITE_URL;?>/js/jquery.scrollto.js?v=<?php echo version;?>"></script>
		<script src="<?php echo SITE_URL;?>/js/materialize.js?v=<?php echo version;?>"></script>	
		<script src="<?php echo SITE_URL;?>/js/isotope.pkgd.min.js?v=<?php echo version;?>"></script>
		<!-- Custom Script -->		
		<script src="<?php echo SITE_URL;?>/js/custom.js?v=<?php echo version;?>"></script>

	</body>
</html>	