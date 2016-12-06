<?php
require __DIR__ . '/Application/Autoload/Loader.php';
Application\Autoload\Loader::init(__DIR__);
use Application\Form\Generic;
use Application\Form\Element\Radio;

$wrappers = [
		Generic::INPUT => ['type' => 'td', 'class' => 'content'],
		Generic::LABEL => ['type' => 'th', 'class' => 'label'],
		Generic::ERRORS => ['type' => 'td', 'class' => 'error']
];

$statusList = [
		'U' => 'Unconfirmed',
		'P' => 'Pending',
		'T' => 'Temporary Approval',
		'A' => 'Approved'];

$status = new Radio('status',
		Generic::TYPE_RADIO,
		'Status',
		$wrappers,
		['id' => 'status']);

$checked = $_GET['status'] ?? 'U';
$status->setOptions($statusList, $checked, '<br>', TRUE);

$submit = new Generic('submit',
		Generic::TYPE_SUBMIT,
		'Process',
		$wrappers,
		['id' => 'submit','title' =>
				'Click to process','value' => 'Click Here']);
?>

<form name="status" method="get">
<table id="status" class="display" cellspacing="0" width="100%">
<tr><?= $status->render(); ?></tr>
<tr><?= $submit->render(); ?></tr>
<tr>
<td colspan=2>
<br>
<pre><?php var_dump($_GET); ?></pre>
</td>
</tr>
</table>
</form>