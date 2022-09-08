<?php
namespace GDO\Mettwitze\Test;

use GDO\Tests\TestCase;
use function PHPUnit\Framework\assertGreaterThanOrEqual;
use GDO\Mettwitze\Method\CRUD;
use GDO\Tests\MethodTest;
use GDO\Mettwitze\GDO_Mettwitz;
use GDO\Mettwitze\Method\ListWitze;
use GDO\Table\Module_Table;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertStringContainsString;
use function PHPUnit\Framework\assertNotContains;
use function PHPUnit\Framework\assertContains;
use function PHPUnit\Framework\assertTrue;

/**
 * Also tests:
 * 
 * - Pagemenu
 * - BigSearch
 * 
 * @author gizmore
 * @version 6.10.1
 * @since 6.9.2
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
        MethodTest::make()->method($m)->parameters($p)->execute('create');
        $this->assert200("Test if Mettwitz can be created.");
        
        $p = [
            'mw_question' => 'Mettwitz 2 - Frage 2',
            'mw_answer' => 'Mettwitz 2 - Antwort 2',
        ];
        MethodTest::make()->method($m)->parameters($p)->execute('create');
        $this->assert200("Test if Mettwitz 2 can be created.");
        
        $p = [
            'mw_question' => 'Mettwitz 3 - Frage 3',
            'mw_answer' => 'Mettwitz 3 - Antwort 3',
        ];
        MethodTest::make()->method($m)->parameters($p)->execute('create');
        $this->assert200("Test if Mettwitz 3 can be created.");
        
        $count = GDO_Mettwitz::table()->countWhere();
        assertEquals(3, $count, 'Test if 3 Mettwitze can be created.');
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
            'o1' => [
                'page' => 1,
            ],
        ];
        $p = [];
        $r = MethodTest::make()->method($m)->parameters($p)->getParameters($gp)->execute();
        $html = $r->render();
        assertStringContainsString('Mettwitz 2', $html);
        assertStringContainsString('Frage 2', $html);
        assertStringContainsString(' rel="next"', $html);

        $m = ListWitze::make();
        $o1 = $m->getHeaderName();
        $gp = [
            $o1 => [
                'page' => 2,
            ],
        ];
        $r = MethodTest::make()->method($m)->parameters($p)->getParameters($gp);
        $r = $r->execute();
        $html = $r->render();
        assertStringContainsString('Mettwitz 3', $html);
        assertStringContainsString('Frage 3', $html);
        assertStringContainsString(' rel="prev"', $html);
    }
 
    public function testBigSearch()
    {
        $m = ListWitze::make();
        $o1 = $m->getHeaderName();
        $gp = [
            $o1 => [
                'search' => 'Frage 3',
            ], 
        ];
        $r = MethodTest::make()->method($m)->getParameters($gp)->execute();
        $html = $r->render();
        assertTrue(strpos($html, "Frage 1") === false, "Search does not find question 1.");
        assertTrue(strpos($html, "Frage 2") === false, "Search does not find question 2.");
        assertTrue(strpos($html, "Frage 3") !== false, "Search does find question 3.");
    }
    
}
