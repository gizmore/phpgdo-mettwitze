<?php
namespace GDO\Mettwitze\Method;

use GDO\Core\GDO;
use GDO\Core\GDT;
use GDO\Core\GDT_Object;
use GDO\Core\GDT_Response;
use GDO\DB\Query;
use GDO\Mettwitze\GDO_Mettwitz;
use GDO\Table\MethodQueryList;
use GDO\UI\GDT_Bar;
use GDO\UI\GDT_Button;
use GDO\Util\Strings;

/**
 * Display a single Joke as a permalink.
 *
 * @version 7.0.1
 * @author gizmore
 */
final class Witz extends MethodQueryList
{

	public function gdoTable(): GDO { return GDO_Mettwitz::table(); }

	public function isPaginated(): bool { return false; }

	public function isSearched(): bool { return false; }

	public function isFiltered(): bool { return false; }

	public function isOrdered(): bool { return false; }

	private function getWitz(): GDO_Mettwitz
	{
		return $this->gdoParameterValue('id');
	}

// 	protected function setupTitle(GDT_Table $list)
// 	{
// 		$witz = $this->getWitz();
// 		$qstn = $witz->displayQuestion();
// 		$list->titleRaw($qstn);
// 	}

	public function getMethodTitle(): string
	{
		$witz = $this->getWitz();
		$qstn = $witz->displayQuestion();
		$qstn = Strings::dotted($qstn, 64);
		return $qstn;
	}

	public function getMethodDescription(): string
	{
		$witz = $this->getWitz();
		$qstn = $witz->displayQuestion();
		return t('mdescr_mettwitze_witz', [GDO_DOMAIN, $qstn]);
	}

	public function gdoParameters(): array
	{
		return [
			GDT_Object::make('id')->table(GDO_Mettwitz::table())->notNull(),
// 			GDT_PageMenu::make('ipp')->ipp('1')->writable(false),
		];
	}

	public function getQuery(): Query
	{
		$id = $this->gdoParameterVar('id');
		return $this->gdoTable()->select()->first()->where("mw_id=$id");
	}

	public function execute(): GDT
	{
		$more = GDT_Response::makeWith(
			GDT_Bar::make()->horizontal()->addField(
				GDT_Button::make('link_more_random_mett')->noFollow()->href(href('Mettwitze', 'Random')))
		);
		return parent::execute()->addField($more);
	}

}
