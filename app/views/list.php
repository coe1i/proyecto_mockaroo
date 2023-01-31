<?php 
//if ($_SESSION['rol']==1){ ?>
<form>
<button type="submit" name="orden" value="Nuevo"> Cliente Nuevo </button><br>
</form>
<?php 
// } ?>
<br>
<form method="GET">
            <button type="submit" name="ordenar" value="id">id</button></th>
            <button type="submit" name="ordenar" value="name">nombre</button></th>
            <button type="submit" name="ordenar" value="email">email</button>
             <button type="submit" name="ordenar" value="gender">gender</button>
           <button type="submit" name="ordenar" value="ip">ip</button></th>
    
        </form>
<br>

<table>
<tr><th>id</th><th>first_name</th><th>email</th>
<th>gender</th><th>ip_address</th><th>teléfono</th></tr>
<?php foreach ($tvalores as $valor): ?>
<tr>
<td><?= $valor->id ?> </td>
<td><?= $valor->first_name ?> </td>
<td><?= $valor->email ?> </td>
<td><?= $valor->gender ?> </td>
<td><?= $valor->ip_address ?> </td>
<td><?= $valor->telefono ?> </td>
<?php 
if ($_SESSION['usuario'] == 'admin'){
?>
<td><a href="#" onclick="confirmarBorrar('<?=$valor->first_name?>',<?=$valor->id?>);" >Borrar</a></td>
<td><a href="?orden=Modificar&id=<?=$valor->id?>">Modificar</a></td>
<?php } ?>
<td><a href="?orden=Detalles&id=<?=$valor->id?>" >Detalles</a></td>

<tr>
<?php endforeach ?>
</table>

<form>
<br>
<button type="submit" name="nav" value="Primero"> << </button>
<button type="submit" name="nav" value="Anterior"> < </button>
<button type="submit" name="nav" value="Siguiente"> > </button>
<button type="submit" name="nav" value="Ultimo"> >> </button>
</form>