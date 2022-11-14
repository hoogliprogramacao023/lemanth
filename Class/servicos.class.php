<?php
@ session_start();
$ServicosInstanciada = '';
if(empty($ServicosInstanciada)) {
	if(file_exists('Connection/conexao.php')) {
		require_once('Connection/con-pdo.php');
		require_once('funcoes.php');
	} else {
		require_once('../Connection/con-pdo.php');
		require_once('../funcoes.php');
	}
	
	class Servicos {
		
		private $pdo = null;  

		private static $Servicos = null; 

		private function __construct($conexao){  
			$this->pdo = $conexao;  
		}
	  
		public static function getInstance($conexao){   
			if (!isset(self::$Servicos)):    
				self::$Servicos = new Servicos($conexao);   
			endif;
			return self::$Servicos;    
		}
		
	
		function rsDados($id='', $orderBy='', $limite='', $idCat='', $idDiferente='', $url_amigavel='') {
			
			/// FILTROS
			$nCampos = 0;
			$sql = '';
			$sqlOrdem = ''; 
			$sqlLimite = '';
			if(!empty($id)) {
				$sql .= " and id = ?"; 
				$nCampos++;
				$campo[$nCampos] = $id;
			}
			if(!empty($idCat)) {
				$sql .= " and id_cat = ?"; 
				$nCampos++;
				$campo[$nCampos] = $idCat;
			}
			if(!empty($idDiferente)) {
				$sql .= " and id != ?"; 
				$nCampos++;
				$campo[$nCampos] = $idDiferente;
			}
			if(!empty($url_amigavel)) {
				$sql .= " and url_amigavel = ?"; 
				$nCampos++;
				$campo[$nCampos] = $url_amigavel;
			}
		
			/// ORDEM		
			if(!empty($orderBy)) {
				$sqlOrdem = " order by {$orderBy}";
			}
			
			if(!empty($limite)) {
				$sqlLimite = " limit {$limite}";
			}
			
			try{   
				$sql = "SELECT * FROM tbl_servicos where 1=1 $sql $sqlOrdem $sqlLimite";
				$stm = $this->pdo->prepare($sql);
				
				for($i=1; $i<=$nCampos; $i++) {
					$stm->bindValue($i, $campo[$i]);
				}
				
				$stm->execute();
				$rsDados = $stm->fetchAll(PDO::FETCH_OBJ);
				//print_r($rsDados);
				if($id <> '' or $limite == 1) {
					return($rsDados[0]);
				} else {
					return($rsDados);
				}
			} catch(PDOException $erro){   
				echo $erro->getMessage(); 
			}
		}

		function add($redireciona='') {
			if(isset($_POST['acao']) && $_POST['acao'] == 'addServico') {
	
				$titulo = filter_input(INPUT_POST, 'titulo', FILTER_SANITIZE_STRING);
				//$descricao = filter_input(INPUT_POST, 'descricao', FILTER_SANITIZE_STRING);
				$descricao = $_POST['descricao'];
				$id_cat = filter_input(INPUT_POST, 'id_cat', FILTER_SANITIZE_STRING);
				//$breve = filter_input(INPUT_POST, 'breve', FILTER_SANITIZE_STRING);
				$breve = $_POST['breve'];
				$banner_titulo = filter_input(INPUT_POST, 'banner_titulo', FILTER_SANITIZE_STRING);
				$banner_texto = filter_input(INPUT_POST, 'banner_texto', FILTER_SANITIZE_STRING);
				$sessao1_titulo = filter_input(INPUT_POST, 'sessao1_titulo', FILTER_SANITIZE_STRING);
				$sessao1_texto = filter_input(INPUT_POST, 'sessao1_texto', FILTER_SANITIZE_STRING);
				$sessao2_titulo = filter_input(INPUT_POST, 'sessao2_titulo', FILTER_SANITIZE_STRING);
				$sessao2_texto = $_POST['sessao2_texto'];
				$sessao3_titulo = filter_input(INPUT_POST, 'sessao3_titulo', FILTER_SANITIZE_STRING);
				$sessao3_texto = $_POST['sessao3_texto'];
				$sessao4_titulo = filter_input(INPUT_POST, 'sessao4_titulo', FILTER_SANITIZE_STRING);
				$sessao4_texto = $_POST['sessao4_texto'];
				$sessao5_titulo = filter_input(INPUT_POST, 'sessao5_titulo', FILTER_SANITIZE_STRING);
				$sessao5_texto = $_POST['sessao5_texto'];
				$topico1_titulo = filter_input(INPUT_POST, 'topico1_titulo', FILTER_SANITIZE_STRING);
				$topico1_texto = $_POST['topico1_texto'];
				$topico2_titulo = filter_input(INPUT_POST, 'topico2_titulo', FILTER_SANITIZE_STRING);
				$topico2_texto = $_POST['topico2_texto'];
				$topico3_titulo = filter_input(INPUT_POST, 'topico3_titulo', FILTER_SANITIZE_STRING);
				$topico3_texto = $_POST['topico3_texto'];
				$topico4_titulo = filter_input(INPUT_POST, 'topico4_titulo', FILTER_SANITIZE_STRING);
				$topico4_texto = $_POST['topico4_texto'];
				$diferenca1_titulo = filter_input(INPUT_POST, 'diferenca1_titulo', FILTER_SANITIZE_STRING);
				$diferenca1_texto = $_POST['diferenca1_texto'];
				$diferenca2_titulo = filter_input(INPUT_POST, 'diferenca2_titulo', FILTER_SANITIZE_STRING);
				$diferenca2_texto = $_POST['diferenca2_texto'];
				$diferenca3_titulo = filter_input(INPUT_POST, 'diferenca3_titulo', FILTER_SANITIZE_STRING);
				$diferenca3_texto = $_POST['diferenca3_texto'];
				$texto_corrido = $_POST['texto_corrido'];
				$titulo_texto = filter_input(INPUT_POST, 'titulo_texto', FILTER_SANITIZE_STRING);
				$contato_titulo = filter_input(INPUT_POST, 'contato_titulo', FILTER_SANITIZE_STRING);
				$contato_texto = $_POST['contato_texto'];
				$nome_botao_banner = $_POST['nome_botao_banner'];
				$link_botao_banner = $_POST['link_botao_banner'];
				$nome_botao_sessao1 = $_POST['nome_botao_sessao1'];
				$link_botao_sessao1 = $_POST['link_botao_sessao1'];
				$nome_botao_sessao2 = $_POST['nome_botao_sessao2'];
				$link_botao_sessao2 = $_POST['link_botao_sessao2'];
				$nome_botao_sessao4 = $_POST['nome_botao_sessao4'];
				$link_botao_sessao4 = $_POST['link_botao_sessao4'];
				$nome_botao_sessao5 = $_POST['nome_botao_sessao5'];
				$link_botao_sessao5 = $_POST['link_botao_sessao5'];
				$meta_title = filter_input(INPUT_POST, 'meta_title', FILTER_SANITIZE_STRING);
				$meta_keywords = filter_input(INPUT_POST, 'meta_keywords', FILTER_SANITIZE_STRING);
				$meta_description = filter_input(INPUT_POST, 'meta_description', FILTER_SANITIZE_STRING);
				$urlAmigavel = gerarTituloSEO($titulo);
				$banner_SubTitulo = $_POST['banner_SubTitulo'];
				$banner_SubTitulo2 = $_POST['banner_SubTitulo2'];
				$banner_TituloPreco = $_POST['banner_TituloPreco'];
				$banner_Preco = $_POST['banner_Preco'];
				$banner_Condicoes= $_POST['banner_Condicoes'];
				$sessao1_SubTitulo= $_POST['sessao1_SubTitulo'];
				$sessao1_Coluna2Linha1= $_POST['sessao1_Coluna2Linha1'];
				$sessao1_Coluna3Linha1= $_POST['sessao1_Coluna3Linha1'];
				$sessao1_Coluna4Linha1= $_POST['sessao1_Coluna4Linha1'];
				$sessao1_Coluna1Linha2= $_POST['sessao1_Coluna1Linha2'];
				$sessao1_Coluna2Linha2= $_POST['sessao1_Coluna2Linha2'];
				$sessao1_Coluna3Linha2= $_POST['sessao1_Coluna3Linha2'];
				$sessao1_Coluna4Linha2= $_POST['sessao1_Coluna4Linha2'];
				$sessao1_Coluna1Linha3= $_POST['sessao1_Coluna1Linha3'];
				$sessao1_Coluna2Linha3= $_POST['sessao1_Coluna2Linha3'];
				$sessao1_Coluna3Linha3= $_POST['sessao1_Coluna3Linha3'];
				$sessao1_Coluna4Linha3= $_POST['sessao1_Coluna4Linha3'];
				$sessao2_tituloColuna1= $_POST['sessao2_tituloColuna1'];
				$sessao2_tituloColuna2= $_POST['sessao2_tituloColuna2'];
				$sessao2_tituloColuna3= $_POST['sessao2_tituloColuna3'];
				$sessao2_tituloColuna4= $_POST['sessao2_tituloColuna4'];
				$sessao2_textoColuna1= $_POST['sessao2_textoColuna1'];
				$sessao2_textoColuna2= $_POST['sessao2_textoColuna2'];
				$sessao2_textoColuna3= $_POST['sessao2_textoColuna3'];
				$sessao2_textoColuna4= $_POST['sessao2_textoColuna4'];
				$sessao3_tituloColuna1= $_POST['sessao3_tituloColuna1'];
				$sessao3_tituloColuna2= $_POST['sessao3_tituloColuna2'];
				$sessao3_tituloColuna3= $_POST['sessao3_tituloColuna3'];
				$sessao3_textoColuna1= $_POST['sessao3_textoColuna1'];
				$sessao3_textoColuna2= $_POST['sessao3_textoColuna2'];
				$sessao3_textoColuna3= $_POST['sessao3_textoColuna3'];
				$sessao3_tituloPrecoColuna1= $_POST['sessao3_tituloPrecoColuna1'];
				$sessao3_tituloPrecoColuna2= $_POST['sessao3_tituloPrecoColuna2'];
				$sessao3_tituloPrecoColuna3= $_POST['sessao3_tituloPrecoColuna3'];
				$sessao3_PrecoColuna1= $_POST['sessao3_PrecoColuna1'];
				$sessao3_PrecoColuna2= $_POST['sessao3_PrecoColuna2'];
				$sessao3_PrecoColuna3= $_POST['sessao3_PrecoColuna3'];
				$sessao3_CondicoesPrecoColuna1= $_POST['sessao3_CondicoesPrecoColuna1'];
				$sessao3_CondicoesPrecoColuna2= $_POST['sessao3_CondicoesPrecoColuna2'];
				$sessao3_CondicoesPrecoColuna3= $_POST['sessao3_CondicoesPrecoColuna3'];
				$nome_botao1_sessao3= $_POST['nome_botao1_sessao3'];
				$link_botao1_sessao3= $_POST['link_botao1_sessao3'];
				$nome_botao2_sessao3= $_POST['nome_botao2_sessao3'];
				$link_botao2_sessao3= $_POST['link_botao2_sessao3'];
				$nome_botao3_sessao3= $_POST['nome_botao3_sessao3'];
				$link_botao3_sessao3= $_POST['link_botao3_sessao3'];
				$sessao4_SubTitulo= $_POST['sessao4_SubTitulo'];
				
					try{

						if(file_exists('Connection/conexao.php')) {
							$pastaArquivos = 'img';
						} else {
							$pastaArquivos = '../img';
						}
						
						$sql = "INSERT INTO tbl_servicos (foto, titulo, descricao, id_cat, meta_title, meta_keywords, meta_description, url_amigavel, breve, banner_foto, sessao1_foto, sessao2_foto, sessao4_foto, topico1_foto, topico2_foto, topico3_foto, topico4_foto, diferenca1_foto, diferenca2_foto, diferenca3_foto, banner_titulo, banner_texto, sessao1_titulo, sessao1_texto, sessao2_titulo, sessao2_texto, sessao3_titulo, sessao3_texto, sessao4_titulo, sessao4_texto, sessao5_titulo, sessao5_texto, topico1_titulo, topico1_texto, topico2_titulo, topico2_texto, topico3_titulo, topico3_texto, topico4_titulo, topico4_texto, diferenca1_titulo, diferenca1_texto, diferenca2_titulo, diferenca2_texto, diferenca3_titulo, diferenca3_texto, contato_titulo, contato_texto, imagem_final, imagem_mobile_final, nome_botao_banner, link_botao_banner, nome_botao_sessao1, link_botao_sessao1, nome_botao_sessao2, link_botao_sessao2, nome_botao_sessao4, link_botao_sessao4, nome_botao_sessao5, link_botao_sessao5, titulo_texto, texto_corrido, banner_SubTitulo, banner_SubTitulo2, banner_TituloPreco, banner_Preco, banner_Condicoes, sessao1_SubTitulo, sessao1_Coluna2Linha1, sessao1_Coluna3Linha1, sessao1_Coluna4Linha1, sessao1_Coluna1Linha2, sessao1_Coluna2Linha2, sessao1_Coluna3Linha2, sessao1_Coluna4Linha2, sessao1_Coluna1Linha3, sessao1_Coluna2Linha3, sessao1_Coluna3Linha3, sessao1_Coluna4Linha3, sessao2_tituloColuna1, sessao2_tituloColuna2, sessao2_tituloColuna3, sessao2_tituloColuna4, sessao2_textoColuna1, sessao2_textoColuna2, sessao2_textoColuna3, sessao2_textoColuna4, sessao1_foto_icone1, sessao1_foto_icone2, sessao3_iconeColuna1, sessao3_iconeColuna2, sessao3_iconeColuna3, sessao3_tituloColuna1, sessao3_tituloColuna2, sessao3_tituloColuna3, sessao3_textoColuna1, sessao3_textoColuna2, sessao3_textoColuna3, sessao3_tituloPrecoColuna1, sessao3_tituloPrecoColuna2, sessao3_tituloPrecoColuna3, sessao3_PrecoColuna1, sessao3_PrecoColuna2, sessao3_PrecoColuna3, sessao3_CondicoesPrecoColuna1, sessao3_CondicoesPrecoColuna2, sessao3_CondicoesPrecoColuna3, nome_botao1_sessao3, link_botao1_sessao3, nome_botao2_sessao3, link_botao2_sessao3, nome_botao3_sessao3, link_botao3_sessao3, sessao4_SubTitulo, sessao4_icone, sessao5_foto1, sessao5_foto2, sessao5_foto3, sessao5_foto4  ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";   
						$stm = $this->pdo->prepare($sql);   
						$stm->bindValue(1, upload('foto', $pastaArquivos, 'N'));
						$stm->bindValue(2, $titulo);   
						$stm->bindValue(3, $descricao);
						$stm->bindValue(4, $id_cat);   
						$stm->bindValue(5, $meta_title);   
						$stm->bindValue(6, $meta_keywords);   
						$stm->bindValue(7, $meta_description); 
						$stm->bindValue(8, $urlAmigavel);
						$stm->bindValue(9, $breve);
						$stm->bindValue(10, upload('banner_foto', $pastaArquivos, 'N')); 
						$stm->bindValue(11, upload('sessao1_foto', $pastaArquivos, 'N')); 
						$stm->bindValue(12, upload('sessao2_foto', $pastaArquivos, 'N')); 
						$stm->bindValue(13, upload('sessao4_foto', $pastaArquivos, 'N')); 
						$stm->bindValue(14, upload('topico1_foto', $pastaArquivos, 'N')); 
						$stm->bindValue(15, upload('topico2_foto', $pastaArquivos, 'N')); 
						$stm->bindValue(16, upload('topico3_foto', $pastaArquivos, 'N')); 
						$stm->bindValue(17, upload('topico4_foto', $pastaArquivos, 'N')); 
						$stm->bindValue(18, upload('diferenca1_foto', $pastaArquivos, 'N')); 
						$stm->bindValue(19, upload('diferenca2_foto', $pastaArquivos, 'N')); 
						$stm->bindValue(20, upload('diferenca3_foto', $pastaArquivos, 'N'));
						$stm->bindValue(21, $banner_titulo);
						$stm->bindValue(22, $banner_texto);
						$stm->bindValue(23, $sessao1_titulo);
						$stm->bindValue(24, $sessao1_texto);
						$stm->bindValue(25, $sessao2_titulo);
						$stm->bindValue(26, $sessao2_texto);
						$stm->bindValue(27, $sessao3_titulo);
						$stm->bindValue(28, $sessao3_texto);
						$stm->bindValue(29, $sessao4_titulo);
						$stm->bindValue(30, $sessao4_texto);
						$stm->bindValue(31, $sessao5_titulo);
						$stm->bindValue(32, $sessao5_texto);
						$stm->bindValue(33, $topico1_titulo);
						$stm->bindValue(34, $topico1_texto);
						$stm->bindValue(35, $topico2_titulo);
						$stm->bindValue(36, $topico2_texto);
						$stm->bindValue(37, $topico3_titulo);
						$stm->bindValue(38, $topico3_texto);
						$stm->bindValue(39, $topico4_titulo);
						$stm->bindValue(40, $topico4_texto);
						$stm->bindValue(41, $diferenca1_titulo);
						$stm->bindValue(42, $diferenca1_texto);
						$stm->bindValue(43, $diferenca2_titulo);
						$stm->bindValue(44, $diferenca2_texto);
						$stm->bindValue(45, $diferenca3_titulo);
						$stm->bindValue(46, $diferenca3_texto);
						$stm->bindValue(47, $contato_titulo);
						$stm->bindValue(48, $contato_texto);
						$stm->bindValue(49, upload('imagem_final', $pastaArquivos, 'N'));
						$stm->bindValue(50, upload('imagem_mobile_final', $pastaArquivos, 'N'));
						$stm->bindValue(51, $nome_botao_banner);
						$stm->bindValue(52, $link_botao_banner);
						$stm->bindValue(53, $nome_botao_sessao1);
						$stm->bindValue(54, $link_botao_sessao1);
						$stm->bindValue(55, $nome_botao_sessao2);
						$stm->bindValue(56, $link_botao_sessao2);
						$stm->bindValue(57, $nome_botao_sessao4);
						$stm->bindValue(58, $link_botao_sessao4);
					    $stm->bindValue(59, $titulo_texto);
						$stm->bindValue(60, $texto_corrido);
						$stm->bindValue(61, $banner_SubTitulo);
						$stm->bindValue(62, $banner_SubTitulo2);
						$stm->bindValue(63, $banner_TituloPreco);
						$stm->bindValue(64, $banner_Preco);
						$stm->bindValue(65, $banner_Condicoes);
						$stm->bindValue(66, $sessao1_SubTitulo);
						$stm->bindValue(67, $sessao1_Coluna2Linha1);
						$stm->bindValue(68, $sessao1_Coluna3Linha1);
						$stm->bindValue(69, $sessao1_Coluna4Linha1);
						$stm->bindValue(70, $sessao1_Coluna1Linha2);
						$stm->bindValue(71, $sessao1_Coluna2Linha2);
						$stm->bindValue(72, $sessao1_Coluna3Linha2);
						$stm->bindValue(73, $sessao1_Coluna4Linha2);
						$stm->bindValue(74, $sessao1_Coluna1Linha3);
						$stm->bindValue(75, $sessao1_Coluna2Linha3);
						$stm->bindValue(76, $sessao1_Coluna3Linha3);
						$stm->bindValue(77, $sessao1_Coluna4Linha3);
						$stm->bindValue(78, $sessao2_tituloColuna1);
						$stm->bindValue(79, $sessao2_tituloColuna2);
						$stm->bindValue(80, $sessao2_tituloColuna3);
						$stm->bindValue(81, $sessao2_tituloColuna4);
						$stm->bindValue(82, $sessao2_textoColuna1);
						$stm->bindValue(83, $sessao2_textoColuna2);
						$stm->bindValue(84, $sessao2_textoColuna3);
						$stm->bindValue(85, $sessao2_textoColuna4);
						$stm->bindValue(86, upload('sessao1_foto_icone1', $pastaArquivos, 'N')); 
						$stm->bindValue(87, upload('sessao1_foto_icone2', $pastaArquivos, 'N'));
						$stm->bindValue(88, upload('sessao3_iconeColuna1', $pastaArquivos, 'N')); 
						$stm->bindValue(89, upload('sessao3_iconeColuna2', $pastaArquivos, 'N')); 
						$stm->bindValue(90, upload('sessao3_iconeColuna3', $pastaArquivos, 'N')); 
						$stm->bindValue(91, $sessao3_tituloColuna1);
						$stm->bindValue(92, $sessao3_tituloColuna2);
						$stm->bindValue(93, $sessao3_tituloColuna3);
						$stm->bindValue(94, $sessao3_textoColuna1);
						$stm->bindValue(95, $sessao3_textoColuna2);
						$stm->bindValue(96, $sessao3_textoColuna3);
						$stm->bindValue(97, $sessao3_tituloPrecoColuna1);
						$stm->bindValue(98, $sessao3_tituloPrecoColuna2);
						$stm->bindValue(99, $sessao3_tituloPrecoColuna3);
						$stm->bindValue(100, $sessao3_PrecoColuna1);
						$stm->bindValue(101, $sessao3_PrecoColuna2);
						$stm->bindValue(102, $sessao3_PrecoColuna3);
						$stm->bindValue(103, $sessao3_CondicoesPrecoColuna1);
						$stm->bindValue(104, $sessao3_CondicoesPrecoColuna2);
						$stm->bindValue(105, $sessao3_CondicoesPrecoColuna3);
						$stm->bindValue(106, $nome_botao1_sessao3);
						$stm->bindValue(107, $link_botao1_sessao3);
						$stm->bindValue(108, $nome_botao2_sessao3);
						$stm->bindValue(109, $link_botao2_sessao3);
						$stm->bindValue(110, $nome_botao3_sessao3);
						$stm->bindValue(111, $link_botao3_sessao3);
						$stm->bindValue(112, $sessao4_SubTitulo);				
						$stm->bindValue(113, upload('sessao4_icone', $pastaArquivos, 'N')); 
						$stm->bindValue(114, $nome_botao_sessao5);
						$stm->bindValue(115, $link_botao_sessao5);
						$stm->bindValue(116, upload('sessao5_foto1', $pastaArquivos, 'N'));
						$stm->bindValue(117, upload('sessao5_foto2', $pastaArquivos, 'N'));
						$stm->bindValue(118, upload('sessao5_foto3', $pastaArquivos, 'N'));
						$stm->bindValue(119, upload('sessao5_foto4', $pastaArquivos, 'N'));
						
						$stm->execute(); 
						$idBanner = $this->pdo->lastInsertId();
						
						if($redireciona == '') {
							$redireciona = '.';
						}
						//exit;
						
					} catch(PDOException $erro){
						echo $erro->getMessage(); 
					}
					echo "	<script>
								window.location='servicos.php';
								</script>";
								exit;
				
			}
		}
		
		function editar($redireciona='servicos.php') {
			if(isset($_POST['acao']) && $_POST['acao'] == 'editaServico') {

				$titulo = filter_input(INPUT_POST, 'titulo', FILTER_SANITIZE_STRING);
				$descricao = filter_input(INPUT_POST, 'descricao', FILTER_SANITIZE_STRING);
				$id_cat = filter_input(INPUT_POST, 'id_cat', FILTER_SANITIZE_STRING);
				$breve = filter_input(INPUT_POST, 'breve', FILTER_SANITIZE_STRING);
				$meta_title = filter_input(INPUT_POST, 'meta_title', FILTER_SANITIZE_STRING);
				$meta_keywords = filter_input(INPUT_POST, 'meta_keywords', FILTER_SANITIZE_STRING);
				$meta_description = filter_input(INPUT_POST, 'meta_description', FILTER_SANITIZE_STRING);
				$id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_STRING);
				$banner_titulo = filter_input(INPUT_POST, 'banner_titulo', FILTER_SANITIZE_STRING);
				$banner_texto = filter_input(INPUT_POST, 'banner_texto ', FILTER_SANITIZE_STRING);
				$sessao1_titulo = filter_input(INPUT_POST, 'sessao1_titulo', FILTER_SANITIZE_STRING);
				$sessao1_texto = filter_input(INPUT_POST, 'sessao1_texto ', FILTER_SANITIZE_STRING);
				$sessao2_titulo = filter_input(INPUT_POST, 'sessao2_titulo', FILTER_SANITIZE_STRING);
				$sessao2_texto = filter_input(INPUT_POST, 'sessao2_texto', FILTER_SANITIZE_STRING);
				$sessao3_titulo = filter_input(INPUT_POST, 'sessao3_titulo', FILTER_SANITIZE_STRING);
				$sessao3_texto = filter_input(INPUT_POST, 'sessao3_texto', FILTER_SANITIZE_STRING);
				$sessao4_titulo = filter_input(INPUT_POST, 'sessao4_titulo', FILTER_SANITIZE_STRING);
				$sessao4_texto = $_POST['sessao4_texto'];
				$sessao5_titulo = filter_input(INPUT_POST, 'sessao5_titulo', FILTER_SANITIZE_STRING);
				$sessao5_texto = $_POST['sessao5_texto'];
				$topico1_titulo = filter_input(INPUT_POST, 'topico1_titulo', FILTER_SANITIZE_STRING);
				$topico1_texto = filter_input(INPUT_POST, 'topico1_texto', FILTER_SANITIZE_STRING);
				$topico2_titulo = filter_input(INPUT_POST, 'topico2_titulo', FILTER_SANITIZE_STRING);
				$topico2_texto = filter_input(INPUT_POST, 'topico2_texto', FILTER_SANITIZE_STRING);
				$topico3_titulo = filter_input(INPUT_POST, 'topico3_titulo', FILTER_SANITIZE_STRING);
				$topico3_texto = filter_input(INPUT_POST, 'topico3_texto', FILTER_SANITIZE_STRING);
				$topico4_titulo = filter_input(INPUT_POST, 'topico4_titulo', FILTER_SANITIZE_STRING);
				$topico4_texto = filter_input(INPUT_POST, 'topico4_texto', FILTER_SANITIZE_STRING);
				$diferenca1_titulo = filter_input(INPUT_POST, 'diferenca1_titulo', FILTER_SANITIZE_STRING);
				$diferenca1_texto = filter_input(INPUT_POST, 'diferenca1_texto', FILTER_SANITIZE_STRING);
				$diferenca2_titulo = filter_input(INPUT_POST, 'diferenca2_titulo', FILTER_SANITIZE_STRING);
				$diferenca2_texto = filter_input(INPUT_POST, 'diferenca2_texto', FILTER_SANITIZE_STRING);
				$diferenca3_titulo = filter_input(INPUT_POST, 'diferenca3_titulo', FILTER_SANITIZE_STRING);
				$diferenca3_texto = filter_input(INPUT_POST, 'diferenca3_texto', FILTER_SANITIZE_STRING);
				$nome_botao_banner = $_POST['nome_botao_banner'];
				$link_botao_banner = $_POST['link_botao_banner'];
				$nome_botao_sessao1 = filter_input(INPUT_POST, 'nome_botao_sessao1', FILTER_SANITIZE_STRING);
				$link_botao_sessao1 = filter_input(INPUT_POST, 'link_botao_sessao1', FILTER_SANITIZE_STRING);
				$nome_botao_sessao2 = $_POST['nome_botao_sessao2'];
				$link_botao_sessao2 = $_POST['link_botao_sessao2'];
				$nome_botao_sessao4 = $_POST['nome_botao_sessao4'];
				$link_botao_sessao4 = $_POST['link_botao_sessao4'];
				$nome_botao_sessao5 = $_POST['nome_botao_sessao5'];
				$link_botao_sessao5 = $_POST['link_botao_sessao5'];
				$titulo_texto = $_POST['titulo_texto'];
				$texto_corrido = $_POST['texto_corrido'];
				$contato_titulo = filter_input(INPUT_POST, 'contato_titulo', FILTER_SANITIZE_STRING);
				$contato_texto = $_POST['contato_texto'];
				$urlAmigavel = gerarTituloSEO($titulo);
				$banner_SubTitulo = $_POST['banner_SubTitulo'];
                $banner_SubTitulo2 = $_POST['banner_SubTitulo2'];
				$banner_TituloPreco = $_POST['banner_TituloPreco'];
				$banner_Preco = $_POST['banner_Preco'];
				$banner_Condicoes = $_POST['banner_Condicoes'];
				$sessao1_SubTitulo = $_POST['sessao1_SubTitulo'];
				$sessao1_Coluna2Linha1 = $_POST['sessao1_Coluna2Linha1'];
				$sessao1_Coluna3Linha1 = $_POST['sessao1_Coluna3Linha1'];
				$sessao1_Coluna4Linha1 = filter_input(INPUT_POST, 'sessao1_Coluna4Linha1', FILTER_SANITIZE_STRING);
				$sessao1_Coluna1Linha2 = $_POST['sessao1_Coluna1Linha2'];
				$sessao1_Coluna2Linha2 = $_POST['sessao1_Coluna2Linha2'];
				$sessao1_Coluna3Linha2 = $_POST['sessao1_Coluna3Linha2'];
				$sessao1_Coluna4Linha2 = $_POST['sessao1_Coluna4Linha2'];
				$sessao1_Coluna1Linha3 = $_POST['sessao1_Coluna1Linha3'];
				$sessao1_Coluna2Linha3 = $_POST['sessao1_Coluna2Linha3'];
				$sessao1_Coluna3Linha3 = $_POST['sessao1_Coluna3Linha3'];
				$sessao1_Coluna4Linha3 = $_POST['sessao1_Coluna4Linha3'];
				$sessao2_tituloColuna1 = filter_input(INPUT_POST, 'sessao2_tituloColuna1', FILTER_SANITIZE_STRING);
				$sessao2_tituloColuna2 = filter_input(INPUT_POST, 'sessao2_tituloColuna2', FILTER_SANITIZE_STRING);
				$sessao2_tituloColuna3 = filter_input(INPUT_POST, 'sessao2_tituloColuna3', FILTER_SANITIZE_STRING);
				$sessao2_tituloColuna4 = filter_input(INPUT_POST, 'sessao2_tituloColuna4', FILTER_SANITIZE_STRING);
				$sessao2_textoColuna1 = $_POST['sessao2_textoColuna1'];
				$sessao2_textoColuna2 = $_POST['sessao2_textoColuna2'];
				$sessao2_textoColuna3 = $_POST['sessao2_textoColuna3'];
				$sessao2_textoColuna4 = $_POST['sessao2_textoColuna4'];
				$sessao3_tituloColuna1 = $_POST['sessao3_tituloColuna1'];
				$sessao3_tituloColuna2 = $_POST['sessao3_tituloColuna2'];
				$sessao3_tituloColuna3 = $_POST['sessao3_tituloColuna3'];
				$sessao3_textoColuna1 = $_POST['sessao3_textoColuna1'];
				$sessao3_textoColuna2 = $_POST['sessao3_textoColuna2'];
				$sessao3_textoColuna3 = $_POST['sessao3_textoColuna3'];
				$sessao3_tituloPrecoColuna1 = $_POST['sessao3_tituloPrecoColuna1'];
				$sessao3_tituloPrecoColuna2 = $_POST['sessao3_tituloPrecoColuna2'];
				$sessao3_tituloPrecoColuna3 = $_POST['sessao3_tituloPrecoColuna3'];
				$sessao3_PrecoColuna1 = $_POST['sessao3_PrecoColuna1'];
				$sessao3_PrecoColuna2 = $_POST['sessao3_PrecoColuna2'];
				$sessao3_PrecoColuna3 = $_POST['sessao3_PrecoColuna3'];
				$sessao3_CondicoesPrecoColuna1 = $_POST['sessao3_CondicoesPrecoColuna1'];
				$sessao3_CondicoesPrecoColuna2 = $_POST['sessao3_CondicoesPrecoColuna2'];
				$sessao3_CondicoesPrecoColuna3 = $_POST['sessao3_CondicoesPrecoColuna3'];
				$nome_botao1_sessao3 = $_POST['nome_botao1_sessao3'];
				$link_botao1_sessao3 = $_POST['link_botao1_sessao3'];
				$nome_botao2_sessao3 = $_POST['nome_botao2_sessao3'];
				$link_botao2_sessao3 = $_POST['link_botao2_sessao3'];
				$nome_botao3_sessao3 = $_POST['nome_botao3_sessao3'];
				$link_botao3_sessao3 = $_POST['link_botao3_sessao3'];
				$sessao4_SubTitulo = $_POST['sessao4_SubTitulo'];
				
				try { 

					if(file_exists('Connection/conexao.php')) {
							$pastaArquivos = 'img';
						} else {
							$pastaArquivos = '../img';
						}
				
					$sql = "UPDATE tbl_servicos SET foto=?, titulo=?, descricao=?, id_cat=?, meta_title=?, meta_keywords=?, meta_description=?, url_amigavel=?, breve=?, banner_foto=?, sessao1_foto=?, sessao2_foto=?, sessao4_foto=?, topico1_foto=?, topico2_foto=?, topico3_foto=?, topico4_foto=?, diferenca1_foto=?, diferenca2_foto=?, diferenca3_foto=?, banner_titulo=?, banner_texto=?, sessao1_titulo=?, sessao1_texto=?, sessao2_titulo=?, sessao2_texto=?, sessao3_titulo=?, sessao3_texto=?, sessao4_titulo=?, sessao4_texto=?, sessao5_titulo=?, sessao5_texto=?, topico1_titulo=?, topico1_texto=?, topico2_titulo=?, topico2_texto=?, topico3_titulo=?, topico3_texto=?, topico4_titulo=?, topico4_texto=?, diferenca1_titulo=?, diferenca1_texto=?, diferenca2_titulo=?, diferenca2_texto=?, diferenca3_titulo=?, diferenca3_texto=?, contato_titulo=?, contato_texto=?, imagem_final=?, imagem_mobile_final=?, nome_botao_banner=?, link_botao_banner=?, nome_botao_sessao1=?, link_botao_sessao1=?, nome_botao_sessao2=?, link_botao_sessao2=?, nome_botao_sessao4=?, link_botao_sessao4=?, titulo_texto=?, texto_corrido=?, banner_SubTitulo=?, banner_SubTitulo2=?, banner_TituloPreco=?, banner_Preco=?, banner_Condicoes=?, sessao1_SubTitulo=?, sessao1_Coluna2Linha1=?, sessao1_Coluna3Linha1=?, sessao1_Coluna4Linha1=?, sessao1_Coluna1Linha2=?, sessao1_Coluna2Linha2=?, sessao1_Coluna3Linha2=?, sessao1_Coluna4Linha2=?, sessao1_Coluna1Linha3=?, sessao1_Coluna2Linha3=?, sessao1_Coluna3Linha3=?, sessao1_Coluna4Linha3=?, sessao2_tituloColuna1=?, sessao2_tituloColuna2=?, sessao2_tituloColuna3=?, sessao2_tituloColuna4=?, sessao2_textoColuna1=?, sessao2_textoColuna2=?, sessao2_textoColuna3=?, sessao2_textoColuna4=?, sessao1_foto_icone1=?, sessao1_foto_icone2=?, sessao3_iconeColuna1=?, sessao3_iconeColuna2=?, sessao3_iconeColuna3=?, sessao3_tituloColuna1=?, sessao3_tituloColuna2=?, sessao3_tituloColuna3=?, sessao3_textoColuna1=?, sessao3_textoColuna2=?, sessao3_textoColuna3=?, sessao3_tituloPrecoColuna1=?, sessao3_tituloPrecoColuna2=?, sessao3_tituloPrecoColuna3=?, sessao3_PrecoColuna1=?, sessao3_PrecoColuna2=?, sessao3_PrecoColuna3=?, sessao3_CondicoesPrecoColuna1=?, sessao3_CondicoesPrecoColuna2=?, sessao3_CondicoesPrecoColuna3=?, nome_botao1_sessao3=?, link_botao1_sessao3=?, nome_botao2_sessao3=?, link_botao2_sessao3=?, nome_botao3_sessao3=?, link_botao3_sessao3=?, sessao4_SubTitulo=?, sessao4_icone=?, nome_botao_sessao5=?, link_botao_sessao5=?, sessao5_foto1=?, sessao5_foto2=?, sessao5_foto3=?, sessao5_foto4=? WHERE id=?";
					$stm = $this->pdo->prepare($sql);
					$stm->bindValue(1, upload('foto', $pastaArquivos, 'N'));
					$stm->bindValue(2, $titulo);
					$stm->bindValue(3, $descricao);
					$stm->bindValue(4, $id_cat);
					$stm->bindValue(5, $meta_title);
					$stm->bindValue(6, $meta_keywords);
					$stm->bindValue(7, $meta_description);
					$stm->bindValue(8, $urlAmigavel);
					$stm->bindValue(9, $breve);
					$stm->bindValue(10, upload('banner_foto', $pastaArquivos, 'N')); 
					$stm->bindValue(11, upload('sessao1_foto', $pastaArquivos, 'N')); 
					$stm->bindValue(12, upload('sessao2_foto', $pastaArquivos, 'N')); 
					$stm->bindValue(13, upload('sessao4_foto', $pastaArquivos, 'N')); 
					$stm->bindValue(14, upload('topico1_foto', $pastaArquivos, 'N')); 
					$stm->bindValue(15, upload('topico2_foto', $pastaArquivos, 'N')); 
					$stm->bindValue(16, upload('topico3_foto', $pastaArquivos, 'N')); 
					$stm->bindValue(17, upload('topico4_foto', $pastaArquivos, 'N')); 
					$stm->bindValue(18, upload('diferenca1_foto', $pastaArquivos, 'N')); 
					$stm->bindValue(19, upload('diferenca2_foto', $pastaArquivos, 'N')); 
					$stm->bindValue(20, upload('diferenca3_foto', $pastaArquivos, 'N'));
					$stm->bindValue(21, $banner_titulo);
					$stm->bindValue(22, $banner_texto);
					$stm->bindValue(23, $sessao1_titulo);
					$stm->bindValue(24, $sessao1_texto);
					$stm->bindValue(25, $sessao2_titulo);
					$stm->bindValue(26, $sessao2_texto);
					$stm->bindValue(27, $sessao3_titulo);
					$stm->bindValue(28, $sessao3_texto);
					$stm->bindValue(29, $sessao4_titulo);
					$stm->bindValue(30, $sessao4_texto);
					$stm->bindValue(31, $sessao5_titulo);
					$stm->bindValue(32, $sessao5_texto);
					$stm->bindValue(33, $topico1_titulo);
					$stm->bindValue(34, $topico1_texto);
					$stm->bindValue(35, $topico2_titulo);
					$stm->bindValue(36, $topico2_texto);
					$stm->bindValue(37, $topico3_titulo);
					$stm->bindValue(38, $topico3_texto);
					$stm->bindValue(39, $topico4_titulo);
					$stm->bindValue(40, $topico4_texto);
					$stm->bindValue(41, $diferenca1_titulo);
					$stm->bindValue(42, $diferenca1_texto);
					$stm->bindValue(43, $diferenca2_titulo);
					$stm->bindValue(44, $diferenca2_texto);
					$stm->bindValue(45, $diferenca3_titulo);
					$stm->bindValue(46, $diferenca3_texto);
					$stm->bindValue(47, $contato_titulo);
					$stm->bindValue(48, $contato_texto);
					$stm->bindValue(49, upload('imagem_final', $pastaArquivos, 'N'));
					$stm->bindValue(50, upload('imagem_mobile_final', $pastaArquivos, 'N'));
					$stm->bindValue(51, $nome_botao_banner);
					$stm->bindValue(52, $link_botao_banner);
					$stm->bindValue(53, $nome_botao_sessao1);
					$stm->bindValue(54, $link_botao_sessao1);
					$stm->bindValue(55, $nome_botao_sessao2);
					$stm->bindValue(56, $link_botao_sessao2);
					$stm->bindValue(57, $nome_botao_sessao4);
					$stm->bindValue(58, $link_botao_sessao4);
					$stm->bindValue(59, $titulo_texto);
					$stm->bindValue(60, $texto_corrido);
					$stm->bindValue(61, $banner_SubTitulo);
					$stm->bindValue(62, $banner_SubTitulo2);
					$stm->bindValue(63, $banner_TituloPreco);
					$stm->bindValue(64, $banner_Preco);
					$stm->bindValue(65, $banner_Condicoes);
					$stm->bindValue(66, $sessao1_SubTitulo);
					$stm->bindValue(67, $sessao1_Coluna2Linha1);
					$stm->bindValue(68, $sessao1_Coluna3Linha1);
					$stm->bindValue(69, $sessao1_Coluna4Linha1);
					$stm->bindValue(70, $sessao1_Coluna1Linha2);
					$stm->bindValue(71, $sessao1_Coluna2Linha2);
					$stm->bindValue(72, $sessao1_Coluna3Linha2);
					$stm->bindValue(73, $sessao1_Coluna4Linha2);
					$stm->bindValue(74, $sessao1_Coluna1Linha3);
					$stm->bindValue(75, $sessao1_Coluna2Linha3);
					$stm->bindValue(76, $sessao1_Coluna3Linha3);
					$stm->bindValue(77, $sessao1_Coluna4Linha3);
					$stm->bindValue(78, $sessao2_tituloColuna1);
					$stm->bindValue(79, $sessao2_tituloColuna2);
					$stm->bindValue(80, $sessao2_tituloColuna3);
					$stm->bindValue(81, $sessao2_tituloColuna4);
					$stm->bindValue(82, $sessao2_textoColuna1);
					$stm->bindValue(83, $sessao2_textoColuna2);
					$stm->bindValue(84, $sessao2_textoColuna3);
					$stm->bindValue(85, $sessao2_textoColuna4);
					$stm->bindValue(86, upload('sessao1_foto_icone1', $pastaArquivos, 'N')); 
					$stm->bindValue(87, upload('sessao1_foto_icone2', $pastaArquivos, 'N'));
					$stm->bindValue(88, upload('sessao3_iconeColuna1', $pastaArquivos, 'N'));
					$stm->bindValue(89, upload('sessao3_iconeColuna2', $pastaArquivos, 'N'));
					$stm->bindValue(90, upload('sessao3_iconeColuna3', $pastaArquivos, 'N'));
					$stm->bindValue(91, $sessao3_tituloColuna1); 
					$stm->bindValue(92, $sessao3_tituloColuna2); 
					$stm->bindValue(93, $sessao3_tituloColuna3); 
					$stm->bindValue(94, $sessao3_textoColuna1); 
					$stm->bindValue(95, $sessao3_textoColuna2); 
					$stm->bindValue(96, $sessao3_textoColuna3); 
					$stm->bindValue(97, $sessao3_tituloPrecoColuna1);
					$stm->bindValue(98, $sessao3_tituloPrecoColuna2);
					$stm->bindValue(99, $sessao3_tituloPrecoColuna3);
					$stm->bindValue(100, $sessao3_PrecoColuna1);
					$stm->bindValue(101, $sessao3_PrecoColuna2);
					$stm->bindValue(102, $sessao3_PrecoColuna3);
					$stm->bindValue(103, $sessao3_CondicoesPrecoColuna1);
					$stm->bindValue(104, $sessao3_CondicoesPrecoColuna2);
					$stm->bindValue(105, $sessao3_CondicoesPrecoColuna3);
					$stm->bindValue(106, $nome_botao1_sessao3);
					$stm->bindValue(107, $link_botao1_sessao3);
					$stm->bindValue(108, $nome_botao2_sessao3);
					$stm->bindValue(109, $link_botao2_sessao3);
					$stm->bindValue(110, $nome_botao3_sessao3);
					$stm->bindValue(111, $link_botao3_sessao3);
					$stm->bindValue(112, $sessao4_SubTitulo);					
					$stm->bindValue(113, upload('sessao4_icone', $pastaArquivos, 'N'));
					$stm->bindValue(114, $nome_botao_sessao5);
					$stm->bindValue(115, $link_botao_sessao5);
					$stm->bindValue(116, upload('sessao5_foto1', $pastaArquivos, 'N'));
					$stm->bindValue(117, upload('sessao5_foto2', $pastaArquivos, 'N'));
					$stm->bindValue(118, upload('sessao5_foto3', $pastaArquivos, 'N'));
					$stm->bindValue(119, upload('sessao5_foto4', $pastaArquivos, 'N'));
					$stm->bindValue(120, $id);
					echo exec('whoami');
					exit;
					$stm->execute(); 
					
					
					
					
				} catch(PDOException $erro){
					echo $erro->getMessage(); 
				
				}
				
				echo "	<script>
							window.location='{$redireciona}';
							</script>";
							exit;
			}
		}
		
		function excluir() {
			if(isset($_GET['acao']) && $_GET['acao'] == 'excluirServico') {
				
				try{   
					$sql = "DELETE FROM tbl_servicos WHERE id=? ";   
					$stm = $this->pdo->prepare($sql);   
					$stm->bindValue(1, $_GET['id']);   
					$stm->execute();
				} catch(PDOException $erro){
					echo $erro->getMessage(); 
				}

				echo "	<script>
								window.location='servicos.php';
								</script>";
								exit;

			}
		}

		function rsCatServicos($id='', $orderBy='', $limite='') {
			
			/// FILTROS
			$nCampos = 0;
			$sql = '';
			$sqlOrdem = ''; 
			$sqlLimite = '';
			if(!empty($id)) {
				$sql .= " and id = ?"; 
				$nCampos++;
				$campo[$nCampos] = $id;
			}
		
			/// ORDEM		
			if(!empty($orderBy)) {
				$sqlOrdem = " order by {$orderBy}";
			}
			
			if(!empty($limite)) {
				$sqlLimite = " limit 0,{$limite}";
			}
			
			try{   
				$sql = "SELECT * FROM tbl_cat_servicos where 1=1 $sql $sqlOrdem $sqlLimite";
				$stm = $this->pdo->prepare($sql);
				
				for($i=1; $i<=$nCampos; $i++) {
					$stm->bindValue($i, $campo[$i]);
				}
				
				$stm->execute();
				$rsDados = $stm->fetchAll(PDO::FETCH_OBJ);
				//print_r($rsDados);
				if($id <> '' or $limite == 1) {
					return($rsDados[0]);
				} else {
					return($rsDados);
				}
			} catch(PDOException $erro){   
				echo $erro->getMessage(); 
			}
		}

	}
	
	$ServicosInstanciada = 'S';
}