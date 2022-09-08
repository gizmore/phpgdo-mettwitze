<?php
namespace GDO\Mettwitze\Method;

use GDO\Table\MethodQueryList;
use GDO\Mettwitze\GDO_Mettwitz;
use GDO\Core\GDT_Response;
use GDO\Table\GDT_PageMenu;
use GDO\UI\GDT_Bar;
use GDO\UI\GDT_Button;
use GDO\Table\GDT_Table;
use GDO\DB\GDT_Object;
use GDO\Util\Common;
use GDO\Util\Strings;

final class Witz extends MethodQueryList
{
	public function gdoTable() { return GDO_Mettwitz::table(); }
	public function isPaginated() { return false; }
	
	public function isSearched() { return false; }
	public function isFiltered() { return false; }
	public function isOrdered() { return false; }
	
	/**
	 * @return GDO_Mettwitz
	 */
	private function getWitz()
	{
		return $this->gdoParameterValue('id');
	}
	
	protected function setupTitle(GDT_Table $list)
	{
		$witz = $this->getWitz();
		$qstn = $witz->displayQuestion();
		$list->titleRaw($qstn);
	}
	
	public function getTitle()
	{
		$witz = $this->getWitz();
		$qstn = $witz->displayQuestion();
		$qstn = Strings::dotted($qstn, 64);
		return $qstn;
	}
	
	public function getDescription()
	{
		$witz = $this->getWitz();
		$qstn = $witz->displayQuestion();
		return t('mdescr_mettwitze_witz', [GDO_DOMAIN, $qstn]);
	}
	
	public function gdoParameters()
	{
		return [
			GDT_Object::make('id')->table(GDO_Mettwitz::table())->notNull(),
			GDT_PageMenu::make('ipp')->ipp('1')->writable(false),
		];
	}
	
	public function getQuery()
	{
		$id = Common::getRequestInt('id');
		return $this->gdoTable()->select()->first()->where("mw_id=$id");
	}
	
	public function execute()
	{
		$more = GDT_Response::makeWith(
		GDT_Bar::make()->horizontal()->addField(
		GDT_Button::make('link_more_random_mett')->noFollow()->href(href('Mettwitze', 'Random'))
		)
		);
		return parent::execute()->addField($more);
	}
	
}
