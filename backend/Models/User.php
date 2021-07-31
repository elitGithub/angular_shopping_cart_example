<?php

namespace App\Models;

use App\Exceptions\UserNotFoundException;
use App\Helpers\PlaceHolders;
use App\UserModel;
use Exception;
use PDO;
use ReallySimpleJWT\Token;

/**
 * Class User
 * @package App\Models
 */
class User extends UserModel
{
    public const STATUS_INACTIVE = 'inactive';
    public const STATUS_ACTIVE = 'active';

    public int $id = 0;
    public string $first_name = '';
    public string $last_name = '';
    public string $email = '';
    public string $password = '';
    public string $status = self::STATUS_ACTIVE;
    public int $deleted = self::NOT_DELETED;
    public string $confirm_password = '';

    public function save(): bool
    {
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        $this->status = static::STATUS_ACTIVE;
        return parent::save();
    }

    public function rules(): array
    {
        // TODO: REGEX the hell out of the username.
        return [
            'username'         => [
                static::RULE_REQUIRED,
                [static::RULE_UNIQUE, 'class' => static::class],
            ],
            'first_name'       => [static::RULE_REQUIRED],
            'last_name'        => [static::RULE_REQUIRED],
            'email'            => [
                static::RULE_REQUIRED,
                static::RULE_EMAIL,
                [static::RULE_UNIQUE, 'class' => static::class],
            ],
            'password'         => [
                static::RULE_REQUIRED,
                [static::RULE_MIN, static::RULE_MIN => 8],
                [static::RULE_MAX, static::RULE_MAX => 24],
            ],
            'confirm_password' => [static::RULE_REQUIRED, [static::RULE_MATCH, static::RULE_MATCH => 'password']],
        ];
    }

    public static function getToken()
    {
        return $_SESSION['token'];
    }

    public static function generateJwt($userId): bool|string
    {
        try {
            $expiration = time() + 3600;
            $issuer = 'localhost';

            return Token::create($userId, $_ENV['SECRET_KEY'], $expiration, $issuer);
        } catch (Exception $e) {
            echo $e->getCode() . PHP_EOL;
            echo $e->getMessage() . PHP_EOL;
            return false;
        }
    }

    public function delete($id)
    {
        $userData = static::findOne([static::primaryKey() => $id]);
        $userData->status = static::STATUS_INACTIVE;
        $userData->deleted = static::DELETED;
        $this->loadData($userData);
        $this->save();
    }

    public function deactivcate($id)
    {
        $userData = static::findOne([static::primaryKey() => $id]);
        $userData->status = static::STATUS_INACTIVE;
        $this->loadData($userData);
        $this->save();
    }

    public static function tableName(): string
    {
        return 'users';
    }

    public function attributes(): array
    {
        // TODO: read the table schema and get the column names from there, then get the columns as attributes
        // This should create a model of the table - just like an ORM
        return ['id', 'username', 'first_name', 'last_name', 'email', 'password', 'status', 'role_id', 'deleted'];
    }

    public function labels(): array
    {
        return [
            'username'         => 'User Name',
            'first_name'       => 'First Name',
            'last_name'        => 'Last Name',
            'email'            => 'Email',
            'password'         => 'Password',
            'confirm_password' => 'Confirm Password',
            'role'             => 'Role',
        ];
    }

    public static function primaryKey(): string
    {
        return 'id';
    }

    public function getDisplayName(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getRole(): string
    {
        return Role::findByUser($this->{static::primaryKey()})->name;
    }

    public function findByUserName()
    {
        if (empty($this->username)) {
            throw new UserNotFoundException();
        }

        $sql = "SELECT * FROM " . static::tableName() . " WHERE username = ?";
        $stmt = static::prepare($sql);
        $stmt->bindParam(1, $this->username);
        $stmt->execute();
        $this->loadData($stmt->fetch(PDO::FETCH_ASSOC));
    }

    public function fillable(): array
    {
        return ['username', 'first_name', 'last_name', 'email', 'password', 'status', 'role_id', 'deleted'];
    }

    public function info(): array
    {
        return [
            'username'     => $this->username,
            'display_name' => $this->getDisplayName(),
            'role'         => $this->getRole(),
            'user_image'   => $this->user_image ?? PlaceHolders::AVATAR_PLACEHOLDER,
            'description'  => $this->description ?? '',
        ];
    }
}