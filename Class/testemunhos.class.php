<?php
@ session_start();
$TestemunhosInstanciada = '';
if(empty($TestemunhosInstanciada)) {
	if(file_exists('Connection/conexao.php')) {
		require_once('Connection/con-pdo.php');
		require_once('funcoes.php');
	} else {
		require_once('../Connection/con-pdo.php');
		require_once('../funcoes.php');
	}
	
	class Testemunhos {
		
		private $pdo = null;  

		private static $Testemunhos = null; 

		private function __construct($conexao){  
			$this->pdo = $conexao;  
		}
	  
		public static function getInstance($conexao){   
			if (!isset(self::$Testemunhos)):    
				self::$Testemunhos = new Testemunhos($conexao);   
			endif;
			return self::$Testemunhos;    
		}
	
		function rsDados($id='', $orderBy='', $limite='') {
			
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
				$sql = "SELECT * FROM tbl_testemunhos where 1=1 $sql $sqlOrdem $sqlLimite";
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
			if(isset($_POST['acao']) && $_POST['acao'] == 'addTestemunho') {
				$nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
				$testemunho = filter_input(INPUT_POST, 'testemunho', FILTER_SANITIZE_STRING);
				$sexo = filter_input(INPUT_POST, 'sexo', FILTER_SANITIZE_STRING);
				$embed = filter_input(INPUT_POST, 'embed', FILTER_SANITIZE_STRING);
				
					try{

						if(file_exists('Connection/conexao.php')) {
							$pastaArquivos = 'img';
						} else {
							$pastaArquivos = '../img';
						}
						
						$sql = "INSERT INTO tbl_testemunhos (foto, nome, testemunho, sexo, embed) VALUES (?, ?, ?, ?, ?)";   
						$stm = $this->pdo->prepare($sql);   
						$stm->bindValue(1, upload('foto', $pastaArquivos, 'N'));   
						$stm->bindValue(2, $nome);   
						$stm->bindValue(3, $testemunho);
						$stm->bindValue(4, $sexo);
						$stm->bindValue(5, $embed);   
						$stm->execute(); 
						$idBanner = $this->pdo->lastInsertId();
						
						if($redireciona == '') {
							$redireciona = '.';
						}
						
						
					} catch(PDOException $erro){
						echo $erro->getMessage(); 
					}
					echo "	<script>
								window.location='testemunhos.php';
								</script>";
								exit;
				
			}
		}
		
		function editar($redireciona='testemunhos.php') {
			if(isset($_POST['acao']) && $_POST['acao'] == 'editaTestemunho') {
				$nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
				$testemunho = filter_input(INPUT_POST, 'testemunho', FILTER_SANITIZE_STRING);
				$sexo = filter_input(INPUT_POST, 'sexo', FILTER_SANITIZE_STRING);
				$id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_STRING);
				$embed = filter_input(INPUT_POST, 'embed', FILTER_SANITIZE_STRING);
				
				try { 

					if(file_exists('Connection/conexao.php')) {
							$pastaArquivos = 'img';
						} else {
							$pastaArquivos = '../img';
						}
				
					$sql = "UPDATE tbl_testemunhos SET foto=?, nome=?, testemunho=?, sexo=?, embed=? WHERE id=?";   
					$stm = $this->pdo->prepare($sql);   
					$stm->bindValue(1, upload('foto', $pastaArquivos, 'N'));   
					$stm->bindValue(2, $nome);   
					$stm->bindValue(3, $testemunho);   
					$stm->bindValue(4, $sexo);
					$stm->bindValue(5, $embed); 
					$stm->bindValue(6, $id);   
					$stm->execute(); 
					//var_dump($_POST); exit;
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
			if(isset($_GET['acao']) && $_GET['acao'] == 'excluirTestemunho') {
				
				try{   
					$sql = "DELETE FROM tbl_testemunhos WHERE id=? ";   
					$stm = $this->pdo->prepare($sql);   
					$stm->bindValue(1, $_GET['id']);   
					$stm->execute();
				} catch(PDOException $erro){
					echo $erro->getMessage(); 
				}
				echo "	<script>
						window.location='testemunhos.php';
						</script>";
						exit;
			}
		}
	}
	
	$TestemunhosInstanciada = 'S';
}