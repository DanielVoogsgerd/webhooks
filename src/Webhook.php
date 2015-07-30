<?php namespace Webhook;

use Exception;
use InvalidArgumentException;

abstract class Webhook {

	private $payload;
	private $rawpayload;
	private $signature;

	/**
	 * @param string|array|object $payload
	 * @param $signature
	 */
	public function __construct($payload, $signature, $key = null) {
		$this->setSignature($signature);

		if($key !== null && !$this->checkSignature($payload, $key))
			throw new Exception('Signature did not match payload content');

		$this->setPayload($payload);
	}

	/**
	 * @param string $payload
	 * @param string $key
	 * @return bool
	 */
	public function checkSignature($key) {
		$signature = $this->generateSignature($this->rawPayload, $key);

		return $this->signature === $signature;
	}

	/**
	 * @param string $payload
	 * @param string $key
	 * @return string
	 */
	abstract protected function generateSignature($payload, $key);

	/**
	 * @param \closure $callback
	 * @return mixed
	 */
	public function onPush($callback, $object = null) {
		return $callback($this->payload, $this, $object);
	}

	/* Getters and Setters */
	/**
	 * @param string $signature
	 */
	public function setSignature($signature) {
		if(!is_string($signature))
			throw new InvalidArgumentException('Signature is not a string');

		// Make sure the signature is lowercase
		$signature = strtolower($signature);

		$this->signature = $signature;
	}

	/**
	 * @return string
	 */
	public function getSignature() {
		return (string) $this->signature;
	}

	/**
	 * @param string|array|object payload
	 * @throws Exception if payload isn't the right format
	 */
	public function setPayload($payload) {
		$this->rawPayload = $payload;

		if(is_string($payload)) {
			$payload = json_decode($payload);

			if($payload === false)
				throw new InvalidArgumentException('Payload is not a valid json object');
		} else
			throw new InvalidArgumentException('Payload is not of a valid type');


		$this->payload = (object) $payload;
	}

	/**
	 * @return object
	 */
	public function getPayload() {
		return (object) $this->payload;
	}
}