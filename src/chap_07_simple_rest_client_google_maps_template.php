<?php
foreach ($routes->legs as $item) : ?>
<!-- Trip Info -->
<br>Distance: <?= $item->distance->text; ?>
<br>Duration: <?= $item->duration->text; ?>
<!-- Driving Directions -->
<table>
<tr>
<th>Distance</th><th>Duration</th><th>Directions</th>
</tr>
<?php foreach ($item->steps as $step) : ?>
<?php $class = ($count++ & 01) ? 'color1' : 'color2'; ?>
<tr>
<td class="<?= $class ?>"><?= $step->distance->text ?></td>
<td class="<?= $class ?>"><?= $step->duration->text ?></td>
<td class="<?= $class ?>"><?= $step->html_instructions ?></td>
</tr>
<?php endforeach; ?>
</table>
<?php endforeach; ?>