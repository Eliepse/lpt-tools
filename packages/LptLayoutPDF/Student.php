<?php

namespace Eliepse\LptLayoutPDF;

/**
 * Class Student
 *
 * @package Eliepse\LptLayoutPDF
 */
final class Student implements \Serializable
{
	public ?string $firstname = null;
	public ?string $lastname = null;
	public ?string $fullname_cn = null;
	public ?string $born_at = null;
	public ?string $first_contact_wechat = null;
	public ?string $first_contact_phone = null;
	public ?string $second_contact_phone = null;
	public ?string $city_code = null;


	public function hydrate(array $params): void
	{
		$this->firstname = $params['firstname'];
		$this->lastname = $params['lastname'];
		$this->fullname_cn = $params['fullname_cn'];
		$this->born_at = $params['born_at'];
		$this->first_contact_wechat = $params['first_contact_wechat'];
		$this->first_contact_phone = $params['first_contact_phone'];
		$this->second_contact_phone = $params['second_contact_phone'];
		$this->city_code = $params['city_code'];
	}


	public function toArray(): array
	{
		return [
			'firstname' => $this->firstname,
			'lastname' => $this->lastname,
			'fullname_cn' => $this->fullname_cn,
			'born_at' => $this->born_at,
			'first_contact_wechat' => $this->first_contact_wechat,
			'first_contact_phone' => $this->first_contact_phone,
			'second_contact_phone' => $this->second_contact_phone,
			'city_code' => $this->city_code,
		];
	}


	public function serialize(): string
	{
		return serialize($this->toArray());
	}


	/**
	 * @param string $serialized
	 *
	 * @throws \Exception
	 */
	public function unserialize($serialized): void
	{
		$params = unserialize($serialized);

		if (!is_array($params)) {
			throw new \Exception("Cannot unserialize Student object, data should be an array.");
		}

		$this->hydrate($params);
	}
}