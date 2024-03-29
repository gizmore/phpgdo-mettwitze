<?php
namespace GDO\Mettwitze\Method;

use GDO\Core\GDO;
use GDO\Form\GDT_Form;
use GDO\Form\MethodCrud;
use GDO\Mail\Mail;
use GDO\Mettwitze\GDO_Mettwitz;
use GDO\Mettwitze\Module_Mettwitze;
use GDO\User\GDO_User;

final class CRUD extends MethodCrud
{

	public function gdoTable(): GDO { return GDO_Mettwitz::table(); }

	public function hrefList(): string { return href('Mettwitze', 'ListWitze'); }

	public function canCreate(GDO $table): bool { return GDO_User::current()->isMember() || Module_Mettwitze::instance()->cfgGuestJokes(); }

	public function canDelete(GDO $gdo): bool { return GDO_User::current()->isStaff(); }

	public function canUpdate(GDO $gdo): bool
	{
		$user = GDO_User::current();
		if ($user->isStaff())
		{
			return true;
		}
		return $gdo->getCreator() === $user;
	}

	public function afterCreate(GDT_Form $form, GDO $gdo): void
	{
		$this->sendMails($form, $gdo);
	}

	private function sendMails(GDT_Form $form, GDO_Mettwitz $gdo)
	{
		foreach (GDO_User::admins() as $user)
		{
			$this->sendMail($user, $form, $gdo);
		}
	}

	private function sendMail(GDO_User $user, GDT_Form $form, GDO_Mettwitz $gdo)
	{
		$mail = Mail::botMail();
		$mail->setSubject(tusr($user, 'mail_subj_new_mettwitz'));
		$tVars = [
			$user->renderUserName(),
			$gdo->displayQuestion(),
			$gdo->displayAnswer(),
			sitename(),
		];
		$mail->setBody(tusr($user, 'mail_body_new_mettwitz', $tVars));
		$mail->sendToUser($user);
	}

}
