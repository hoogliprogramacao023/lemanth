<?php
$CidadesInstanciada = '';
if(isset($CidadesInstanciada)) {
	if(file_exists('Connection/conexao.php')) {
		require_once('Connection/con-pdo.php');
		require_once('funcoes.php');
	} else {
		require_once('../Connection/con-pdo.php');
		require_once('../funcoes.php');
	}
	
	class Cidades {
		/*  
		* Atributo para conex�o com o banco de dados   
		*/  
		private $pdo = null;  
	
		/*  
		* Atributo est�tico para inst�ncia da pr�pria classe    
		*/  
		private static $Cidades = null; 
	
		/*  
		* Construtor da classe como private  
		* @param $conexao - Conex�o com o banco de dados  
		*/  
		private function __construct($conexao){  
			$this->pdo = $conexao;  
		}
	  
		/*
		* M�todo est�tico para retornar um objeto crudBlog    
		* Verifica se j� existe uma inst�ncia desse objeto, caso n�o, inst�ncia um novo    
		* @param $conexao - Conex�o com o banco de dados   
		* @return $AtualizaProcessos - Instancia do objeto AtualizaProcessos    
		*/   
		
		public static function getInstance($conexao){   
			if (!isset(self::$Cidades)):    
				self::$Cidades = new Cidades($conexao);   
			endif;
			return self::$Cidades;    
		}
		
		function rsDados($uf, $id_estado='', $id_cidade='') {
			
			$nCampos = 0;
			$sql='';
			
			if($uf <> '') {
				$sql .= " and uf = ?"; 
				$nCampos++;
				$campo[$nCampos] = $uf;
			}
			
			if($id_cidade <> '') {
				$sql .= " and id = ?"; 
				$nCampos++;
				$campo[$nCampos] = $id_cidade;
			}
			if($id_estado <> '') {
				$sql .= " and id_estado = ?"; 
				$nCampos++;
				$campo[$nCampos] = $id_estado;
			}
			//echo $sql; exit;
			
			try{   
				$sql = "SELECT * FROM dados_cidades where 1=1 $sql";
				$stm = $this->pdo->prepare($sql);
				
				for($i=1; $i<=$nCampos; $i++) {
					$stm->bindValue($i, $campo[$i]);
				}
				
				$stm->execute();   
				$rsDados = $stm->fetchAll(PDO::FETCH_OBJ);
				return($rsDados);
			} catch(PDOException $erro){   
				echo $erro->getLine(); 
			}
		}

		function rsDadosCidades($id_cidade='') {
			
			$nCampos = 0;
			$sql='';
			
			if($id_cidade <> '') {
				$sql .= " and id = ?"; 
				$nCampos++;
				$campo[$nCampos] = $id_cidade;
			}
			
			try{   
				$sql = "SELECT * FROM tbl_cidades where 1=1 $sql";
				$stm = $this->pdo->prepare($sql);
				
				for($i=1; $i<=$nCampos; $i++) {
					$stm->bindValue($i, $campo[$i]);
				}
				
				$stm->execute();   
				$rsDados = $stm->fetchAll(PDO::FETCH_OBJ);
				return($rsDados);
			} catch(PDOException $erro){   
				echo $erro->getLine(); 
			}
		}

		function add($redireciona='') {
			if(isset($_POST['acao']) && $_POST['acao'] == 'addCidade') {

				
				$nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
				$estado = filter_input(INPUT_POST, 'estado', FILTER_SANITIZE_STRING);
					try{

						$sql = "INSERT INTO tbl_cidades (nome, estado) VALUES (?, ?)";   
						$stm = $this->pdo->prepare($sql);   
						$stm->bindValue(1, $nome);
						$stm->bindValue(2, $estado);
						$stm->execute(); 
						$idBanner = $this->pdo->lastInsertId();
						
						if($redireciona == '') {
							$redireciona = '.';
						}
						
						
					} catch(PDOException $erro){
						echo $erro->getMessage(); 
					}
					echo "	<script>
								window.location='cidade.php';
								</script>";
								exit;
				
			}
		}
		
		function editar($redireciona='cidade.php') {
			if(isset($_POST['acao']) && $_POST['acao'] == 'editaCidade') {

				$nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING);
				$estado = filter_input(INPUT_POST, 'estado', FILTER_SANITIZE_STRING);
				$id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_STRING);
				
				try { 

					if(file_exists('Connection/conexao.php')) {
							$pastaArquivos = 'img';
						} else {
							$pastaArquivos = '../img';
						}
				
					$sql = "UPDATE tbl_cidades SET nome=?, estado=? WHERE id=?";   
					$stm = $this->pdo->prepare($sql);   
					$stm->bindValue(1, $nome); 
					$stm->bindValue(2, $estado);  
					$stm->bindValue(3, $id);   
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
			if(isset($_GET['acao']) && $_GET['acao'] == 'excluirCidade') {
				
				try{   
					$sql = "DELETE FROM tbl_cidades WHERE id=? ";   
					$stm = $this->pdo->prepare($sql);   
					$stm->bindValue(1, $_GET['id']);   
					$stm->execute();
				} catch(PDOException $erro){
					echo $erro->getMessage(); 
				}
				echo "	<script>
								window.location='cidade.php';
								</script>";
								exit;

			}
		}

		
		function selectCidades($uf="", $id_estado="", $nomeCampo='id_cidade', $selecionado='', $campoLabel='nome', $style="", $class='form-control', $desc_primeira_opcao='', $disabled='') {
			$cidades = $this->rsDados($uf, $id_estado);
			?>
			<select name="<?php echo $nomeCampo;?>" id="<?php echo $nomeCampo;?>" class="<?php echo $class;?>" style=" <?php echo $style;?>" <?php if($disabled == 'S') { echo "disabled"; } ?>>
				<option value=""><?php echo $desc_primeira_opcao;?></option>
					<?php 
					foreach($cidades as $cidade) {
					?>
						<option value="<?php echo $cidade->id?>" <?php if(isset($selecionado) && $cidade->id == $selecionado) { echo "selected";} ?>><?php echo $cidade->$campoLabel;?></option>
					<?php 
					}
					?>
			</select>
        <?php
		}


	}
	
	$CidadesInstanciada = 'S';
}
?>