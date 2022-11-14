<?php
@ session_start();
$GaleriasInstanciada = '';
if(empty($GaleriasInstanciada)) {
	if(file_exists('Connection/conexao.php')) {
		require_once('Connection/con-pdo.php');
		require_once('funcoes.php');
	} else {
		require_once('../Connection/con-pdo.php');
		require_once('../funcoes.php');
	}
	
	class Galerias {
		
		private $pdo = null;  

		private static $Galerias = null; 

		private function __construct($conexao){  
			$this->pdo = $conexao;  
		}
	  
		public static function getInstance($conexao){   
			if (!isset(self::$Galerias)):    
				self::$Galerias = new Galerias($conexao);   
			endif;
			return self::$Galerias;    
		}
		
	
		function rsDados($id='', $orderBy='', $limite='', $destaque='', $categoria='') {
			
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
			if(!empty($destaque)) {
				$sql .= " and destaque = ?"; 
				$nCampos++;
				$campo[$nCampos] = $destaque;
			}
			if(!empty($categoria)) {
				$sql .= " and categoria = ?"; 
				$nCampos++;
				$campo[$nCampos] = $categoria;
			}
			
			/// ORDEM		
			if(!empty($orderBy)) {
				$sqlOrdem = " order by {$orderBy}";
			}
			
			if(!empty($limite)) {
				$sqlLimite = " limit 0,{$limite}";
			}
			
			try{   
				$sql = "SELECT * FROM tbl_galeria_imagem where 1=1 $sql $sqlOrdem $sqlLimite";
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
			if(isset($_POST['acao']) && $_POST['acao'] == 'addGaleria') {

				
				$destaque = filter_input(INPUT_POST, 'destaque', FILTER_SANITIZE_STRING);
				$descricao_imagem = filter_input(INPUT_POST, 'descricao_imagem', FILTER_SANITIZE_STRING);
				$legenda_imagem = filter_input(INPUT_POST, 'legenda_imagem', FILTER_SANITIZE_STRING);
				$categoria = filter_input(INPUT_POST, 'categoria', FILTER_SANITIZE_STRING);
				
					try{

						if(file_exists('Connection/conexao.php')) {
							$pastaArquivos = 'img';
						} else {
							$pastaArquivos = '../img';
						}
						
						$sql = "INSERT INTO tbl_galeria_imagem (foto, destaque, descricao_imagem, legenda_imagem, categoria) VALUES (?, ?, ?, ?, ?)";   
						$stm = $this->pdo->prepare($sql);   
						$stm->bindValue(1, upload('foto', $pastaArquivos, 'N'));   
						$stm->bindValue(2, $destaque);   
						$stm->bindValue(3, $descricao_imagem);   
						$stm->bindValue(4, $legenda_imagem);
						$stm->bindValue(5, $categoria);
						$stm->execute(); 
						$idBanner = $this->pdo->lastInsertId();
						
						if($redireciona == '') {
							$redireciona = '.';
						}
						
						
					} catch(PDOException $erro){
						echo $erro->getMessage(); 
					}
					echo "	<script>
								window.location='galerias.php';
								</script>";
								exit;
				
			}
		}
		
		function editar($redireciona='galerias.php') {
			if(isset($_POST['acao']) && $_POST['acao'] == 'editaGaleria') {

				$destaque = filter_input(INPUT_POST, 'destaque', FILTER_SANITIZE_STRING);
				$descricao_imagem = filter_input(INPUT_POST, 'descricao_imagem', FILTER_SANITIZE_STRING);
				$legenda_imagem = filter_input(INPUT_POST, 'legenda_imagem', FILTER_SANITIZE_STRING);
				$id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_STRING);
				$categoria = filter_input(INPUT_POST, 'categoria', FILTER_SANITIZE_STRING);
				
				try { 

					if(file_exists('Connection/conexao.php')) {
							$pastaArquivos = 'img';
						} else {
							$pastaArquivos = '../img';
						}
				
					$sql = "UPDATE tbl_galeria_imagem SET foto=?, destaque=?, descricao_imagem=?, legenda_imagem=?, categoria=? WHERE id=?";   
					$stm = $this->pdo->prepare($sql);   
					$stm->bindValue(1, upload('foto', $pastaArquivos, 'N'));   
					$stm->bindValue(2, $destaque);   
					$stm->bindValue(3, $descricao_imagem);   
					$stm->bindValue(4, $legenda_imagem); 
					$stm->bindValue(5, $categoria);
					$stm->bindValue(6, $id);   
					$stm->execute(); 
				} catch(PDOException $erro){
					echo $erro->getMessage(); 
				}

//var_dump($_POST);exit;
				echo "	<script>
							window.location='{$redireciona}';
							</script>";
							exit;
			}
		}
		
		function excluir() {
			if(isset($_GET['acao']) && $_GET['acao'] == 'excluirGaleria') {
				
				try{   
					$sql = "DELETE FROM tbl_galeria_imagem WHERE id=? ";   
					$stm = $this->pdo->prepare($sql);   
					$stm->bindValue(1, $_GET['id']);   
					$stm->execute();
				} catch(PDOException $erro){
					echo $erro->getMessage(); 
				}
				echo "	<script>
								window.location='galerias.php';
								</script>";
								exit;

			}
		}
	}
	
	$GaleriasInstanciada = 'S';
}