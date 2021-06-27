<?php


namespace App\Models;


use eligithub\phpmvc\Model;

class ContactForm extends Model
{
	public string $subject = '';
	public string $email = '';
	public string $body = '';

	public function rules(): array
	{
		return [
			'subject' => [static::RULE_REQUIRED],
			'email'   => [static::RULE_REQUIRED, static::RULE_EMAIL],
			'body'    => [static::RULE_REQUIRED],
		];
	}

	public function send()
	{
		return true;
	}

	public function labels(): array
	{
		return [
			'subject' => 'Enter Subject',
			'email'   => 'Your Email',
			'body'    => 'Contents',
		];
	}
}