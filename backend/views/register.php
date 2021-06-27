<h1>Create an account</h1>
<?php

use eligithub\phpmvc\Forms\Form;
use App\Models\User;

/**
 * @var $model User
 */

$form = Form::begin('', 'post');
?>
<div class="row">
    <div class="col"><?php
		echo $form->field($model, 'first_name'); ?></div>
    <div class="col"><?php
		echo $form->field($model, 'last_name'); ?></div>
</div>
<?php
echo $form->field($model, 'email');
echo $form->field($model, 'password')->passwordField();
echo $form->field($model, 'confirm_password')->passwordField();
echo '<button type="submit" class="btn btn-primary">Submit</button>';
Form::end();
