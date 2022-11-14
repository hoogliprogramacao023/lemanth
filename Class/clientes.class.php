<?php
@ session_start();
$ClientesInstanciada = '';
if(empty($ClientesInstanciada)) {
	if(file_exists('Connection/conexao.php')) {
		require_once('Connection/con-pdo.php');
		require_once('funcoes.php');
	} else {
		require_once('../Connection/con-pdo.php');
		require_once('../funcoes.php');
	}
	
	class Clientes {
		
		private $pdo = null;  

		private static $Clientes = null; 

		private function __construct($conexao){  
			$this->pdo = $conexao;  
		}
	  
		public static function getInstance($conexao){   
			if (!isset(self::$Clientes)):    
				self::$Clientes = new Clientes($conexao);   
			endif;
			return self::$Clientes;    
		}
		function logout() {
			if(isset($_GET['acao']) && $_GET['acao'] == 'logout') {
				unset($_SESSION['clienteLogado']);
				unset($_SESSION['dadosClienteLogado']);
				
			}
		}
		function login($login, $senha) {
			
			if($login <> '' and $senha <> '') {
				
				try{   
				$volta = filter_input(INPUT_POST, 'volta', FILTER_SANITIZE_STRING);
				$login_cpf = $login;
				$login_cpf = str_replace('.', '', $login_cpf);
				$login_cpf = str_replace('-', '', $login_cpf);

				if(is_numeric($login_cpf)){
					$sql = "SELECT * FROM tbl_cliente where REPLACE(REPLACE(cpf,'.', ''), '-', '') = :login and senha = :senha";
					$stm = $this->pdo->prepare($sql);
					$stm->bindValue(':login', $login_cpf, PDO::PARAM_STR);
					$stm->bindValue(':senha', $senha, PDO::PARAM_STR);
					$stm->execute();   
					$rsDados = $stm->fetchAll(PDO::FETCH_OBJ);
				}else{
					$login_email = $login;
					$sql = "SELECT * FROM tbl_cliente where email = :login and senha = :senha";
					$stm = $this->pdo->prepare($sql);
					$stm->bindValue(':login', $login_email, PDO::PARAM_STR);
					$stm->bindValue(':senha', $senha, PDO::PARAM_STR);
					$stm->execute();   
					$rsDados = $stm->fetchAll(PDO::FETCH_OBJ);

				}

					
					
					if(!empty($rsDados[0]->id)) {
						
						$_SESSION['clienteLogado'] = 'S';
						$_SESSION['dadosClienteLogado'] = $rsDados[0];
						if(isset($volta) && !empty($volta)){
						echo "	<script>
								window.location='{$volta}';
								</script>";
								exit;
						}else{
						echo "	<script>
							window.location='area-cliente';
							</script>";
							exit;
						}
						
					} else {
						echo "	<script>
								alert('Dados inválidos. Por favor, verifique os dados digitados.');
								window.location='login';
								</script>";
								exit;
					}
					
				} catch(PDOException $erro){   
					echo $erro->getMessage(); 
				}
			}
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
				$sql = "SELECT * FROM tbl_cliente where 1=1 $sql $sqlOrdem $sqlLimite";
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
			if(isset($_POST['acao']) && $_POST['acao'] == 'addCliente') {

				
				$nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
				$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);
				$telefone = filter_input(INPUT_POST, 'telefone', FILTER_SANITIZE_STRING);
				$sexo = filter_input(INPUT_POST, 'sexo', FILTER_SANITIZE_STRING);
				$senha = filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_STRING);
				$veio_de = filter_input(INPUT_POST, 'veio_de', FILTER_SANITIZE_STRING);
				$cep = filter_input(INPUT_POST, 'cep', FILTER_SANITIZE_STRING);
				$endereco = filter_input(INPUT_POST, 'endereco', FILTER_SANITIZE_STRING);
				$id_estado = filter_input(INPUT_POST, 'id_estado', FILTER_SANITIZE_STRING);
				$id_cidade = filter_input(INPUT_POST, 'id_cidade', FILTER_SANITIZE_STRING);
				$bairro = filter_input(INPUT_POST, 'bairro', FILTER_SANITIZE_STRING);
				$numero = filter_input(INPUT_POST, 'numero', FILTER_SANITIZE_STRING);
				$complemento = filter_input(INPUT_POST, 'complemento', FILTER_SANITIZE_STRING);
					try{

						$sql = "INSERT INTO tbl_cliente (nome, email, telefone, sexo, senha, cep, endereco, id_estado, id_cidade, bairro, numero, complemento) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";   
						$stm = $this->pdo->prepare($sql);   
						$stm->bindValue(1, $nome);   
						$stm->bindValue(2, $email);
						$stm->bindValue(3, $telefone);
						$stm->bindValue(4, $sexo);
						$stm->bindValue(5, $senha);
						$stm->bindValue(6, $cep);
						$stm->bindValue(7, $endereco);
						$stm->bindValue(8, $id_estado);
						$stm->bindValue(9, $id_cidade);
						$stm->bindValue(10, $bairro);
						$stm->bindValue(11, $numero);
						$stm->bindValue(12, $complemento);
						$stm->execute(); 
						$idBanner = $this->pdo->lastInsertId();
						
						if($redireciona == '') {
							$redireciona = '.';
						}
						
						
					} catch(PDOException $erro){
						echo $erro->getMessage(); 
					}
					if(isset($veio_de) && !empty($veio_de)){
					echo "	<script>
								window.location='{$veio_de}';
								</script>";
								exit;
					}else{
					echo "	<script>
								window.location='clientes.php';
								</script>";
								exit;	
					}
					
				
			}
		}
		
		function editar($redireciona='clientes.php') {
			if(isset($_POST['acao']) && $_POST['acao'] == 'editaCliente') {

				$nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
				$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);
				$telefone = filter_input(INPUT_POST, 'telefone', FILTER_SANITIZE_STRING);
				$sexo = filter_input(INPUT_POST, 'sexo', FILTER_SANITIZE_STRING);
				$senha = filter_input(INPUT_POST, 'senha', FILTER_SANITIZE_STRING);
				$id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_STRING);
				$cep = filter_input(INPUT_POST, 'cep', FILTER_SANITIZE_STRING);
				$endereco = filter_input(INPUT_POST, 'endereco', FILTER_SANITIZE_STRING);
				$id_estado = filter_input(INPUT_POST, 'id_estado', FILTER_SANITIZE_STRING);
				$id_cidade = filter_input(INPUT_POST, 'id_cidade', FILTER_SANITIZE_STRING);
				$bairro = filter_input(INPUT_POST, 'bairro', FILTER_SANITIZE_STRING);
				$numero = filter_input(INPUT_POST, 'numero', FILTER_SANITIZE_STRING);
				$complemento = filter_input(INPUT_POST, 'complemento', FILTER_SANITIZE_STRING);
				
				try { 
					$sql = "UPDATE tbl_cliente SET nome=?, email=?, telefone=?, sexo=?, senha=?, cep=?, endereco=?, id_estado=?, id_cidade=?, bairro=?, numero=?, complemento=? WHERE id=?";   
					$stm = $this->pdo->prepare($sql);   
					$stm->bindValue(1, $nome);   
					$stm->bindValue(2, $email);
					$stm->bindValue(3, $telefone);
					$stm->bindValue(4, $sexo);
					$stm->bindValue(5, $senha);
					$stm->bindValue(6, $cep);
					$stm->bindValue(7, $endereco);
					$stm->bindValue(8, $id_estado);
					$stm->bindValue(9, $id_cidade);
					$stm->bindValue(10, $bairro);
					$stm->bindValue(11, $numero);
					$stm->bindValue(12, $complemento);
					$stm->bindValue(13, $id);   
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
			if(isset($_GET['acao']) && $_GET['acao'] == 'excluirCliente') {
				
				try{   
					$sql = "DELETE FROM tbl_cliente WHERE id=? ";   
					$stm = $this->pdo->prepare($sql);   
					$stm->bindValue(1, $_GET['id']);   
					$stm->execute();
				} catch(PDOException $erro){
					echo $erro->getMessage(); 
				}

			}
		}
	}
	
	$ClientesInstanciada = 'S';
}