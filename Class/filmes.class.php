<?php
@ session_start();
$FilmesInstanciada = '';
if(empty($FilmesInstanciada)) {
	if(file_exists('Connection/conexao.php')) {
		require_once('Connection/con-pdo.php');
		require_once('funcoes.php');
	} else {
		require_once('../Connection/con-pdo.php');
		require_once('../funcoes.php');
	}
	
	class Filmes {
		
		private $pdo = null;  

		private static $Filmes = null; 

		private function __construct($conexao){  
			$this->pdo = $conexao;  
		}
	  
		public static function getInstance($conexao){   
			if (!isset(self::$Filmes)):    
				self::$Filmes = new Filmes($conexao);   
			endif;
			return self::$Filmes;    
		}
		
	
		function rsDados($id='', $orderBy='', $limite='', $url_amigavel='', $destaque='', $ativo='', $categoria='') {
			
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
		
			if(!empty($url_amigavel)) {
				$sql .= " and url_amigavel = ?"; 
				$nCampos++;
				$campo[$nCampos] = $url_amigavel;
			}

			if(!empty($destaque)) {
				$sql .= " and destaque = ?"; 
				$nCampos++;
				$campo[$nCampos] = $destaque;
			}

			if(!empty($ativo)) {
				$sql .= " and ativo = ?"; 
				$nCampos++;
				$campo[$nCampos] = $ativo;
			}
			if(!empty($categoria)) {
				$sql .= " and id_categoria = ?"; 
				$nCampos++;
				$campo[$nCampos] = $categoria;
			}
		
			if(isset($_POST['id_cat']) && !empty($_POST['id_cat'])) {
				$sql .= " and id_categoria = '{$_POST['id_cat']}'"; 
			}

			/// ORDEM		
			if(!empty($orderBy)) {
				$sqlOrdem = " order by {$orderBy}";
			}
			
			if(!empty($limite)) {
				$sqlLimite = " limit 0,{$limite}";
			}
			
			try{   
				$sql = "SELECT * FROM tbl_filmes where 1=1 $sql $sqlOrdem $sqlLimite";
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
			if(isset($_POST['acao']) && $_POST['acao'] == 'addFilme') {

				
				$titulo = filter_input(INPUT_POST, 'titulo', FILTER_SANITIZE_STRING);
				$descricao = $_POST['descricao'];
				$ativo = filter_input(INPUT_POST, 'ativo', FILTER_SANITIZE_STRING);
				$duracao = filter_input(INPUT_POST, 'duracao', FILTER_SANITIZE_STRING);
				$genero = filter_input(INPUT_POST, 'genero', FILTER_SANITIZE_STRING);
				$diretor = filter_input(INPUT_POST, 'diretor', FILTER_SANITIZE_STRING);
				$atores = filter_input(INPUT_POST, 'atores', FILTER_SANITIZE_STRING);
				$breve = filter_input(INPUT_POST, 'breve', FILTER_SANITIZE_STRING);
				$urlAmigavel = gerarTituloSEO($titulo);
				$meta_title = filter_input(INPUT_POST, 'meta_title', FILTER_SANITIZE_STRING);
				$meta_keywords = filter_input(INPUT_POST, 'meta_keywords', FILTER_SANITIZE_STRING);
				$meta_description = filter_input(INPUT_POST, 'meta_description', FILTER_SANITIZE_STRING);
				$id_classificacao_indicativa = filter_input(INPUT_POST, 'id_classificacao_indicativa', FILTER_SANITIZE_STRING);
				$id_categoria = filter_input(INPUT_POST, 'id_categoria', FILTER_SANITIZE_STRING);
					try{

						if(file_exists('Connection/conexao.php')) {
							$pastaArquivos = 'img';
						} else {
							$pastaArquivos = '../img';
						}
						
						$sql = "INSERT INTO tbl_filmes (imagem, titulo, descricao, duracao, ativo, url_amigavel, meta_title, meta_keywords, meta_description, genero, diretor, atores, breve, id_classificacao_indicativa, id_categoria) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";   
						$stm = $this->pdo->prepare($sql);   
						$stm->bindValue(1, upload('imagem', $pastaArquivos, 'N'));   
						$stm->bindValue(2, $titulo);   
						$stm->bindValue(3, $descricao);
						$stm->bindValue(4, $duracao);
						$stm->bindValue(5, $ativo);
						$stm->bindValue(6, $urlAmigavel);
						$stm->bindValue(7, $meta_title); 
						$stm->bindValue(8, $meta_keywords); 
						$stm->bindValue(9, $meta_description);
						$stm->bindValue(10, $genero);
						$stm->bindValue(11, $diretor);
						$stm->bindValue(12, $atores);
						$stm->bindValue(13, $breve);
						$stm->bindValue(14, $id_classificacao_indicativa);
						$stm->bindValue(15, $id_categoria);
						$stm->execute(); 
						$idBanner = $this->pdo->lastInsertId();
						
						if($redireciona == '') {
							$redireciona = '.';
						}
						
						
					} catch(PDOException $erro){
						echo $erro->getMessage(); 
					}
					echo "	<script>
								window.location='filmes.php';
								</script>";
								exit;
				
			}
		}
		
		function editar($redireciona='filmes.php') {
			if(isset($_POST['acao']) && $_POST['acao'] == 'editaFilme') {

				$titulo = filter_input(INPUT_POST, 'titulo', FILTER_SANITIZE_STRING);
				$descricao = $_POST['descricao'];
				$ativo = filter_input(INPUT_POST, 'ativo', FILTER_SANITIZE_STRING);
				$duracao = filter_input(INPUT_POST, 'duracao', FILTER_SANITIZE_STRING);
				$urlAmigavel = gerarTituloSEO($titulo);
				$id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_STRING);
				$meta_title = filter_input(INPUT_POST, 'meta_title', FILTER_SANITIZE_STRING);
				$meta_keywords = filter_input(INPUT_POST, 'meta_keywords', FILTER_SANITIZE_STRING);
				$meta_description = filter_input(INPUT_POST, 'meta_description', FILTER_SANITIZE_STRING);
				$genero = filter_input(INPUT_POST, 'genero', FILTER_SANITIZE_STRING);
				$diretor = filter_input(INPUT_POST, 'diretor', FILTER_SANITIZE_STRING);
				$atores = filter_input(INPUT_POST, 'atores', FILTER_SANITIZE_STRING);
				$breve = filter_input(INPUT_POST, 'breve', FILTER_SANITIZE_STRING);
				$id_classificacao_indicativa = filter_input(INPUT_POST, 'id_classificacao_indicativa', FILTER_SANITIZE_STRING);
				$id_categoria = filter_input(INPUT_POST, 'id_categoria', FILTER_SANITIZE_STRING);
				
				
				try { 

					if(file_exists('Connection/conexao.php')) {
							$pastaArquivos = 'img';
						} else {
							$pastaArquivos = '../img';
						}
				
					$sql = "UPDATE tbl_filmes SET imagem=?, titulo=?, descricao=?, duracao=?, ativo=?, url_amigavel=?, meta_title=?, meta_keywords=?, meta_description=?, genero=?, diretor=?, atores=?, breve=?, id_classificacao_indicativa=?, id_categoria=? WHERE id=?";   
					$stm = $this->pdo->prepare($sql);   
					$stm->bindValue(1, upload('imagem', $pastaArquivos, 'N'));   
					$stm->bindValue(2, $titulo);   
					$stm->bindValue(3, $descricao);
					$stm->bindValue(4, $duracao);
					$stm->bindValue(5, $ativo);
					$stm->bindValue(6, $urlAmigavel);
					$stm->bindValue(7, $meta_title); 
					$stm->bindValue(8, $meta_keywords); 
					$stm->bindValue(9, $meta_description);
					$stm->bindValue(10, $genero);
					$stm->bindValue(11, $diretor);
					$stm->bindValue(12, $atores);
					$stm->bindValue(13, $breve); 
					$stm->bindValue(14, $id_classificacao_indicativa);  
					$stm->bindValue(15, $id_categoria);
					$stm->bindValue(16, $id);   
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
			if(isset($_GET['acao']) && $_GET['acao'] == 'excluirFilme') {
				
				try{   
					$sql = "DELETE FROM tbl_filmes WHERE id=? ";   
					$stm = $this->pdo->prepare($sql);   
					$stm->bindValue(1, $_GET['id']);   
					$stm->execute();
				} catch(PDOException $erro){
					echo $erro->getMessage(); 
				}
				echo "	<script>
								window.location='filmes.php';
								</script>";
								exit;

			}
		}

		function rsDadosProgramacao($id='', $orderBy='', $limite='', $id_filme='', $data_programacao='', $group='', $hora_programacao='', $id_cidade='') {
			
			/// FILTROS
			$nCampos = 0;
			$sql = '';
			$sqlOrdem = ''; 
			$sqlLimite = '';
			$sqlGroup = '';
			if(!empty($id)) {
				$sql .= " and id = ?"; 
				$nCampos++;
				$campo[$nCampos] = $id;
			}
			if(!empty($id_filme)) {
				$sql .= " and id_filme = ?"; 
				$nCampos++;
				$campo[$nCampos] = $id_filme;
			}

			if(!empty($data_programacao)) {
				$sql .= " and data_exibicao = ?"; 
				$nCampos++;
				$campo[$nCampos] = $data_programacao;
			}

			if(!empty($hora_programacao)) {
				$sql .= " and hora_exibicao = ?"; 
				$nCampos++;
				$campo[$nCampos] = $hora_programacao;
			}

			if(!empty($id_cidade)) {
				$sql .= " and id_cidade = ?"; 
				$nCampos++;
				$campo[$nCampos] = $id_cidade;
			}
		
			/// ORDEM		
			if(!empty($orderBy)) {
				$sqlOrdem = " order by {$orderBy}";
			}
			
			if(!empty($limite)) {
				$sqlLimite = " limit 0,{$limite}";
			}

			if(!empty($group)) {
				$sqlGroup = " GROUP BY {$group}";
			}
			
			try{   
				$sql = "SELECT * FROM tbl_programacao_filmes where 1=1 $sql $sqlOrdem $sqlLimite $sqlGroup";
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

		function addProgramacao() {
			if(isset($_POST['acao']) && $_POST['acao'] == 'addProgramacao') {

				 $id_filme = filter_input(INPUT_POST, 'id_filme', FILTER_SANITIZE_STRING);
				for($i=0;$i <count($_POST['data_exibicao']); $i++){
					try{

						$sql = "INSERT INTO tbl_programacao_filmes (id_filme, data_exibicao, hora_exibicao, id_sala, valor, id_cidade) VALUES (?, ?, ?, ?, ?, ?)";   
						$stm = $this->pdo->prepare($sql);   
						$stm->bindValue(1, $id_filme);   
						$stm->bindValue(2, $_POST['data_exibicao'][$i]);
						$stm->bindValue(3, $_POST['hora_exibicao'][$i]);
						$stm->bindValue(4, $_POST['id_sala'][$i]);
						$stm->bindValue(5, $_POST['valor'][$i]);
						$stm->bindValue(6, $_POST['id_cidade'][$i]);
						$stm->execute(); 
						$idBanner = $this->pdo->lastInsertId();
						
					} catch(PDOException $erro){
						echo $erro->getMessage(); 
					}
				}
					echo "	<script>
								window.location='editar-filme.php?id={$id_filme}&aba=prog';
								</script>";
								exit;
				
			}
		}

		function editarProgramacao() {
			if(isset($_POST['acao']) && $_POST['acao'] == 'editaProgramacao') {

				$id_filme = filter_input(INPUT_POST, 'id_filme', FILTER_SANITIZE_STRING);
				$data_exibicao = filter_input(INPUT_POST, 'data_exibicao', FILTER_SANITIZE_STRING);
				$hora_exibicao = filter_input(INPUT_POST, 'hora_exibicao', FILTER_SANITIZE_STRING);
				$id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_STRING);
				$id_sala = filter_input(INPUT_POST, 'id_sala', FILTER_SANITIZE_STRING);
				$valor = filter_input(INPUT_POST, 'valor', FILTER_SANITIZE_STRING);
				$id_cidade = filter_input(INPUT_POST, 'id_cidade', FILTER_SANITIZE_STRING);
				//var_dump($_POST);exit;
				try { 

					$sql = "UPDATE tbl_programacao_filmes SET id_filme=?, data_exibicao=?, hora_exibicao=?, id_sala=?, valor=?, id_cidade=? WHERE id=?";   
					$stm = $this->pdo->prepare($sql);   
					$stm->bindValue(1, $id_filme);   
					$stm->bindValue(2, $data_exibicao);
					$stm->bindValue(3, $hora_exibicao);
					$stm->bindValue(4, $id_sala);
					$stm->bindValue(5, valorCalculavel($valor));
					$stm->bindValue(6, $id_cidade);
					$stm->bindValue(7, $id);   
					$stm->execute(); 
				} catch(PDOException $erro){
					echo $erro->getMessage(); 
				}
				echo "	<script>
						window.location='editar-filme.php?id={$id_filme}&aba=prog';
						</script>";
						exit;
			}
		}

		function excluirProgramacao() {
			if(isset($_GET['acao']) && $_GET['acao'] == 'excluirProgramacao') {
				
				try{   
					$sql = "DELETE FROM tbl_programacao_filmes WHERE id=? ";   
					$stm = $this->pdo->prepare($sql);   
					$stm->bindValue(1, $_GET['id_programacao']);   
					$stm->execute();
				} catch(PDOException $erro){
					echo $erro->getMessage(); 
				}
				echo "	<script>
								window.location='editar-filme.php?id={$_GET['id']}&aba=prog';
								</script>";
								exit;

			}
		}

		function rsDadosSalas($id='', $orderBy='', $limite='') {
			
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
				$sql = "SELECT * FROM tbl_sala where 1=1 $sql $sqlOrdem $sqlLimite";
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

		function rsDadosClassificacao($id='', $orderBy='', $limite='') {
			
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
				$sql = "SELECT * FROM tbl_classe_indicativa where 1=1 $sql $sqlOrdem $sqlLimite";
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
	}
	
	
	$FilmesInstanciada = 'S';
}