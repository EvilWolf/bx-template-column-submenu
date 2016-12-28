<?php
/* Формирует массив колонок, а не ссылок. */

$arColumns = array(); /* Сами колонки */
$arElements = array(); /* Буффер для содержимого колонок */

// $arItem['PARAMS']['COLUMN'] - ID колонки
$ColumnID = '';
foreach ($arResult as $arItem):
	/* Учавствуют только Пункты с Depth Level === 1, они же и формируют новую колонку */
	if ($arItem['DEPTH_LEVEL'] == 1) {

		/* Сбрасываем элементы которые уже есть в буфере, при этом учитывам ID колонки. */
		if (count($arElements) > 0) {
			if (empty($arColumns[$ColumnID]))
				$arColumns[$ColumnID] = array();

			$arColumns[$ColumnID] = array_merge($arColumns[$ColumnID], $arElements);
		}

		/* Сбрасываем буфер */
		$arElements = array();
		$arElement = $arItem;
		$linkPath = GetDirPath($arItem["LINK"]);
		$ColumnID = $arItem['PARAMS']['COLUMN'];

		/* Если элемент является родителем, то берём название колонки из раздела */
		if ($arElement['IS_PARENT']) {
			/* Также первым элементом туда идёт итем с названием категории, но без названия ссылки. */
			$arElement['TEXT'] = EWGetDirTitle($linkPath);
			$arElement['LINK'] = false;
			array_push($arElements, $arElement);
		} else {
			/* Иначе оставляем как есть, в этот список нужно будет добавить дополнительный элемент в виде текущей ссылки и название взять из поля menu_title */
			$arAdditionalElement = $arElement;
			$arAdditionalElement['TEXT'] = $APPLICATION->GetDirProperty('menu_title', $linkPath, false);
			$arElement['LINK'] = false;
			array_push($arElements, $arElement);
			array_push($arElements, $arAdditionalElement);
		}
	} else {
		array_push($arElements, $arItem);
	}
endforeach;

/* Сбрасываем буфер если в нём что-то осталось */
if (count($arElements) > 0)
	$arColumns[$ColumnID] = array_merge($arColumns[$ColumnID], $arElements);

/* Подменяем исходные данные (Старый стиль, @TODO: помень на объект компонента) */
$arResult = $arColumns;
