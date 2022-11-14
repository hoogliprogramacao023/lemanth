<?php
@ session_start();
$SolucoesInstanciada = '';
if(empty($SolucoesInstanciada)) {
	if(file_exists('Connection/conexao.php')) {
		require_once('Connection/con-pdo.php');
		require_once('funcoes.php');
	} else {
		require_once('../Connection/con-pdo.php');
		require_once('../funcoes.php');
	}
	
	class Solucoes {
		
		private $pdo = null;  

		private static $Solucoes = null; 

		private function __construct($conexao){  
			$this->pdo = $conexao;  
		}
	  
		public static function getInstance($conexao){   
			if (!isset(self::$Solucoes)):    
				self::$Solucoes = new Solucoes($conexao);   
			endif;
			return self::$Solucoes;    
		}
		
	
		function rsDados($id='', $orderBy='', $limite='', $veioDeOnde='', $idDiferente='', $url_amigavel='') {
			
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
			if(!empty($idDiferente)) {
				$sql .= " and id != ?"; 
				$nCampos++;
				$campo[$nCampos] = $idDiferente;
			}
			if(!empty($veioDeOnde)) {
				$sql .= " and veio_de_onde = ?"; 
				$nCampos++;
				$campo[$nCampos] = $veioDeOnde;
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
				$sqlLimite = " limit 0,{$limite}";
			}
			
			try{   
				$sql = "SELECT * FROM tbl_solucoes where 1=1 $sql $sqlOrdem $sqlLimite";
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
			if(isset($_POST['acao']) && $_POST['acao'] == 'addSolucao') {

				
				$titulo = filter_input(INPUT_POST, 'titulo', FILTER_SANITIZE_STRING);
				$postado_por = filter_input(INPUT_POST, 'postado_por', FILTER_SANITIZE_STRING);
				//$conteudo = filter_input(INPUT_POST, 'conteudo', FILTER_SANITIZE_STRING);
				$conteudo = $_POST['conteudo'];
				$data_postagem = filter_input(INPUT_POST, 'data_postagem', FILTER_SANITIZE_STRING);
				$especialidade = filter_input(INPUT_POST, 'especialidade', FILTER_SANITIZE_STRING);
				$breve = filter_input(INPUT_POST, 'breve', FILTER_SANITIZE_STRING);
				$meta_title = filter_input(INPUT_POST, 'meta_title', FILTER_SANITIZE_STRING);
				$meta_keywords = filter_input(INPUT_POST, 'meta_keywords', FILTER_SANITIZE_STRING);
				$meta_description = filter_input(INPUT_POST, 'meta_description', FILTER_SANITIZE_STRING);
				$descricao_imagem = filter_input(INPUT_POST, 'descricao_imagem', FILTER_SANITIZE_STRING);
				$legenda_imagem = filter_input(INPUT_POST, 'legenda_imagem', FILTER_SANITIZE_STRING);
				$urlAmigavel = gerarTituloSEO($titulo);
					try{

						if(file_exists('Connection/conexao.php')) {
							$pastaArquivos = 'img';
						} else {
							$pastaArquivos = '../img';
						}
						
						$sql = "INSERT INTO tbl_solucoes (foto, titulo, postado_por, conteudo, data_postagem, especialidade, breve, meta_title, meta_keywords, meta_description, foto1, url_amigavel, descricao_imagem, legenda_imagem) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";   
						$stm = $this->pdo->prepare($sql);   
						$stm->bindValue(1, upload('foto', $pastaArquivos, 'N'));   
						$stm->bindValue(2, $titulo);   
						$stm->bindValue(3, $postado_por);
						$stm->bindValue(4, $conteudo);
						$stm->bindValue(5, $data_postagem);
						$stm->bindValue(6, $especialidade);
						$stm->bindValue(7, $breve);
						$stm->bindValue(8, $meta_title);
						$stm->bindValue(9, $meta_keywords);
						$stm->bindValue(10, $meta_description); 
						$stm->bindValue(11, upload('foto1', $pastaArquivos, 'N')); 
						$stm->bindValue(12, $urlAmigavel);
						$stm->bindValue(13, $descricao_imagem);
						$stm->bindValue(14, $legenda_imagem);
						$stm->execute(); 
						$idBanner = $this->pdo->lastInsertId();
						
						if($redireciona == '') {
							$redireciona = '.';
						}
						
						
					} catch(PDOException $erro){
						echo $erro->getMessage(); 
					}
					echo "	<script>
								window.location='solucoes.php';
								</script>";
								exit;
				
			}
		}
		
		function editar($redireciona='solucoes.php') {
			if(isset($_POST['acao']) && $_POST['acao'] == 'editaSolucao') {

				$titulo = filter_input(INPUT_POST, 'titulo', FILTER_SANITIZE_STRING);
				$postado_por = filter_input(INPUT_POST, 'postado_por', FILTER_SANITIZE_STRING);
				//$conteudo = filter_input(INPUT_POST, 'conteudo', FILTER_SANITIZE_STRING);
				$conteudo = $_POST['conteudo'];
				$data_postagem = filter_input(INPUT_POST, 'data_postagem', FILTER_SANITIZE_STRING);
				$especialidade = filter_input(INPUT_POST, 'especialidade', FILTER_SANITIZE_STRING);
				$breve = filter_input(INPUT_POST, 'breve', FILTER_SANITIZE_STRING);
				$meta_title = filter_input(INPUT_POST, 'meta_title', FILTER_SANITIZE_STRING);
				$meta_keywords = filter_input(INPUT_POST, 'meta_keywords', FILTER_SANITIZE_STRING);
				$meta_description = filter_input(INPUT_POST, 'meta_description', FILTER_SANITIZE_STRING);
				$descricao_imagem = filter_input(INPUT_POST, 'descricao_imagem', FILTER_SANITIZE_STRING);
				$legenda_imagem = filter_input(INPUT_POST, 'legenda_imagem', FILTER_SANITIZE_STRING);
				$id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_STRING);
				$urlAmigavel = gerarTituloSEO($titulo);
				
				try { 

					if(file_exists('Connection/conexao.php')) {
							$pastaArquivos = 'img';
						} else {
							$pastaArquivos = '../img';
						}
				
					$sql = "UPDATE tbl_solucoes SET foto=?, titulo=?, postado_por=?, conteudo=?, data_postagem=?, especialidade=?, breve=?, meta_title=?, meta_keywords=?, meta_description=?, foto1=?, url_amigavel=?, descricao_imagem=?, legenda_imagem=? WHERE id=?";   
					$stm = $this->pdo->prepare($sql);   
					$stm->bindValue(1, upload('foto', $pastaArquivos, 'N'));   
					$stm->bindValue(2, $titulo);   
					$stm->bindValue(3, $postado_por);
					$stm->bindValue(4, $conteudo);
					$stm->bindValue(5, $data_postagem);
					$stm->bindValue(6, $especialidade); 
					$stm->bindValue(7, $breve);
					$stm->bindValue(8, $meta_title);
					$stm->bindValue(9, $meta_keywords);
					$stm->bindValue(10, $meta_description);
					$stm->bindValue(11, upload('foto1', $pastaArquivos, 'N'));
					$stm->bindValue(12, $urlAmigavel);
					$stm->bindValue(13, $descricao_imagem);
					$stm->bindValue(14, $legenda_imagem);
					$stm->bindValue(15, $id);   
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
			if(isset($_GET['acao']) && $_GET['acao'] == 'excluirSolucao') {
				
				try{   
					$sql = "DELETE FROM tbl_solucoes WHERE id=? ";   
					$stm = $this->pdo->prepare($sql);   
					$stm->bindValue(1, $_GET['id']);   
					$stm->execute();
				} catch(PDOException $erro){
					echo $erro->getMessage(); 
				}
				echo "	<script>
								window.location='solucoes.php';
								</script>";
								exit;

			}
		}
	}
	
	$SolucoesInstanciada = 'S';
}