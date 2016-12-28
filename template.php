<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die(); ?>
<? $first = true; ?>

/* $arResult изменён в result_modifier.php */
<? foreach ($arResult as $arColumn): ?>
	<div class="col-lg-2 <?= ($first) ? 'col-lg-offset-1' : '' ?>">
		<ul class="submenu_list">
		<? $first = false; ?>
		<? foreach ($arColumn as $arItem): ?>
			<? if ($arItem['LINK']): ?>
				<li class="submenu_list_item"><a href="<?= $arItem["LINK"] ?>"><?= $arItem["TEXT"] ?></a></li>
			<? else: ?>
				<b class="submenu_list__title"><?= $arItem["TEXT"] ?></b>
			<? endif; ?>
		<? endforeach; ?>
		</ul>
	</div>
<? endforeach; ?>
