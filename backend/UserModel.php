<?php


namespace App;


use App\DB\DbModel;

abstract class UserModel extends DbModel
{
	abstract public function getDisplayName(): string;
	abstract public function getRole(): string;

}