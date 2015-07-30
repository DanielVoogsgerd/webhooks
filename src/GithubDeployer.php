<?php namespace Webhook;

class GithubDeployer extends Deployer implements WebhookInterface {
	protected static $hash = 'sha1';

	/* Helper functions */
	/**
	 * @return string
	 */
	public static function fetchSignature() {
		return (string) $_SERVER['HTTP_X_HUB_SIGNATURE'];
	}

	public static function fetchPayload() {
		return (string) file_get_contents( 'php://input' );
	}

	public static function fetchEvent() {
		return (string) $_SERVER['HTTP_X_GITHUB_EVENT'];
	}


	/* Private functionality */
	/**
	 * @param $signature
	 * @return bool
	 */
	protected function validateSignature($signature) {
		return (bool) preg_match('/[0-9a-z]{40}/', $signature);
	}

	/**
	 * @param string $data
	 * @param string $key
	 * @return string
	 */
	protected function generateSignature($data, $key) {
		return (string) 'sha1=' . hash_hmac(self::$hash, $data, $key, false);
	}

}
