<?php
@ session_start();
$TextosInstanciada = '';
if(empty($TextosInstanciada)) {
	if(file_exists('Connection/conexao.php')) {
		require_once('Connection/con-pdo.php');
		require_once('funcoes.php');
	} else {
		require_once('../Connection/con-pdo.php');
		require_once('../funcoes.php');
	}
	
	class Textos {
		
		private $pdo = null;  

		private static $Textos = null; 

		private function __construct($conexao){  
			$this->pdo = $conexao;  
		}
	  
		public static function getInstance($conexao){   
			if (!isset(self::$Textos)):    
				self::$Textos = new Textos($conexao);   
			endif;
			return self::$Textos;    
		}
		
	
		function rsDados($id='', $orderBy='', $limite='', $pagina_individual='') {
			
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
			if(!empty($pagina_individual)) {
				$sql .= " and pagina_individual = ?"; 
				$nCampos++;
				$campo[$nCampos] = $pagina_individual;
			}

			/// ORDEM		
			if(!empty($orderBy)) {
				$sqlOrdem = " order by {$orderBy}";
			}
			
			if(!empty($limite)) {
				$sqlLimite = " limit 0,{$limite}";
			}
			
			try{   
				$sql = "SELECT * FROM tbl_textos where 1=1 $sql $sqlOrdem $sqlLimite";
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
		
		function editar($redireciona='textos.php') {
			if(isset($_POST['acao']) && $_POST['acao'] == 'editaTexto') {
				$titulo = filter_input(INPUT_POST, 'titulo', FILTER_SANITIZE_STRING);
				$titulo2 = filter_input(INPUT_POST, 'titulo2', FILTER_SANITIZE_STRING);
				$titulo3 = filter_input(INPUT_POST, 'titulo3', FILTER_SANITIZE_STRING);
				$titulo4 = filter_input(INPUT_POST, 'titulo4', FILTER_SANITIZE_STRING);
				$titulo5 = filter_input(INPUT_POST, 'titulo5', FILTER_SANITIZE_STRING);
				$titulo6 = filter_input(INPUT_POST, 'titulo6', FILTER_SANITIZE_STRING);
				$titulo7 = filter_input(INPUT_POST, 'titulo7', FILTER_SANITIZE_STRING);
				$titulo8 = filter_input(INPUT_POST, 'titulo8', FILTER_SANITIZE_STRING);
				$descricao = filter_input(INPUT_POST, 'descricao', FILTER_SANITIZE_STRING);
				//$texto = htmlentities(filter_input(INPUT_POST, 'texto', FILTER_SANITIZE_STRING));
				if(isset($_POST['texto']) && !empty($_POST['texto'])){
					$texto = $_POST['texto'];
				}else{
					$texto = '';	
				}
				if(isset($_POST['texto_2']) && !empty($_POST['texto_2'])){
					$texto_2 = $_POST['texto_2'];
				}else{
					$texto_2 = '';	
				}
				if(isset($_POST['texto_3']) && !empty($_POST['texto_3'])){
					$texto_3 = $_POST['texto_3'];
				}else{
					$texto_3 = '';	
				}
				if(isset($_POST['texto_4']) && !empty($_POST['texto_4'])){
					$texto_4 = $_POST['texto_4'];
				}else{
					$texto_4 = '';	
				}
				if(isset($_POST['texto_5']) && !empty($_POST['texto_5'])){
					$texto_5 = $_POST['texto_5'];
				}else{
					$texto_5 = '';	
				}
				if(isset($_POST['texto_6']) && !empty($_POST['texto_6'])){
					$texto_6 = $_POST['texto_6'];
				}else{
					$texto_6 = '';	
				}
				if(isset($_POST['texto_7']) && !empty($_POST['texto_7'])){
					$texto_7 = $_POST['texto_7'];
				}else{
					$texto_7 = '';	
				}
				if(isset($_POST['texto_8']) && !empty($_POST['texto_8'])){
					$texto_8 = $_POST['texto_8'];
				}else{
					$texto_8 = '';	
				}
				
				$meta_title = filter_input(INPUT_POST, 'meta_title', FILTER_SANITIZE_STRING);
				$meta_keywords = filter_input(INPUT_POST, 'meta_keywords', FILTER_SANITIZE_STRING);
				$meta_description = filter_input(INPUT_POST, 'meta_description', FILTER_SANITIZE_STRING);
				$id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_STRING);
				$embed = filter_input(INPUT_POST, 'embed', FILTER_SANITIZE_STRING);
				$pagina_individual = filter_input(INPUT_POST, 'pagina_individual', FILTER_SANITIZE_STRING);
				try { 
					if(file_exists('Connection/conexao.php')) {
							$pastaArquivos = 'img';
						} else {
							$pastaArquivos = '../img';
						}
					$sql = "UPDATE tbl_textos SET foto=?, foto_2=?, foto_3=?, foto_4=?, foto_5=?, foto_6=?, foto_7=?, foto_8=?, titulo=?, titulo2=?, titulo3=?, titulo4=?, titulo5=?, titulo6=?, titulo7=?, titulo8=?, descricao=?, texto=?, texto_2=?, texto_3=?, texto_4=?, texto_5=?, texto_6=?, texto_7=?, texto_8=?, meta_title=?, meta_keywords=?, meta_description=?, embed=? WHERE id=?";   
					$stm = $this->pdo->prepare($sql);   
					$stm->bindValue(1, upload('foto', $pastaArquivos, 'N'));
					$stm->bindValue(2, upload('foto_2', $pastaArquivos, 'N'));
					$stm->bindValue(3, upload('foto_3', $pastaArquivos, 'N'));
					$stm->bindValue(4, upload('foto_4', $pastaArquivos, 'N'));
					$stm->bindValue(5, upload('foto_5', $pastaArquivos, 'N'));
					$stm->bindValue(6, upload('foto_6', $pastaArquivos, 'N'));
					$stm->bindValue(7, upload('foto_7', $pastaArquivos, 'N'));
					$stm->bindValue(8, upload('foto_8', $pastaArquivos, 'N'));   
					$stm->bindValue(9, $titulo);
					$stm->bindValue(10, $titulo2);
					$stm->bindValue(11, $titulo3);
					$stm->bindValue(12, $titulo4);
					$stm->bindValue(13, $titulo5);
					$stm->bindValue(14, $titulo6);
					$stm->bindValue(15, $titulo7);
					$stm->bindValue(16, $titulo8);   
					$stm->bindValue(17, $descricao);
					$stm->bindValue(18, $texto);
					$stm->bindValue(19, $texto_2);
					$stm->bindValue(20, $texto_3);
					$stm->bindValue(21, $texto_4);
					$stm->bindValue(22, $texto_5);
					$stm->bindValue(23, $texto_6);
					$stm->bindValue(24, $texto_7);
					$stm->bindValue(25, $texto_8);
					$stm->bindValue(26, $meta_title);
					$stm->bindValue(27, $meta_keywords);
					$stm->bindValue(28, $meta_description);
					$stm->bindValue(29, $embed); 
					$stm->bindValue(30, $id);   
					$stm->execute(); 
				} catch(PDOException $erro){
					echo $erro->getMessage(); 
				}
				if($pagina_individual == 'S'){
					echo "	<script>
							alert('Modificado com sucesso!');
							window.location='editar-texto.php?pi=S&id=$id';
						</script>";
						exit;
				}else{
				echo "	<script>
							window.location='{$redireciona}';
						</script>";
						exit;
				}
			}
		}
		
		function excluir() {
			if(isset($_GET['acao']) && $_GET['acao'] == 'excluirTexto') {
				
				try{   
					$sql = "DELETE FROM tbl_textos WHERE id=? ";   
					$stm = $this->pdo->prepare($sql);   
					$stm->bindValue(1, $_GET['id']);   
					$stm->execute();
				} catch(PDOException $erro){
					echo $erro->getMessage(); 
				}

			}
		}
	}
	
	$TextosInstanciada = 'S';
}