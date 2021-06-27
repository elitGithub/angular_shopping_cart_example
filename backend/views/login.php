<h1>Login </h1>
<?php

use eligithub\phpmvc\Forms\Form;
use App\Models\LoginForm;


/**
 * @var $model LoginForm
 */

$form = Form::begin('', 'post');

echo $form->field($model, 'email');
echo $form->field($model, 'password')->passwordField();
echo '<button type="submit" class="btn btn-primary">Submit</button>';
Form::end();
