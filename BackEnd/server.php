<?php

require 'CrudNovo.php';

$errors = array();
$data = array();
$opc = null;

$opc = key($_POST);

if (!empty($opc)) {
	if (!empty($_POST[$opc])) {
		$usuario = array();
		foreach ( $_POST[key($_POST)] as $chave => $valor ) {
			$usuario[$chave] = $valor;
		}
	}

	if (empty($usuario['cliente_nome']))
		$errors['name'] = 'Nome e Obrigatorio.';

	if (empty($usuario['cliente_email']))
		$errors['email'] = 'Email e Obrigatorio.';

	if ($opc=="cadastra" and !empty($usuario['cliente_nome']) and !empty($usuario['cliente_nome'])) {
		Crud::insert("cliente_tb", array('cliente_nome' => $usuario['cliente_nome'],'cliente_email' => $usuario['cliente_email']));

	}else if ($opc=="atualizar" and !empty($usuario['cliente_nome']) and !empty($usuario['cliente_nome'])) {
		Crud::atualiza("cliente_tb", 'cliente_id', $usuario['cliente_id'], array('cliente_nome' => $usuario['cliente_nome'],'cliente_email' => $usuario['cliente_email']));

	}else if ($opc=="deletar" and !empty($usuario['cliente_id'])) {
		Crud::deletar("cliente_tb", 'cliente_id', $usuario['cliente_id']);
	}

	if (!empty($errors)) {
		$data['success'] = false;
		$data['errors']  = $errors;
	}else{
		$data['success'] = true;
		$data['message'] = 'Success!';
	}
}else{
	$data = array('user' => Crud::lista("cliente_tb"));
}
echo json_encode($data);
?>