<?php
@ session_start();
$VideosInstanciada = '';
if(empty($VideosInstanciada)) {
	if(file_exists('Connection/conexao.php')) {
		require_once('Connection/con-pdo.php');
		require_once('funcoes.php');
	} else {
		require_once('../Connection/con-pdo.php');
		require_once('../funcoes.php');
	}
	
	class Videos {
		
		private $pdo = null;  

		private static $Videos = null; 

		private function __construct($conexao){  
			$this->pdo = $conexao;  
		}
	  
		public static function getInstance($conexao){   
			if (!isset(self::$Videos)):    
				self::$Videos = new Videos($conexao);   
			endif;
			return self::$Videos;    
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
				$sqlLimite = " limit {$limite}";
			}
			
			try{   
				$sql = "SELECT * FROM tbl_videos where 1=1 $sql $sqlOrdem $sqlLimite";
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
			if(isset($_POST['acao']) && $_POST['acao'] == 'addVideo') {

				
				$titulo = filter_input(INPUT_POST, 'titulo', FILTER_SANITIZE_STRING);
				$embed = filter_input(INPUT_POST, 'embed', FILTER_SANITIZE_STRING);
				$id_categoria = filter_input(INPUT_POST, 'id_categoria', FILTER_SANITIZE_STRING);
                
					try{

						$sql = "INSERT INTO tbl_videos (titulo, embed, id_categoria) VALUES (?, ?, ?)";   
						$stm = $this->pdo->prepare($sql);   
						$stm->bindValue(1, $titulo);
                        $stm->bindValue(2, $embed);
						$stm->bindValue(3, $id_categoria);   
						$stm->execute(); 
						$idBanner = $this->pdo->lastInsertId();
						
						if($redireciona == '') {
							$redireciona = '.';
						}
						
						
					} catch(PDOException $erro){
						echo $erro->getMessage(); 
					}
					echo "	<script>
								window.location='Videos.php';
								</script>";
								exit;
				
			}
		}
		
		function editar($redireciona='videos.php') {
			if(isset($_POST['acao']) && $_POST['acao'] == 'editaVideo') {

				$titulo = filter_input(INPUT_POST, 'titulo', FILTER_SANITIZE_STRING);
				$embed = filter_input(INPUT_POST, 'embed', FILTER_SANITIZE_STRING);
				$id_categoria = filter_input(INPUT_POST, 'id_categoria', FILTER_SANITIZE_STRING);
				$id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_STRING);
                
				
				try { 

					$sql = "UPDATE tbl_videos SET titulo=?, embed=?, id_categoria=? WHERE id=?";   
					$stm = $this->pdo->prepare($sql);   
					$stm->bindValue(1, $titulo);
					$stm->bindValue(2, $embed);
					$stm->bindValue(3, $id_categoria);
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
			if(isset($_GET['acao']) && $_GET['acao'] == 'excluirVideo') {
				
				try{   
					$sql = "DELETE FROM tbl_videos WHERE id=? ";   
					$stm = $this->pdo->prepare($sql);   
					$stm->bindValue(1, $_GET['id']);   
					$stm->execute();
				} catch(PDOException $erro){
					echo $erro->getMessage(); 
				}
				echo "	<script>
								window.location='videos.php';
								</script>";
								exit;

			}
		}
	}
	
	$VideosInstanciada = 'S';
}