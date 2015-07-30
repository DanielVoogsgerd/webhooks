<?php namespace Webhook;

interface WebhookInterface {

	public function __construct($payload, $signature);

	public function checkSignature($key);
    public function setSignature($signature);
    public function getSignature();
    public function setPayload($payload);
    public function getPayload();

	public function onPush($callback, $object = null);
}
