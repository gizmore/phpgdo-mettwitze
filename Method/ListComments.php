<?php
namespace GDO\Mettwitze\Method;

use GDO\Comments\Comments_List;
use GDO\Core\GDT_Response;
use GDO\Mettwitze\GDO_MettwitzComments;
use GDO\UI\GDT_Bar;
use GDO\UI\GDT_Link;

/**
 * Paginated list of comments for an entry.
 *
 * @author gizmore
 */
final class ListComments extends Comments_List
{

	public function hrefAdd()
	{
		$append = '&id=' . $this->gdoParameterVar('id');
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
