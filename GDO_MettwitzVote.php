<?php
namespace GDO\Mettwitze;

use GDO\Vote\GDO_VoteTable;

final class GDO_MettwitzVote extends GDO_VoteTable
{
	public function gdoVoteObjectTable() { return GDO_Mettwitz::table(); }
	public function gdoVoteMax() { return 5; }
	public function gdoVotesBeforeOutcome() { return 1; }
	public function gdoVoteCooldown() { return 60*60*24; }
	public function gdoVoteGuests() { return Module_Mettwitze::instance()->cfgGuestVotes(); }
	
}
