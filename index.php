<?php
include('conexion.php');
$listPer=$conexion->query("SELECT * FROM personajes ORDER BY id_personaje");

if(isset($_POST['insertar']))
{
	$nombre=$_POST['nombre'];
	$cargarAvatar=($_FILES['avatar']['tmp_name']);
	$avatar=fopen($cargarAvatar, 'rb');
	$cargarPoder=($_FILES['poder']['tmp_name']);
	$poder=fopen($cargarPoder, 'rb');
	$pais=$_POST['pais'];

	$insertarPJ=$conexion->prepare("INSERT INTO personajes(nombre, avatar, poder, pais) VALUES(:nombre, :avatar, :poder, :pais)");
	$insertarPJ->bindParam(':nombre', $nombre, PDO::PARAM_STR);
	$insertarPJ->bindParam(':avatar', $avatar, PDO::PARAM_LOB);
	$insertarPJ->bindParam(':poder', $poder, PDO::PARAM_LOB);
	$insertarPJ->bindParam(':pais', $pais, PDO::PARAM_STR);
	$insertarPJ->execute();

	if($insertarPJ)
	{
		
		$mensaje="<div class='col-md-offset-4 col-md-4 alert alert-success text-center'>
		<a href='index.php'>Upload</a></div>";
	}

	else
	{
		$mensaje="<div class='col-md-offset-4 col-md-4 alert alert-danger text-center'>
		We couldn't upload it.</div>";
	}
}
?>

<html lang="ja">
	<head> 
		<title>Sound Strage!!</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
		<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" href="css/estilos.css">
	</head>
	<body>

		<header>
			<div class="alert alert-info">
			<h3>Sound Strage!!</h3>
			</div>
		</header>

		
		<section>
		<?=$mensaje?>
			<table class="table">
				<tr class="bg-primary">
				<th>ID</th>
				<th>Image</th>
				<th>Text</th>
				<th>Audio</th>
				<th>Category</th>
				</tr>
				<?php
					while ($perFila=$listPer->fetch(PDO::FETCH_ASSOC))
					{
					echo '<tr>
							<td>'.$perFila['id_personaje'].'</td>
							<td><img src="data:image/png;base64, '.base64_encode($perFila['avatar']).' "width="120" height="120"></td>
							<td>'.$perFila['nombre'].'</td>
							<td><audio controls><source src="data:audio/mp3;base64,'.base64_encode($perFila['poder']).'"></audio controls></td>
							<td>'.$perFila['pais'].'</td>
						 </tr>';
					}
				?>
			</table>
			<form method="POST" enctype="multipart/form-data">
				<table class="table">
				<tr class="bg-primary">
				<th>Image</th>
				<th>Text</th>
				<th>Audio</th>
				<th>Category</th>
				<th></th>
				</tr>
				<tr class="bg-info">
				<td><input name="avatar" type="file" class="form-control"></td>
				<td><input name="nombre" type="text" class="form-control" placeholder="Text"></td>
				<td><input name="poder" type="file" class="form-control"></td>
				<td><input name="pais" type="text" class="form-control" placeholder="Category"></td>
				<td><input name="insertar" type="submit" class="btn btn-success" value="Submit" > </td>
				</tr>
				</table>
				<br>
				<br>
				
			</form>
		</section>
</body>
</html>
