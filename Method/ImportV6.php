<?php
declare(strict_types=1);
namespace GDO\Mettwitze\Method;

use GDO\Core\GDT;
use GDO\Form\GDT_AntiCSRF;
use GDO\Form\GDT_Form;
use GDO\Form\GDT_Submit;
use GDO\Form\MethodForm;
use GDO\User\GDO_Permission;
use GDO\User\GDO_User;
use GDO\User\GDO_UserPermission;
use GDO\User\GDT_UserType;

/**
 * Import the gdo6 database of mettwitze.gizmore.org
 */
final class ImportV6 extends MethodForm
{

	public function isTrivial(): bool
	{
		return false;
	}

	public function getPermission(): ?string
	{
		return GDO_Permission::ADMIN;
	}

	public function createForm(GDT_Form $form): void
	{
		$form->addFields(
			GDT_AntiCSRF::make(),
		);
		$form->actions()->addField(GDT_Submit::make());
	}

	public function formValidated(GDT_Form $form): GDT
	{
		return $this->message('msg_mett6_imported');
	}

}
