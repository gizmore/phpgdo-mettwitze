<?php
namespace GDO\Mettwitze\Method;

use GDO\Table\MethodQueryList;
use GDO\Mettwitze\GDO_Mettwitz;
use GDO\Core\GDT_Response;
use GDO\UI\GDT_Paragraph;

/**
 * List of Mettwitze.
 * Write some info paragraph on page 1.
 * 
 * @author gizmore
 * @version 6.10.1
 * @since 6.9.0
 */
final class ListWitze extends MethodQueryList
{
	public function gdoTable()
	{
		return GDO_Mettwitz::table();
	}
	
	public function gdoHeaders()
	{
	    return $this->gdoTable()->getGDOColumns([
	        'mw_question', 'mw_answer', 'mw_votes', 'mw_rating', 'mw_creator', 'mw_created']);
	}
	
	public function getDefaultOrder() { return 'mw_created DESC'; }
	
	public function execute()
	{
		if ((@$_REQUEST[$this->getHeaderName()]['page']) <= 1)
		{
			$paragraph = GDT_Paragraph::make()->text('mdescr_mettwitze_listwitze');
			return GDT_Response::makeWith($paragraph)->addField(parent::execute());
		}
		return parent::execute();
	}
	
}
