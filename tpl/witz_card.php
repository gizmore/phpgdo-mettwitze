<?php
namespace GDO\Mettwitze\tpl;
use GDO\UI\GDT_Card;
use GDO\UI\GDT_Divider;
use GDO\UI\GDT_Label;
/** @var $gdo \GDO\Mettwitze\GDO_Mettwitz **/
$card = GDT_Card::make()->gdo($gdo);
$card->creatorHeader();
$card->addFields(array(
    GDT_Label::make('mw_question'),
    GDT_Label::make()->labelRaw($gdo->displayQuestion()),
    GDT_Label::make('mw_answer'),
    GDT_Label::make()->labelRaw($gdo->displayAnswer()),
	GDT_Divider::make(),
	$gdo->getVoteCountColumn(),
	$gdo->getVoteRatingColumn(),
));
echo $card->render();
