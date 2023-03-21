<?php
namespace GDO\Mettwitze\Method;

use GDO\Core\GDT_Response;
use GDO\DB\Query;
use GDO\Mettwitze\GDO_Mettwitz;
use GDO\Table\GDT_PageMenu;
use GDO\Table\MethodQueryList;
use GDO\UI\GDT_Bar;
use GDO\UI\GDT_Button;

final class Random extends MethodQueryList
{

	public function gdoTable() { return GDO_Mettwitz::table(); }

	public function isPaginated(): bool { return false; }

	public function isSearched(): bool { return false; }

	public function isFiltered(): bool { return false; }

	public function isOrdered(): bool { return false; }

// 	protected function setupTitle(GDT_Table $list)
// 	{
// 		$list->title(t('list_random', [$this->gdoParameter('ipp')->ipp]));
// 	}

	public function gdoParameters(): array
	{
		return [
			GDT_PageMenu::make('ipp')->ipp('1'),
		];
	}

	public function getQuery(): Query
	{
		return $this->gdoTable()->select()->first()->order('rand()');
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
