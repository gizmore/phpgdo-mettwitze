<?php
declare(strict_types=1);
namespace GDO\Mettwitze;

use GDO\Comments\CommentedObject;
use GDO\Core\GDO;
use GDO\Core\GDT_AutoInc;
use GDO\Core\GDT_CreatedAt;
use GDO\Core\GDT_CreatedBy;
use GDO\Core\GDT_String;
use GDO\Core\GDT_Template;
use GDO\Date\Time;
use GDO\User\GDO_User;
use GDO\Votes\GDT_VoteCount;
use GDO\Votes\GDT_VoteRating;
use GDO\Votes\WithVotes;

/**
 * A mettwitz entity.
 *
 * @version 7.0.3
 */
final class GDO_Mettwitz extends GDO
{

	################
	### Comments ###
	################
	use CommentedObject;

	public function gdoCommentTable() { return GDO_MettwitzComments::table(); }

	public function gdoCommentsEnabled() { return Module_Mettwitze::instance()->cfgComments(); }

	public function gdoCanComment(GDO_User $user): bool { return $user->isMember() || Module_Mettwitze::instance()->cfgGuestComments(); }

	public function gdoCommentHrefEdit() { return href('Mettwitze', 'EditComment'); }

	#############
	### Votes ###
	#############
	use WithVotes;

	public function gdoVoteTable() { return GDO_MettwitzVote::table(); }

	###########
	### GDO ###
	###########
	public function gdoColumns(): array
	{
		return [
			GDT_AutoInc::make('mw_id'),
			GDT_String::make('mw_question')->notNull()->min(4)->max(2048),
			GDT_String::make('mw_answer')->notNull()->min(4)->max(2048),
			GDT_CreatedAt::make('mw_created'),
			GDT_CreatedBy::make('mw_creator'),
			GDT_VoteCount::make('mw_votes'),
			GDT_VoteRating::make('mw_rating'),
		];
	}

	##############
	### Render ###
	##############

	public function renderList(): string
	{
		return GDT_Template::php('Mettwitze', 'witz_list.php', ['gdo' => $this]);
	}

	public function renderCard(): string
	{
		return GDT_Template::php('Mettwitze', 'witz_card.php', ['gdo' => $this]);
	}

	##############
	### Getter ###
	##############

	public function canEdit(GDO_User $user)
	{
		return $user->isStaff();
	}

	public function href_edit()
	{
		return href('Mettwitze', 'CRUD', '&id=' . $this->getID());
	}

	public function getCreator(): GDO_User { return $this->gdoValue('mw_creator'); }

	public function getCreatorId() { return $this->gdoVar('mw_creator'); }

	public function displayAge() { return Time::displayAge($this->getCreated()); }

	public function getCreated() { return $this->gdoVar('mw_created'); }

	##############
	### Render ###
	##############

	public function displayQuestion() { return $this->gdoDisplay('mw_question'); }

	public function displayAnswer() { return $this->gdoDisplay('mw_answer'); }

}
