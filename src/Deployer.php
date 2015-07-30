<?php namespace Webhook;

use PHPGit\Git;

abstract class Deployer extends Webhook {
	public function onPush($callback, $object = null) {
		$git = new Git();

		return parent::onPush($callback, $git);
	}
}
