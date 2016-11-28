<?php
require __DIR__ . '/Application/Autoload/Loader.php';
Application\Autoload\Loader::init(__DIR__);
use Application\Form\Generic;

$wrappers = [
		Generic::INPUT => ['type' => 'td', 'class' => 'content'],
		Generic::LABEL => ['type' => 'th', 'class' => 'label'],
		Generic::ERRORS => ['type' => 'td', 'class' => 'error']
];

$email = new Generic('email', Generic::TYPE_EMAIL, 'Email', $wrappers, ['id' => 'email', 'maxLength' => 128, 'title' => 'Enter address', 'required' => '']);
		
$password = new Generic('password', $email);
$password->setType(Generic::TYPE_PASSWORD);
$password->setLabel('Password');
$password->setAttributes(['id' => 'password', 'title' => 'Enter your password', 'required' => '']);

$submit = new Generic('submit', Generic::TYPE_SUBMIT, 'Login', $wrappers, ['id' => 'submit','title' => 'Click to login','value' => 'Click Here']);
?>		
<div class="container">
<!-- Login Form -->
<h1>Login</h1>
<form name="login" method="post">
	<table id="login" class="display" cellspacing="0" width="100%">
		<tr><?= $email->render(); ?></tr>
		<tr><?= $password->render(); ?></tr>
		<tr><?= $submit->render(); ?></tr>
		<tr>
			<td colspan=2><br><?php var_dump($_POST); ?></td>
		</tr>
	</table>
</form>
</div>

