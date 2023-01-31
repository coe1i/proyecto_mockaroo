<?php include_once "app/views/login.php"; ?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>CRUD CLIENTES</title>
<link href="web/css/default.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="web/js/funciones.js"></script>
</head>
<body>
<div id="container" style="width: 950px;">
<div id="header">
<h1>MIS CLIENTES CRUD versión 1.1</h1>
<?php if (isset($_SESSION['usuario'])): ?>
<h2>Usuario: <?= $_SESSION['usuario'] ?></h2>
<?php endif; ?>
</div>
    
<div id="content">
<?= $contenido ?>
<!-- tengo que quitar esto -->

</div>
</div>
</body>
</html>