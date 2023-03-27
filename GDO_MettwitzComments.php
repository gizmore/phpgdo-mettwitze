<?php
declare(strict_types=1);
namespace GDO\Mettwitze;

use GDO\Comments\GDO_CommentTable;
use GDO\Core\GDO;
use GDO\User\GDO_User;

/**
 * Mettwitze comments table.
 *
 * @version 7.0.3
 * @since 6.1.0
 */
final class GDO_MettwitzComments extends GDO_CommentTable
{

	public function gdoCommentedObjectTable(): GDO { return GDO_Mettwitz::table(); }

	public function gdoAllowFiles(): bool { return false; }

	public function gdoEnabled(): bool { return !!Module_Mettwitze::instance()->cfgComments(); }

	public function gdoMaxComments(GDO_User $user): int { return 5; }

}
