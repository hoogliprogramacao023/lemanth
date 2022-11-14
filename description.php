<meta name="theme-color" content="#9980bb">
<?php if(basename($_SERVER['SCRIPT_NAME']) == 'index.php'){?>
<link rel=”canonical” href="<?php echo SITE_URL;?>" />
        <title><?php if(isset($metastags->meta_title_principal) && !empty($metastags->meta_title_principal)){echo $metastags->meta_title_principal;}?></title>
        <meta name="description" content="<?php if(isset($metastags->meta_description_principal) && !empty($metastags->meta_description_principal)){echo $metastags->meta_description_principal;}?>"/>
	    <meta name="keywords" content="<?php if(isset($metastags->meta_keywords_principal) && !empty($metastags->meta_keywords_principal)){echo $metastags->meta_keywords_principal;}?>">
	    <meta name="twitter:card" content="<?php if(isset($metastags->meta_title_principal) && !empty($metastags->meta_title_principal)){echo $metastags->meta_title_principal;}?>" />
		<meta name="twitter:site" content="<?php echo SITE_URL;?>" />
		<meta name="twitter:creator" content="Hoogli" />
		<meta property="og:title" content="<?php if(isset($metastags->meta_title_principal) && !empty($metastags->meta_title_principal)){echo $metastags->meta_title_principal;}?>" />
		<meta property="og:type" content="website" />
		<meta property="og:url" content="<?php echo SITE_URL;?>" />
		<meta property="og:image:type" content="image/png" />
		<meta property="og:image" content="<?php echo SITE_URL;?>/img/<?php echo $infoSistema->logo_principal;?>" />
		<meta property="og:image:width" content="400" />
		<meta property="og:image:height" content="300" />
<?php }?>

<?php if(basename($_SERVER['SCRIPT_NAME']) == 'contato.php'){?>
<link rel=”canonical” href="<?php echo SITE_URL;?>/contato" />
        <title><?php if(isset($metastags->meta_title_contato) && !empty($metastags->meta_title_contato)){echo $metastags->meta_title_contato;}?></title>
        <meta name="description" content="<?php if(isset($metastags->meta_description_contato) && !empty($metastags->meta_description_contato)){echo $metastags->meta_description_principal;}?>"/>
	    <meta name="keywords" content="<?php if(isset($metastags->meta_keywords_contato) && !empty($metastags->meta_keywords_contato)){echo $metastags->meta_keywords_contato;}?>">
	    <meta name="twitter:card" content="<?php if(isset($metastags->meta_title_contato) && !empty($metastags->meta_title_contato)){echo $metastags->meta_title_contato;}?>" />
		<meta name="twitter:site" content="<?php echo SITE_URL;?>" />
		<meta name="twitter:creator" content="Hoogli" />
		<meta property="og:title" content="<?php if(isset($metastags->meta_title_contato) && !empty($metastags->meta_title_contato)){echo $metastags->meta_title_contato;}?>" />
		<meta property="og:type" content="website" />
		<meta property="og:url" content="<?php echo SITE_URL;?>" />
		<meta property="og:image:type" content="image/png" />
		<meta property="og:image" content="<?php echo SITE_URL;?>/img/<?php echo $infoSistema->logo_principal;?>" />
		<meta property="og:image:width" content="400" />
		<meta property="og:image:height" content="300" />
<?php }?>
<?php if(basename($_SERVER['SCRIPT_NAME']) == 'sobre.php'){?>
<link rel=”canonical” href="<?php echo SITE_URL;?>/sobre" />
        <title><?php if(isset($metastags->meta_title_sobre) && !empty($metastags->meta_title_sobre)){echo $metastags->meta_title_sobre;}?></title>
        <meta name="description" content="<?php if(isset($metastags->meta_description_sobre) && !empty($metastags->meta_description_sobre)){echo $metastags->meta_description_sobre;}?>"/>
	    <meta name="keywords" content="<?php if(isset($metastags->meta_keywords_sobre) && !empty($metastags->meta_keywords_sobre)){echo $metastags->meta_keywords_sobre;}?>">
	    <meta name="twitter:card" content="<?php if(isset($metastags->meta_title_sobre) && !empty($metastags->meta_title_sobre)){echo $metastags->meta_title_sobre;}?>" />
		<meta name="twitter:site" content="<?php echo SITE_URL;?>" />
		<meta name="twitter:creator" content="Hoogli" />
		<meta property="og:title" content="<?php if(isset($metastags->meta_title_sobre) && !empty($metastags->meta_title_sobre)){echo $metastags->meta_title_sobre;}?>" />
		<meta property="og:type" content="website" />
		<meta property="og:url" content="<?php echo SITE_URL;?>" />
		<meta property="og:image:type" content="image/png" />
		<meta property="og:image" content="<?php echo SITE_URL;?>/img/<?php echo $infoSistema->logo_principal;?>" />
		<meta property="og:image:width" content="400" />
		<meta property="og:image:height" content="300" />
<?php }?>
<?php if(basename($_SERVER['SCRIPT_NAME']) == 'produtos.php'){?>
        <title><?php if(isset($metastags->meta_title_produtos) && !empty($metastags->meta_title_produtos)){echo $metastags->meta_title_produtos;}?></title>
        <meta name="description" content="<?php if(isset($metastags->meta_description_produtos) && !empty($metastags->meta_description_produtos)){echo $metastags->meta_description_produtos;}?>"/>
	    <meta name="keywords" content="<?php if(isset($metastags->meta_keywords_produtos) && !empty($metastags->meta_keywords_produtos)){echo $metastags->meta_keywords_produtos;}?>">
	    <meta name="twitter:card" content="<?php if(isset($metastags->meta_title_produtos) && !empty($metastags->meta_title_produtos)){echo $metastags->meta_title_produtos;}?>" />
		<meta name="twitter:site" content="<?php echo SITE_URL;?>" />
		<meta name="twitter:creator" content="Hoogli" />
		<meta property="og:title" content="<?php if(isset($metastags->meta_title_produtos) && !empty($metastags->meta_title_produtos)){echo $metastags->meta_title_produtos;}?>" />
		<meta property="og:type" content="website" />
		<meta property="og:url" content="<?php echo SITE_URL;?>" />
		<meta property="og:image:type" content="image/png" />
		<meta property="og:image" content="<?php echo SITE_URL;?>/img/<?php echo $infoSistema->logo_principal;?>" />
		<meta property="og:image:width" content="400" />
		<meta property="og:image:height" content="300" />
<?php }?>
<?php if(basename($_SERVER['SCRIPT_NAME']) == 'blog.php'){?>
<link rel=”canonical” href="<?php echo SITE_URL;?>/blog" />
        <title><?php if(isset($metastags->meta_title_blog) && !empty($metastags->meta_title_blog)){echo $metastags->meta_title_blog;}?></title>
        <meta name="description" content="<?php if(isset($metastags->meta_description_blog) && !empty($metastags->meta_description_blog)){echo $metastags->meta_description_blog;}?>"/>
	    <meta name="keywords" content="<?php if(isset($metastags->meta_keywords_blog) && !empty($metastags->meta_keywords_blog)){echo $metastags->meta_keywords_blog;}?>">
	    <meta name="twitter:card" content="<?php if(isset($metastags->meta_title_blog) && !empty($metastags->meta_title_blog)){echo $metastags->meta_title_blog;}?>" />
		<meta name="twitter:site" content="<?php echo SITE_URL;?>" />
		<meta name="twitter:creator" content="Hoogli" />
		<meta property="og:title" content="<?php if(isset($metastags->meta_title_blog) && !empty($metastags->meta_title_blog)){echo $metastags->meta_title_blog;}?>" />
		<meta property="og:type" content="website" />
		<meta property="og:url" content="<?php echo SITE_URL;?>" />
		<meta property="og:image:type" content="image/png" />
		<meta property="og:image" content="<?php echo SITE_URL;?>/img/<?php echo $infoSistema->logo_principal;?>" />
		<meta property="og:image:width" content="400" />
		<meta property="og:image:height" content="300" />
<?php }?>
<?php if(basename($_SERVER['SCRIPT_NAME']) == 'desc-blog.php'){?>
<link rel=”canonical” href="<?php echo SITE_URL;?>/blog/<?php echo $id;?>" />
        <title><?php if(isset($descBlog[0]->meta_title) && !empty($descBlog[0]->meta_title)){echo $descBlog[0]->meta_title;}?></title>
        <meta name="description" content="<?php if(isset($descBlog[0]->meta_description) && !empty($descBlog[0]->meta_description)){echo $descBlog[0]->meta_description;}?>"/>
	    <meta name="keywords" content="<?php if(isset($descBlog[0]->meta_keywords) && !empty($descBlog[0]->meta_keywords)){echo $descBlog[0]->meta_keywords;}?>">
	    <meta name="twitter:card" content="<?php if(isset($descBlog[0]->meta_title) && !empty($descBlog[0]->meta_title)){echo $descBlog[0]->meta_title;}?>" />
		<meta name="twitter:site" content="<?php echo SITE_URL;?>" />
		<meta name="twitter:creator" content="Hoogli" />
		<meta property="og:title" content="<?php if(isset($descBlog[0]->meta_title) && !empty($descBlog[0]->meta_title)){echo $descBlog[0]->meta_title;}?>" />
		<meta property="og:type" content="website" />
		<meta property="og:url" content="<?php echo SITE_URL;?>" />
		<meta property="og:image:type" content="image/png" />
		<meta property="og:image" content="<?php echo SITE_URL;?>/img/<?php echo $infoSistema->logo_principal;?>" />
		<meta property="og:image:width" content="400" />
		<meta property="og:image:height" content="300" />
<?php }?>
<?php if(basename($_SERVER['SCRIPT_NAME']) == 'desc-servico.php'){?>
        <link rel="canonical" href="<?php echo SITE_URL;?>/servico/<?php echo $id;?>" />
        <title><?php if(isset($descServico[0]->meta_title) && !empty($descServico[0]->meta_title)){echo $descServico[0]->meta_title;}?></title>
        <meta name="description" content="<?php if(isset($descServico[0]->meta_description) && !empty($descServico[0]->meta_description)){echo $descServico[0]->meta_description;}?>"/>
		<meta name="keywords" content="<?php if(isset($descServico[0]->meta_keywords) && !empty($descServico[0]->meta_keywords)){echo $descServico[0]->meta_keywords;}?>">	
	    <meta name="twitter:card" content="<?php if(isset($descServico[0]->meta_title) && !empty($descServico[0]->meta_title)){echo $descServico[0]->meta_title;}?> - <?php echo $descServico[0]->titulo;?>" />
		<meta name="twitter:site" content="<?php echo SITE_URL;?>" />
		<meta name="twitter:creator" content="Hoogli" />
		<meta property="og:title" content="<?php if(isset($descServico[0]->meta_title) && !empty($descServico[0]->meta_title)){echo $descServico[0]->meta_title;}?> - <?php echo $descServico[0]->titulo;?>" />
		<meta property="og:description" content="<?php if(isset($descServico[0]->meta_description) && !empty($descServico[0]->meta_description)){echo $descServico[0]->meta_description;}?>" />
		<meta property="og:type" content="website" />
		<meta property="og:url" content="<?php echo SITE_URL;?>" />
		<meta property="og:image:type" content="image/png" />
		<meta property="og:image" content="<?php echo SITE_URL;?>/img/<?php echo $descServico[0]->foto;?>" />
		<meta property="og:image:width" content="400" />
		<meta property="og:image:height" content="300" />
<?php }?>



<meta name="author" content="Adriano Monteiro">
<link rel="shortcut icon" href="<?php echo SITE_URL;?>/img/<?php echo $infoSistema->favicon;?>">
<link rel="icon" href="<?php echo SITE_URL;?>/img/<?php echo $infoSistema->favicon;?>">