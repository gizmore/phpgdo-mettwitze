<?php
declare(strict_types=1);
namespace GDO\Mettwitze\Test;

use GDO\Mettwitze\GDO_Mettwitz;
use GDO\Mettwitze\GDO_MettwitzComments;
use GDO\Mettwitze\Method\AddComment;
use GDO\Mettwitze\Method\CRUD;
use GDO\Mettwitze\Method\ListWitze;
use GDO\Table\Module_Table;
use GDO\Tests\GDT_MethodTest;
use GDO\Tests\TestCase;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertStringContainsString;
use function PHPUnit\Framework\assertTrue;

/**
 * Also tests:
 *
 * - Pagemenu
 * - BigSearch
 *
 * @version 7.0.3
 * @since 6.9.2
 * @author gizmore
 */
final class MettwitzeTest extends TestCase
{

	public function testCreation()
	{
		$m = CRUD::make();
		$p = [
			'mw_question' => 'Mettwitz 1 - Frage 1',
			'mw_answer' => 'Mettwitz 1 - Antwort 1',
		];
		GDT_MethodTest::make()->method($m)->inputs($p)->execute('create');
		$this->assertOK('Test if Mettwitz can be created.');

		$p = [
			'mw_question' => 'Mettwitz 2 - Frage 2',
			'mw_answer' => 'Mettwitz 2 - Antwort 2',
		];
		GDT_MethodTest::make()->method($m)->inputs($p)->execute('create');
		$this->assertOK('Test if Mettwitz 2 can be created.');

		$p = [
			'mw_question' => 'Mettwitz 3 - Frage 3',
			'mw_answer' => 'Mettwitz 3 - Antwort 3',
		];
		GDT_MethodTest::make()->method($m)->inputs($p)->execute('create');
		$this->assertOK('Test if Mettwitz 3 can be created.');

		$count = GDO_Mettwitz::table()->countWhere();
		assertEquals(3, $count, 'Test if 3 Mettwitze can be created.');
	}

	public function testComments(): void
	{
		$p = [
			'id' => '1',
			'comment_message' => 'This is a test comment.',
		];
		$m = GDT_MethodTest::make()->method(AddComment::make())->inputs($p);
		$m->execute('submit');
		$this->assertOK('Test if comments can be added.');
		$this->assertGreaterThanOrEqual(1, GDO_MettwitzComments::table()->countWhere(), 'Test if mettwitze comments get persisted.');
	}

	public function testPagemenu()
	{
		$mt = Module_Table::instance();
		$mt->saveConfigVar('ipp_cli', '2');
		$mt->saveConfigVar('ipp_http', '2');
		$ipp = $mt->cfgItemsPerPage();
		assertEquals('2', $ipp);

		$m = ListWitze::make();
		$gp = [
			'page' => '1',
		];
		$r = GDT_MethodTest::make()->method($m)->inputs($gp)->execute();
		$html = $r->renderWebsite();
		assertStringContainsString('Mettwitz 2', $html);
		assertStringContainsString('Frage 2', $html);
		assertStringContainsString(' rel="next"', $html);

		$m = ListWitze::make();
		$gp = [
			'page' => '2',
		];
		$r = GDT_MethodTest::make()->method($m)->inputs($gp);
		$r = $r->execute();
		$html = $r->renderWebsite();
		assertStringContainsString('Mettwitz 3', $html);
		assertStringContainsString('Frage 3', $html);
		assertStringContainsString(' rel="prev"', $html);
		self::assertStringNotContainsString('Mettwitz 2', $html);
	}

	public function testBigSearch()
	{
		$m = ListWitze::make();
		$gp = [
			'search' => 'Frage 3',
		];
		$r = GDT_MethodTest::make()->method($m)->inputs($gp)->execute();
		$html = $r->renderWebsite();
		assertTrue(!str_contains($html, 'Frage 1'), 'Search does not find question 1.');
		assertTrue(!str_contains($html, 'Frage 2'), 'Search does not find question 2.');
		assertTrue(str_contains($html, 'Frage 3'), 'Search does find question 3.');
	}

}
