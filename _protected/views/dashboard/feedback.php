<?php $feedback = Yii::$app->session->getFlash('feedback');?>
<?php if(!empty($feedback['type']) && !empty($feedback['msg'])):?>
<br>
<div class="alert alert-<?=$feedback['type'];?>">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	<i class="fa fa-check-circle"></i> <?=$feedback['msg'];?>
</div>
<?php endif;?>