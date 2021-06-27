<?php

/**
 * @var $this View
 */

use eligithub\phpmvc\View;
$this->title = 'Profile';

?>
<h1>Profile</h1>
<form action="" method="post">
    <div class="form-group">
        <label for="subject">Subject</label>
        <input id="subject" type="text" name="subject" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" class="form-control" aria-describedby="emailHelp">
        <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
    </div>
    <div class="form-group">
        <label for="body">Body</label>
        <textarea id="body" name="body" class="form-control"></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>