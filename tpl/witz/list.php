<?php
use GDO\Mettwitze\GDO_Mettwitz;
use GDO\User\GDO_User;
use GDO\Vote\GDT_VotePopup;
use GDO\UI\GDT_EditButton;
/** @var $gdo GDO_Mettwitz **/
$gdo instanceof GDO_Mettwitz;
$id = $gdo->getID();
$user = GDO_User::current();
$q = seo($gdo->displayQuestion());
$hrefShare = href('Mettwitze', 'Witz', "&id={$id}&q={$q}");
$hrefCommentWrite = href('Mettwitze', 'AddComment', "&id={$id}");
$hrefComments = href('Mettwitze', 'ListComments', "&id={$id}");
?>
<div
 style="cursor: pointer;"
 onclick="GDO.Mettwitze.revealJoke('<?=$gdo->getID()?>')"
 class="list-group-item list-group-item-action flex-column align-items-start">
  <div class=" w-100 justify-content-between">
    <small class="text-muted fr"><?=t('witz_meta', [$gdo->displayAge(), $gdo->getCreator()->displayNameLabel()])?></small>
    <?=GDT_VotePopup::make()->gdo($gdo)->renderCell()?>
  </div>
  <span class="cb"></span>
  <h5 class="mb-1 bw"><?=$gdo->displayQuestion()?></h5>
  <p id="joke_<?=$gdo->getID()?>"
   class="mb-1"
   style="opacity: 0.0;"><?=$gdo->displayAnswer()?></p>
  <small class="text-muted">
    <a href="<?=$hrefCommentWrite?>" rel="nofollow"><?=t('btn_write_comment')?></a>
    (<a href="<?=$hrefComments?>"><?=t('link_comments', [$gdo->getCommentCount()])?></a>)
    <a href="<?=$hrefShare?>"><?=t('btn_share')?></a>
<?php if ($gdo->canEdit($user)) : ?>
<?= GDT_EditButton::make()->noFollow()->gdo($gdo)->addClass('ri')->renderCell(); ?>
<?php endif; ?>
  </small>
  <span class="cb"></span>
</div>
