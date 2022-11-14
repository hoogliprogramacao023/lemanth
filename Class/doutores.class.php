<?php
@ session_start();
$DoutoresInstanciada = '';
if(empty($DoutoresInstanciada)) {
	if(file_exists('Connection/conexao.php')) {
		require_once('Connection/con-pdo.php');
		require_once('funcoes.php');
	} else {
		require_once('../Connection/con-pdo.php');
		require_once('../funcoes.php');
	}
	
	class Doutores {
		
		private $pdo = null;  

		private static $Doutores = null; 

		private function __construct($conexao){  
			$this->pdo = $conexao;  
		}
	  
		public static function getInstance($conexao){   
			if (!isset(self::$Doutores)):    
				self::$Doutores = new Doutores($conexao);   
			endif;
			return self::$Doutores;    
		}
		
	
		function rsDados($id='', $orderBy='', $limite='', $veioDeOnde='', $idDiferente='', $url_amigavel='', $pertence='') {
			
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

			if(!empty($pertence)) {
				$sql .= " and pertence_ao = ?"; 
				$nCampos++;
				$campo[$nCampos] = $pertence;
			}

			/// ORDEM		
			if(!empty($orderBy)) {
				$sqlOrdem = " order by {$orderBy}";
			}
			
			if(!empty($limite)) {
				$sqlLimite = " limit 0,{$limite}";
			}
			
			try{   
				$sql = "SELECT * FROM tbl_doutores where 1=1 $sql $sqlOrdem $sqlLimite";
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
			if(isset($_POST['acao']) && $_POST['acao'] == 'addDoutor') {

				
				$nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
				$especialidade = filter_input(INPUT_POST, 'especialidade', FILTER_SANITIZE_STRING);
				//$curriculo = filter_input(INPUT_POST, 'curriculo', FILTER_SANITIZE_STRING);
				$curriculo = $_POST['curriculo'];
				$sexo = filter_input(INPUT_POST, 'sexo', FILTER_SANITIZE_STRING);
				$meta_title = filter_input(INPUT_POST, 'meta_title', FILTER_SANITIZE_STRING);
				$meta_keywords = filter_input(INPUT_POST, 'meta_keywords', FILTER_SANITIZE_STRING);
				$meta_description = filter_input(INPUT_POST, 'meta_description', FILTER_SANITIZE_STRING);
				$graduacao = filter_input(INPUT_POST, 'graduacao', FILTER_SANITIZE_STRING);
				$linguagem = filter_input(INPUT_POST, 'linguagem', FILTER_SANITIZE_STRING);
				$dias_trabalho = filter_input(INPUT_POST, 'dias_trabalho', FILTER_SANITIZE_STRING);
				$telefone = filter_input(INPUT_POST, 'telefone', FILTER_SANITIZE_STRING);
				$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);
				$breve = filter_input(INPUT_POST, 'breve', FILTER_SANITIZE_STRING);
				$instagram = filter_input(INPUT_POST, 'instagram', FILTER_SANITIZE_STRING);
				$facebook = filter_input(INPUT_POST, 'facebook', FILTER_SANITIZE_STRING);
				$linkedin = filter_input(INPUT_POST, 'linkedin', FILTER_SANITIZE_STRING);
				$twitter = filter_input(INPUT_POST, 'twitter', FILTER_SANITIZE_STRING);
				$pertence_ao = filter_input(INPUT_POST, 'pertence_ao', FILTER_SANITIZE_STRING);
				$id_categoria = filter_input(INPUT_POST, 'id_categoria', FILTER_SANITIZE_STRING);
				$cargo = filter_input(INPUT_POST, 'cargo', FILTER_SANITIZE_STRING);
				$urlAmigavel = gerarTituloSEO($nome);
				
					try{

						if(file_exists('Connection/conexao.php')) {
							$pastaArquivos = 'img';
						} else {
							$pastaArquivos = '../img';
						}
						
						$sql = "INSERT INTO tbl_doutores (foto, nome, especialidade, curriculo, sexo, meta_title, meta_keywords, meta_description, graduacao, linguagem, dias_trabalho, telefone, email, url_amigavel, breve, instagram, facebook, linkedin, twitter, pertence_ao, id_categoria, cargo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";   
						$stm = $this->pdo->prepare($sql);   
						$stm->bindValue(1, upload('foto', $pastaArquivos, 'N'));   
						$stm->bindValue(2, $nome);   
						$stm->bindValue(3, $especialidade);
						$stm->bindValue(4, $curriculo);
						$stm->bindValue(5, $sexo);
						$stm->bindValue(6, $meta_title);
						$stm->bindValue(7, $meta_keywords);
						$stm->bindValue(8, $meta_description);
						$stm->bindValue(9, $graduacao);
						$stm->bindValue(10, $linguagem);
						$stm->bindValue(11, $dias_trabalho); 
						$stm->bindValue(12, $telefone); 
						$stm->bindValue(13, $email);
						$stm->bindValue(14, $urlAmigavel);
						$stm->bindValue(15, $breve);
						$stm->bindValue(16, $instagram);
						$stm->bindValue(17, $facebook);
						$stm->bindValue(18, $linkedin);
						$stm->bindValue(19, $twitter);  
						$stm->bindValue(20, $pertence_ao);
						$stm->bindValue(21, $id_categoria); 
						$stm->bindValue(22, $cargo);  
						$stm->execute(); 
						$idBanner = $this->pdo->lastInsertId();
						
						if($redireciona == '') {
							$redireciona = '.';
						}
						
						
					} catch(PDOException $erro){
						echo $erro->getMessage(); 
					}
					echo "	<script>
								window.location='especialistas.php?pertence=$pertence_ao';
								</script>";
								exit;
				
			}
		}
		
		function editar() {
			if(isset($_POST['acao']) && $_POST['acao'] == 'editaDoutor') {

				$nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
				$especialidade = filter_input(INPUT_POST, 'especialidade', FILTER_SANITIZE_STRING);
				//$curriculo = filter_input(INPUT_POST, 'curriculo', FILTER_SANITIZE_STRING);
				$curriculo = $_POST['curriculo'];
				$sexo = filter_input(INPUT_POST, 'sexo', FILTER_SANITIZE_STRING);
				$meta_title = filter_input(INPUT_POST, 'meta_title', FILTER_SANITIZE_STRING);
				$meta_keywords = filter_input(INPUT_POST, 'meta_keywords', FILTER_SANITIZE_STRING);
				$meta_description = filter_input(INPUT_POST, 'meta_description', FILTER_SANITIZE_STRING);
				$graduacao = filter_input(INPUT_POST, 'graduacao', FILTER_SANITIZE_STRING);
				$linguagem = filter_input(INPUT_POST, 'linguagem', FILTER_SANITIZE_STRING);
				$dias_trabalho = filter_input(INPUT_POST, 'dias_trabalho', FILTER_SANITIZE_STRING);
				$telefone = filter_input(INPUT_POST, 'telefone', FILTER_SANITIZE_STRING);
				$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);
				$id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_STRING);
				$breve = filter_input(INPUT_POST, 'breve', FILTER_SANITIZE_STRING);
				$instagram = filter_input(INPUT_POST, 'instagram', FILTER_SANITIZE_STRING);
				$facebook = filter_input(INPUT_POST, 'facebook', FILTER_SANITIZE_STRING);
				$linkedin = filter_input(INPUT_POST, 'linkedin', FILTER_SANITIZE_STRING);
				$twitter = filter_input(INPUT_POST, 'twitter', FILTER_SANITIZE_STRING);
				$pertence_ao = filter_input(INPUT_POST, 'pertence_ao', FILTER_SANITIZE_STRING);
				$id_categoria = filter_input(INPUT_POST, 'id_categoria', FILTER_SANITIZE_STRING);
				$cargo = filter_input(INPUT_POST, 'cargo', FILTER_SANITIZE_STRING);
				$urlAmigavel = gerarTituloSEO($nome);
				
				try { 

					if(file_exists('Connection/conexao.php')) {
							$pastaArquivos = 'img';
						} else {
							$pastaArquivos = '../img';
						}
				
					$sql = "UPDATE tbl_doutores SET foto=?, nome=?, especialidade=?, curriculo=?, sexo=?, meta_title=?, meta_keywords=?, meta_description=?, graduacao=?, linguagem=?, dias_trabalho=?, telefone=?, email=?, url_amigavel=?, breve=?, instagram=?, facebook=?, linkedin=?, twitter=?, pertence_ao=?, id_categoria=?, cargo=? WHERE id=?";   
					$stm = $this->pdo->prepare($sql);   
					$stm->bindValue(1, upload('foto', $pastaArquivos, 'N'));   
					$stm->bindValue(2, $nome);   
					$stm->bindValue(3, $especialidade);   
					$stm->bindValue(4, $curriculo);
					$stm->bindValue(5, $sexo);
					$stm->bindValue(6, $meta_title);
					$stm->bindValue(7, $meta_keywords);
					$stm->bindValue(8, $meta_description);
					$stm->bindValue(9, $graduacao);
					$stm->bindValue(10, $linguagem);
					$stm->bindValue(11, $dias_trabalho);
					$stm->bindValue(12, $telefone);   
					$stm->bindValue(13, $email);   
					$stm->bindValue(14, $urlAmigavel);
					$stm->bindValue(15, $breve);
					$stm->bindValue(16, $instagram);
					$stm->bindValue(17, $facebook);
					$stm->bindValue(18, $linkedin);
					$stm->bindValue(19, $twitter);
					$stm->bindValue(20, $pertence_ao);    
					$stm->bindValue(21, $id_categoria);
					$stm->bindValue(22, $cargo);
					$stm->bindValue(23, $id);   
					$stm->execute(); 
										
				} catch(PDOException $erro){
					echo $erro->getMessage(); 
				}

				echo "	<script>
							window.location='especialistas.php?pertence=$pertence_ao';
						</script>";
						exit;
			}
		}
		
		function excluir() {
			if(isset($_GET['acao']) && $_GET['acao'] == 'excluirDoutor') {
				
				try{   
					$sql = "DELETE FROM tbl_doutores WHERE id=? ";   
					$stm = $this->pdo->prepare($sql);   
					$stm->bindValue(1, $_GET['id']);   
					$stm->execute();
				} catch(PDOException $erro){
					echo $erro->getMessage(); 
				}
				$pertence_ao = $_GET['pertence'];
				echo "	<script>
							window.location='especialistas.php?pertence=$pertence_ao';
						</script>";
						exit;

			}
		}
	}
	
	$DoutoresInstanciada = 'S';
}