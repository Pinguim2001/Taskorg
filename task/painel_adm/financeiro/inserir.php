<?php
require_once("../../vendor/conexao.php");

$nome =  $_POST['nome-fin'];
$telefone =  $_POST['telefone-fin'];
$cpf =  $_POST['cpf-fin'];
$email =  $_POST['email-fin'];
$endereco =  $_POST['endereco-fin'];

$antigo =  $_POST['antigo'];
$antigo2 =  $_POST['antigo2'];
$id =  $_POST['txtid2'];

if($nome == ""){
  echo "Campo NOME obrigatório";
  exit();
}
if($cpf == ""){
  echo "Campo CPF obrigatório";
  exit();
}
if($email == ""){
  echo "Campo E-MAIL obrigatório";
  exit();
}

//VERIFICAR SE O REGISTRO JA EXISTE NO BANCO
if($antigo != $cpf){
$query = $pdo->query("SELECT * FROM financeiro where cpf = '$cpf' ");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if($total_reg > 0){
  echo "CPF já Cadastrado!";
  exit();
}

}

//VERIFICA SE O REGISTRO COM O MESMO E-MAIL JA EXISTE NO BANCO
if($antigo2 != $email){
$query = $pdo->query("SELECT * FROM financeiro where email = '$email' ");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if($total_reg > 0){
  echo "E-mail já Cadastrado!";
  exit();

}

}


if($id == ""){

$res = $pdo->prepare("INSERT INTO financeiro SET nome = :nome, cpf = :cpf, email = :email, endereco = :endereco, telefone = :telefone");
$res2 = $pdo->prepare("INSERT INTO usuarios SET nome = :nome, cpf = :cpf, email = :email, senha = :senha, nivel = :nivel");
$res2->bindValue(":senha", '123');
$res2->bindValue(":nivel", 'financeiro');
}else{

  $res = $pdo->prepare("UPDATE financeiro SET nome = :nome, cpf = :cpf, email = :email, endereco = :endereco, telefone = :telefone WHERE id = $id");
  $res2 = $pdo->prepare("UPDATE usuarios SET nome = :nome, cpf = :cpf, email = :email WHERE cpf = $antigo");
}
$res->bindValue(":nome", $nome);
$res->bindValue(":cpf", $cpf);
$res->bindValue(":telefone", $telefone);
$res->bindValue(":email", $email);
$res->bindValue(":endereco", $endereco);

$res2->bindValue(":nome", $nome);
$res2->bindValue(":cpf", $cpf);
$res2->bindValue(":email", $email);


$res->execute();
$res2->execute();


echo 'Salvo com Sucesso!';

 ?>
