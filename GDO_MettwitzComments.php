<?php
namespace GDO\Mettwitze;

use GDO\Comment\GDO_CommentTable;
use GDO\User\GDO_User;

final class GDO_MettwitzComments extends GDO_CommentTable
{
	public function gdoCommentedObjectTable() { return GDO_Mettwitz::table(); }
	public function gdoAllowFiles() { return false; }
	public function gdoEnabled() { return Module_Mettwitze::instance()->cfgComments(); }
	public function gdoMaxComments(GDO_User $user) { return 100; }
	
}
