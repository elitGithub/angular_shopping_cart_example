<?php
/**
 * @var $this View
 */

/**
 * @var $model ContactForm
 */

use eligithub\phpmvc\Forms\Form;
use eligithub\phpmvc\Forms\TextAreaField;
use eligithub\phpmvc\View;
use App\Models\ContactForm;

$this->title = 'Contact';
echo '<h1>Contact Us</h1>';
$form = Form::begin('', 'post');
echo $form->field($model, 'subject');
echo $form->field($model, 'email');
echo new TextAreaField($model, 'body');
echo '<button type="submit" class="btn btn-primary">Submit</button>';
Form::end();