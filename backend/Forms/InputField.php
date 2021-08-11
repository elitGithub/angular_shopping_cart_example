<?php


namespace App\Forms;

use App\Application;
use App\Helpers\PermissionsManager;
use App\Model;
use App\Models\User;

class InputField extends BaseField
{
	public const TYPE_TEXT = 'text';
	public const TYPE_PASSWORD = 'password';
	public const TYPE_NUMBER = 'number';
	protected string $type;


	public function __construct(Model $model, string $attribute)
	{
		$this->setType(static::TYPE_TEXT);
		parent::__construct($model, $attribute);
	}

	public function label($fieldName) {
	    $stripUnder = str_replace('_', ' ', $fieldName);
	    return ucfirst($stripUnder);
    }

    /**
     * @param  string  $type
     *
     * @return InputField
     */
	public function setType(string $type): InputField
	{
		$this->type = $type;
		return $this;
	}

	/**
	 * @return $this
	 */
	public function passwordField(): static
	{
		$this->setType(static::TYPE_PASSWORD);
		return $this;
	}


	public function renderInput(): string
	{
		return sprintf('
				<input id="%s" type="%s" name="%s" value="%s" class="form-control %s">',
			$this->attribute,
			$this->type,
			$this->attribute,
			$this->model->{$this->attribute},
			$this->model->hasError($this->attribute) ? ' is-invalid' : '');
	}

    public function permission(string $field)
    {
        return PermissionsManager::fieldPermissions($field);
    }
}