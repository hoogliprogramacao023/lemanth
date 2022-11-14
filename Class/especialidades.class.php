<?php
@ session_start();
$EspecialidadesInstanciada = '';
if(empty($EspecialidadesInstanciada)) {
	if(file_exists('Connection/conexao.php')) {
		require_once('Connection/con-pdo.php');
		require_once('funcoes.php');
	} else {
		require_once('../Connection/con-pdo.php');
		require_once('../funcoes.php');
	}
	
	class Especialidades {
		
		private $pdo = null;  

		private static $Especialidades = null; 

		private function __construct($conexao){  
			$this->pdo = $conexao;  
		}
	  
		public static function getInstance($conexao){   
			if (!isset(self::$Especialidades)):    
				self::$Especialidades = new Especialidades($conexao);   
			endif;
			return self::$Especialidades;    
		}
		
	
		function rsDados($id='', $orderBy='', $limite='', $id_categoria='') {
			
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
			if(!empty($id_categoria)) {
				$sql .= " and id_categoria = ?"; 
				$nCampos++;
				$campo[$nCampos] = $id_categoria;
			}
		
			/// ORDEM		
			if(!empty($orderBy)) {
				$sqlOrdem = " order by {$orderBy}";
			}
			
			if(!empty($limite)) {
				$sqlLimite = " limit 0,{$limite}";
			}
			
			try{   
				$sql = "SELECT * FROM tbl_especialidades where 1=1 $sql $sqlOrdem $sqlLimite";
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
			if(isset($_POST['acao']) && $_POST['acao'] == 'addEspecialidade') {
	
				$titulo = filter_input(INPUT_POST, 'titulo', FILTER_SANITIZE_STRING);
				//$descricao = filter_input(INPUT_POST, 'descricao', FILTER_SANITIZE_STRING);
				$descricao = $_POST['descricao'];
				$meta_title = filter_input(INPUT_POST, 'meta_title', FILTER_SANITIZE_STRING);
				$meta_keywords = filter_input(INPUT_POST, 'meta_keywords', FILTER_SANITIZE_STRING);
				$meta_description = filter_input(INPUT_POST, 'meta_description', FILTER_SANITIZE_STRING);
				$breve = filter_input(INPUT_POST, 'breve', FILTER_SANITIZE_STRING);
				$id_categoria = filter_input(INPUT_POST, 'id_categoria', FILTER_SANITIZE_STRING);
				$descricao_imagem = filter_input(INPUT_POST, 'descricao_imagem', FILTER_SANITIZE_STRING);
				$legenda_imagem = filter_input(INPUT_POST, 'legenda_imagem', FILTER_SANITIZE_STRING);
				$urlAmigavel = gerarTituloSEO($titulo);

				
					try{

						if(file_exists('Connection/conexao.php')) {
							$pastaArquivos = 'img';
						} else {
							$pastaArquivos = '../img';
						}
						
						$sql = "INSERT INTO tbl_especialidades (foto, titulo, descricao, meta_title, meta_keywords, meta_description, breve, id_categoria, url_amigavel, descrica_imagem, legenda_imagem) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";   
						$stm = $this->pdo->prepare($sql);   
						$stm->bindValue(1, upload('foto', $pastaArquivos, 'N'));   
						$stm->bindValue(2, $titulo);   
						$stm->bindValue(3, $descricao);
						$stm->bindValue(4, $meta_title);   
						$stm->bindValue(5, $meta_keywords);   
						$stm->bindValue(6, $meta_description);
						$stm->bindValue(7, $breve);
						$stm->bindValue(8, $id_categoria);
						$stm->bindValue(9, $urlAmigavel);
						$stm->bindValue(10, $descricao_imagem);
						$stm->bindValue(11, $legenda_imagem);   
						$stm->execute(); 
						$idBanner = $this->pdo->lastInsertId();
						
						if($redireciona == '') {
							$redireciona = '.';
						}
						
						
					} catch(PDOException $erro){
						echo $erro->getMessage(); 
					}
					echo "	<script>
								window.location='especialidades.php';
								</script>";
								exit;
				
			}
		}
		
		function editar($redireciona='especialidades.php') {
			if(isset($_POST['acao']) && $_POST['acao'] == 'editaEspecialidade') {

				

				$titulo = filter_input(INPUT_POST, 'titulo', FILTER_SANITIZE_STRING);
				//$descricao = filter_input(INPUT_POST, 'descricao', FILTER_SANITIZE_STRING);
				$descricao = $_POST['descricao'];
				$meta_title = filter_input(INPUT_POST, 'meta_title', FILTER_SANITIZE_STRING);
				$meta_keywords = filter_input(INPUT_POST, 'meta_keywords', FILTER_SANITIZE_STRING);
				$meta_description = filter_input(INPUT_POST, 'meta_description', FILTER_SANITIZE_STRING);
				$id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_STRING);
				$breve = filter_input(INPUT_POST, 'breve', FILTER_SANITIZE_STRING);
				$id_categoria = filter_input(INPUT_POST, 'id_categoria', FILTER_SANITIZE_STRING);
				$urlAmigavel = gerarTituloSEO($titulo);
				$descricao_imagem = filter_input(INPUT_POST, 'descricao_imagem', FILTER_SANITIZE_STRING);
				$legenda_imagem = filter_input(INPUT_POST, 'legenda_imagem', FILTER_SANITIZE_STRING);

				
				try { 

					if(file_exists('Connection/conexao.php')) {
							$pastaArquivos = 'img';
						} else {
							$pastaArquivos = '../img';
						}
				
					$sql = "UPDATE tbl_especialidades SET foto=?, titulo=?, descricao=?, meta_title=?, meta_keywords=?, meta_description=?, breve=?, id_categoria=?, url_amigavel=? descricao_imagem=?, legenda_imagem=? WHERE id=?";   
					$stm = $this->pdo->prepare($sql);   
					$stm->bindValue(1, upload('foto', $pastaArquivos, 'N'));   
					$stm->bindValue(2, $titulo);   
					$stm->bindValue(3, $descricao);
					$stm->bindValue(4, $meta_title);   
					$stm->bindValue(5, $meta_keywords);   
					$stm->bindValue(6, $meta_description);
					$stm->bindValue(7, $breve);
					$stm->bindValue(8, $id_categoria);
					$stm->bindValue(9, $urlAmigavel);
					$stm->bindValue(10, $descricao_imagem);
					$stm->bindValue(11, $legenda_imagem);
					$stm->bindValue(12, $id);   
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
			if(isset($_GET['acao']) && $_GET['acao'] == 'excluirEspecialidade') {
				
				try{   
					$sql = "DELETE FROM tbl_especialidades WHERE id=? ";   
					$stm = $this->pdo->prepare($sql);   
					$stm->bindValue(1, $_GET['id']);   
					$stm->execute();
				} catch(PDOException $erro){
					echo $erro->getMessage(); 
				}

				echo "	<script>
								window.location='especialidades.php';
								</script>";
								exit;

			}
		}


	}
	
	$EspecialidadesInstanciada = 'S';
}