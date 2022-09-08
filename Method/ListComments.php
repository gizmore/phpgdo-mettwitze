<?php
namespace GDO\Mettwitze\Method;

use GDO\Comment\Comments_List;
use GDO\Mettwitze\GDO_MettwitzComments;
use GDO\UI\GDT_Bar;
use GDO\UI\GDT_Link;
use GDO\Util\Common;
use GDO\Core\GDT_Response;

final class ListComments extends Comments_List
{
	public function hrefAdd()
	{
		$append = '&id=' . Common::getRequestString('id');
		return href('Mettwitze', 'AddComment', $append);
	}

	public function gdoCommentsTable()
	{
		return GDO_MettwitzComments::table();
	}
	
	public function execute()
	{
		$link = GDT_Link::make('btn_write_comment')->href($this->hrefAdd());
		$bar = GDT_Bar::make()->horizontal()->addField($link);
		return parent::execute()->addField(GDT_Response::makeWith($bar));
	}
	
}
