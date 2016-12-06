<?php
require __DIR__ . '/Application/Autoload/Loader.php';
Application\Autoload\Loader::init(__DIR__);
use Application\Form\Generic;
use Application\Form\Element\Select;


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

$status1 = new Select('status1',
		Generic::TYPE_SELECT,
		'Status 1',
		$wrappers,
		['id' => 'status1']);

$status2 = new Select('status2',
		Generic::TYPE_SELECT,
		'Status 2',
		$wrappers,
		['id' => 'status2',
		 'multiple' => '',
		 'size' => '4']);
		
$checked1 = $_GET['status1'] ?? 'U';
$checked2 = $_GET['status2'] ?? ['U'];

$status1->setOptions($statusList, $checked1);
$status2->setOptions($statusList, $checked2);

$submit = new Generic('submit',
		Generic::TYPE_SUBMIT,
		'Process',
		$wrappers,
		['id' => 'submit','title' =>
				'Click to process','value' => 'Click Here']);
?>

<form name="status" method="get">
<table id="status" class="display" cellspacing="0" width="100%">
<tr><?= $status1->render(); ?></tr>
<tr><?= $status2->render(); ?></tr>
<tr><?= $submit->render(); ?></tr>
<tr>
<td colspan=2>
<br>
<pre>
<?php var_dump($_GET); ?>
</pre>
</td>
</tr>
</table>
</form>		