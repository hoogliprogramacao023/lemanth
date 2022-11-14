<?php
@ session_start();
$FaqsInstanciada = '';
if(empty($FaqsInstanciada)) {
	if(file_exists('Connection/conexao.php')) {
		require_once('Connection/con-pdo.php');
		require_once('funcoes.php');
	} else {
		require_once('../Connection/con-pdo.php');
		require_once('../funcoes.php');
	}
	
	class Faqs {
		
		private $pdo = null;  

		private static $Faqs = null; 

		private function __construct($conexao){  
			$this->pdo = $conexao;  
		}
	  
		public static function getInstance($conexao){   
			if (!isset(self::$Faqs)):    
				self::$Faqs = new Faqs($conexao);   
			endif;
			return self::$Faqs;    
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
				$sql = "SELECT * FROM tbl_faq where 1=1 $sql $sqlOrdem $sqlLimite";
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
			if(isset($_POST['acao']) && $_POST['acao'] == 'addFaq') {

				
				$titulo = filter_input(INPUT_POST, 'titulo', FILTER_SANITIZE_STRING);
				$descricao = $_POST['descricao'];
				$status = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_STRING);
					try{

						$sql = "INSERT INTO tbl_faq (titulo, descricao, status) VALUES (?, ?, ?)";   
						$stm = $this->pdo->prepare($sql);   
						$stm->bindValue(1, $titulo);   
						$stm->bindValue(2, $descricao);
						$stm->bindValue(3, $status);
						$stm->execute(); 
						$idBanner = $this->pdo->lastInsertId();
						
						if($redireciona == '') {
							$redireciona = '.';
						}
						
						
					} catch(PDOException $erro){
						echo $erro->getMessage(); 
					}
					echo "	<script>
								window.location='faqs.php';
								</script>";
								exit;
				
			}
		}
		
		function editar($redireciona='faqs.php') {
			if(isset($_POST['acao']) && $_POST['acao'] == 'editaFaq') {

				$titulo = filter_input(INPUT_POST, 'titulo', FILTER_SANITIZE_STRING);
				$descricao = $_POST['descricao'];
				$status = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_STRING);
				$id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_STRING);
				
				try { 

					$sql = "UPDATE tbl_faq SET titulo=?, descricao=?, status=? WHERE id=?";   
					$stm = $this->pdo->prepare($sql);   
					$stm->bindValue(1, $titulo);   
					$stm->bindValue(2, $descricao);
					$stm->bindValue(3, $status);
					$stm->bindValue(4, $id);
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
			if(isset($_GET['acao']) && $_GET['acao'] == 'excluirFaq') {
				
				try{   
					$sql = "DELETE FROM tbl_faq WHERE id=? ";   
					$stm = $this->pdo->prepare($sql);   
					$stm->bindValue(1, $_GET['id']);   
					$stm->execute();
				} catch(PDOException $erro){
					echo $erro->getMessage(); 
				}
				echo "	<script>
								window.location='faqs.php';
								</script>";
								exit;

			}
		}
	}
	
	$FaqsInstanciada = 'S';
}