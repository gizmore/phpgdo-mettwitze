<?php
namespace GDO\Mettwitze;

use GDO\Core\GDO_Module;
use GDO\Core\GDT_Checkbox;
use GDO\UI\GDT_Link;
use GDO\UI\GDT_Page;

/**
 * A website for Mettwitze. (gdo demo site :)
 * 
 * @author gizmore
 * @version 7.0.1
 * @since 6.10.0
 * @see GDO_Mettwitz
 */
final class Module_Mettwitze extends GDO_Module
{
	##############
	### Module ###
	##############
	public $module_priority = 90; # init very late. 50 is default. 10 for core stuff like jquery or db / core / log.
	
	public function getTheme() : ?string { return 'mettwitze'; } # own theme for tpl overrides @see thm folder.
	public function onLoadLanguage() : void {  $this->loadLanguage('lang/mettwitze'); }
	public function getDependencies() : array { return ['BootstrapTheme', 'JQueryAutocomplete', 'Comment', 'Vote', 'Login', 'Register', 'Admin', 'Recovery', 'Account', 'Profile', 'Sitemap']; }
	public function getClasses() : array
	{
		# Entity tables
		return [
		    GDO_Mettwitz::class,
		    GDO_MettwitzVote::class,
		    GDO_MettwitzComments::class,
		];
	}
	
	##############
	### Config ###
	##############
	public function getConfig() : array
	{
		return [
			GDT_Checkbox::make('allow_guest_jokes')->initial('1'),
			GDT_Checkbox::make('allow_guest_votes')->initial('1'),
			GDT_Checkbox::make('allow_comments')->initial('1'),
			GDT_Checkbox::make('allow_guest_comments')->initial('1'),
		];
	}
	public function cfgGuestJokes() { return $this->getConfigValue('allow_guest_jokes'); }
	public function cfgGuestVotes() { return $this->getConfigValue('allow_guest_votes'); }
	public function cfgComments() { return $this->getConfigValue('allow_comments'); }
	public function cfgGuestComments() { return $this->getConfigValue('allow_guest_comments'); }
	
	#############
	### Hooks ###
	#############
	public function onInitSidebar() : void
	{
// 	    $bar = GDT_Page::$INSTANCE->topResponse();
// 		$bar->addField(GDT_Link::make('lbl_mettwitze')->href(href('Mettwitze', 'ListWitze')));

		$bar = GDT_Page::$INSTANCE->leftBar();
		$bar->addField(GDT_Link::make('link_add_witz')->href(href('Mettwitze', 'CRUD')));
		$bar->addField(GDT_Link::make('link_witze_new')->href(href('Mettwitze', 'ListWitze', '&o[order_by]=mw_created&o[order_dir]=DESC')));
		$bar->addField(GDT_Link::make('link_witze_best')->href(href('Mettwitze', 'ListWitze', '&o[order_by]=mw_rating&o[order_dir]=DESC')));
		$bar->addField(GDT_Link::make('link_witze_rand')->href(href('Mettwitze', 'Random')));
		$bar->addField(GDT_Link::make('link_witze_all')->href(href('Mettwitze', 'ListWitze', '&o[order_by]=mw_created&o[order_dir]=ASC')));
	}
	
	public function onIncludeScripts() : void
	{
		$this->addJS('js/mettwitze.js');
	}
	
}
