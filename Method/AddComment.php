<?php
namespace GDO\Mettwitze\Method;

use GDO\Comment\Comments_Write;
use GDO\Mettwitze\GDO_MettwitzComments;
use GDO\Util\Common;

final class AddComment extends Comments_Write
{
	public function hrefList()
	{
		$append = '&id=' . Common::getRequestString('id');
		return href('Mettwitze', 'ListComments', $append);
	}

	public function gdoCommentsTable()
	{
		return GDO_MettwitzComments::table();
	}
	
}
