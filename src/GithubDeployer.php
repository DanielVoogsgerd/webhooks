<?php namespace Webhook;

use PHPGit\Git;

class GithubDeployer extends GithubWebhook {
	public function onPush($callback, $object = null) {
		$git = new Git();

		return parent::onPush($callback, $git);
	}
}
