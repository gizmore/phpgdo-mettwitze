<?php
namespace GDO\Mettwitze\Method;

use GDO\Core\GDO;
use GDO\Core\GDT;
use GDO\Core\GDT_Response;
use GDO\Mettwitze\GDO_Mettwitz;
use GDO\Table\MethodQueryList;
use GDO\UI\GDT_Paragraph;

/**
 * List of Mettwitze.
 * Write some info paragraph on page 1.
 *
 * @version 7.0.1
 * @since 6.9.0
 * @author gizmore
 */
final class ListWitze extends MethodQueryList
{

	public function gdoTable(): GDO
	{
		return GDO_Mettwitz::table();
	}

	public function gdoHeaders(): array
	{
		return $this->gdoTable()->getGDOColumns([
			'mw_question', 'mw_answer', 'mw_votes', 'mw_rating', 'mw_creator', 'mw_created']);
	}

	public function getDefaultOrder(): ?string { return 'mw_created DESC'; }

	public function execute(): GDT
	{
		if ($this->getPage() <= 1)
		{
			$paragraph = GDT_Paragraph::make()->text('mdescr_mettwitze_listwitze');
			return GDT_Response::makeWith($paragraph)->addField(parent::execute());
		}
		return parent::execute();
	}

}
