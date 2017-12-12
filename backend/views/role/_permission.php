<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $model app\models\ShiftType */
/* @var $form yii\widgets\ActiveForm */


?>

<div class="role-permissions-form">

    <?php $form = ActiveForm::begin(); ?>

		<?php
			$pList = [];
			$i = 0;
			if(isset($checkedPermissions))
			{
				foreach($checkedPermissions as $p1) 
				{
					$pList[] = $p1->name;
				}
			}
			foreach($allPermissions as $p) 
			{
				$checked = in_array($p->name, $pList) ? 'checked=checked' : "";
			?>
				
			<div class='col-md-12'>
			   <div class="checklist-items type-<?php echo $p->name;  ?>">
				   <div class="chechklist form-group col-md-10" >
						<label class='control-label'><?php echo $p->name;?> (<?php echo $p->description;?>)</label>
					</div>
					<div class="form-group col-md-2" >
						<div class="pretty p-switch p-pulse">
							<input type="checkbox" <?= $checked ?> name="Role[checkedPermissions][]" data-id="<?= $p->name;?>" id="check-<?= $i;?>" value="<?= $p->name;?>">
							<div class="state  p-primary">
								<label></label>
							</div>
						</div>
						
					</div>
				</div>
			</div>
		<?php
			$i++;
			}
			
		?>
		
		

		<div class="form-group text-right">
			<?= Html::a('<i class="fa fa-times"></i> Cancel', ['index'], ['class' => 'btn  btn-default  btn-lg']) ?>
			<?= Html::submitButton('<i class="fa fa-save"></i> Update Permissions', ['class' => 'btn btn-primary  btn-lg']) ?>
		</div>

    <?php ActiveForm::end(); ?>

</div>
