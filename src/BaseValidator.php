<?php
declare(strict_types=1);

namespace validator;


use Database\Model;
use Exception;

abstract class BaseValidator
{

	public string $field = '';

	public array $rules = [];

	public string $method;

	protected bool $isFail = TRUE;

	protected string $message = '';

	protected array $params = [];

	protected ?Model $model = null;


	/**
	 * @param $model
	 */
	public function setModel($model)
	{
		$this->model = $model;
	}

	/**
	 * @return Model|null
	 */
	public function getModel(): ?Model
	{
		return $this->model;
	}


	/**
	 * BaseValidator constructor.
	 * @param array $config
	 */
	public function __construct(array $config = [])
	{
		$this->regConfig($config);
	}


	/**
	 * @param $config
	 */
	private function regConfig($config)
	{
		if (empty($config) || !is_array($config)) {
			return;
		}
		foreach ($config as $key => $val) {
			$this->$key = $val;
		}
	}

	/**
	 * @return bool
	 * @throws Exception
	 */
	public function trigger(): bool
	{
		throw new Exception('Child Class must define method of trigger');
	}

	/**
	 * @return array
	 */
	protected function getParams(): array
	{
		return $this->params;
	}

	/**
	 * @param array|null $data
	 * @return $this
	 */
	public function setParams(?array $data): static
	{
		if (is_null($data)) {
			$data = [];
		}
		$this->params = $data;
		return $this;
	}

	/**
	 * @param $message
	 * @return bool
	 */
	public function addError($message): bool
	{
		$this->isFail = FALSE;

		$message = str_replace(':attribute', $this->field, $message);

		$this->message = $message;

		return $this->isFail;
	}

	/**
	 * @return string
	 */
	public function getError(): string
	{
		return $this->message;
	}

	/**
	 * @param $name
	 * @param $value
	 * @throws Exception
	 */
	public function __set($name, $value)
	{
		$method = 'set' . ucfirst($name);
		if (method_exists($this, $method)) {
			$this->$method($value);
		} else if (property_exists($this, $name)) {
			$this->$name = $value;
		} else {
			throw new Exception('unknown property ' . $name . ' in class ' . static::class);
		}
	}
}
