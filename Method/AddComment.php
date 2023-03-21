<?php
namespace GDO\Mettwitze\Method;

use GDO\Comments\Comments_Write;
use GDO\Comments\GDO_CommentTable;
use GDO\Mettwitze\GDO_MettwitzComments;

/**
 * Add a Comment to a Mettwitz.
 *
 * @version 7.0.1
 * @since 6.5.0
 * @author gizmore
 */
final class AddComment extends Comments_Write
{

	public function hrefList(): string
	{
		$append = '&id=' . $this->gdoParameterVar('id');
		return href('Mettwitze', 'ListComments', $append);
	}

	public function gdoCommentsTable(): GDO_CommentTable
	{
		return GDO_MettwitzComments::table();
	}

}
