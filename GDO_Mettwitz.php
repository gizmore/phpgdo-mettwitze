<?php
namespace GDO\Mettwitze;

use GDO\Comment\CommentedObject;
use GDO\Core\GDO;
use GDO\DB\GDT_AutoInc;
use GDO\DB\GDT_CreatedAt;
use GDO\DB\GDT_CreatedBy;
use GDO\DB\GDT_String;
use GDO\Vote\GDT_VoteCount;
use GDO\Vote\GDT_VoteRating;
use GDO\Vote\WithVotes;
use GDO\User\GDO_User;
use GDO\Core\GDT_Template;
use GDO\Date\Time;

final class GDO_Mettwitz extends GDO
{
	################
	### Comments ###
	################
	use CommentedObject;
	public function gdoCommentTable() { return GDO_MettwitzComments::table(); }
	public function gdoCommentsEnabled() { return Module_Mettwitze::instance()->cfgComments(); }
	public function gdoCanComment(GDO_User $user) { return $user->isMember() || Module_Mettwitze::instance()->cfgGuestComments(); }
	public function gdoCommentHrefEdit() { return href('Mettwitze', 'EditComment'); }
	
	#############
	### Votes ###
	#############
	use WithVotes;
	public function gdoVoteTable() { return GDO_MettwitzVote::table(); }
	
	###########
	### GDO ###
	###########
	public function gdoColumns()
	{
		return array(
			GDT_AutoInc::make('mw_id'),
			GDT_String::make('mw_question')->notNull()->min(4)->max(2048),
			GDT_String::make('mw_answer')->notNull()->min(4)->max(2048),
			GDT_CreatedAt::make('mw_created'),
			GDT_CreatedBy::make('mw_creator'),
			GDT_VoteCount::make('mw_votes'),
			GDT_VoteRating::make('mw_rating'),
		);
	}
	
	############
	### Perm ###
	############
	public function canEdit(GDO_User $user)
	{
		return $user->isStaff();
	}
	
	public function href_edit()
	{
		return href('Mettwitze', 'CRUD', '&id=' . $this->getID());
	}
	
	##############
	### Getter ###
	##############
	/**
	 * @return GDO_User
	 */
	public function getCreator() { return $this->getValue('mw_creator'); }
	public function getCreatorId() { return $this->getVar('mw_creator'); }
	public function getCreated() { return $this->getVar('mw_created'); }
	
	public function displayAge() { return Time::displayAge($this->getCreated()); }
	public function displayQuestion() { return $this->display('mw_question'); }
	public function displayAnswer() { return $this->display('mw_answer'); }

	##############
	### Render ###
	##############
	public function renderList()
	{
		return GDT_Template::php('Mettwitze', 'witz/list.php', ['gdo' => $this]);
	}

	public function renderCard()
	{
		return GDT_Template::php('Mettwitze', 'witz/card.php', ['gdo' => $this]);
	}
}
