<?php
// $conn = new \PDO('mysql:host=db;dbname=application', 'root', 'rootpass');
require './vendor/autoload.php';

use Application\DBConnection\MySQLConnection;

$conn = new MySQLConnection();

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $comando = $conn->prepare('INSERT INTO produtos(nome, quantidade) VALUES(:n, :q)');
    $comando->execute([':n' => $_POST['nome'], ':q' => $_POST['quantidade']]);
}

$select = $conn->prepare('SELECT * FROM produtos');
$select->execute();

$lista = $select->fetchAll(\PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html lang="pt_br">
    <head>
        <meta charset="UTF-8">
        <title>Novo Produto</title>
    </head>
    <body>
        <h1>Novo Produto</h1>
        <form action="/produtos_insert.php" method="post">
            <label>Nome</label>
            <input type="text" name="nome" />
            <label>Quantidade</label>
            <input type="number" name="quantidade" />
            <button type="submit">Salvar</button>
        </form>
        <hr />
        <ul>
        <?php foreach($lista as $item): ?>
            <li><?= $item['nome'] ?> : <?= $item['quantidade'] ?> </li>
        <?php endforeach; ?>
        </ul>
    </body>
</html>