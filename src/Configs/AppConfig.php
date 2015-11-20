<?php

namespace Inkl\Core\Configs;

use Psr\Http\Message\ServerRequestInterface;
use Symfony\Component\Filesystem\Filesystem;

class AppConfig {

	private $theme = 'base';

	/** @var */
	private $filesystem;
	/** @var ServerRequestInterface */
	private $serverRequest;

	/**
	 * Enviroment constructor.
	 * @param ServerRequestInterface $serverRequest
	 * @param Filesystem $filesystem
	 */
	public function __construct(ServerRequestInterface $serverRequest, Filesystem $filesystem) {

		$this->filesystem = $filesystem;
		$this->serverRequest = $serverRequest;
	}


	public function setTheme($theme) {
		$this->theme = $theme;
		return $this;
	}

	public function getTheme() {
		return $this->theme;
	}


	public function getBaseUrl() {

		$uri = $this->serverRequest->getUri();

		return sprintf('%s://%s', $uri->getScheme(), $uri->getHost());
	}



	public function getRootPath() {
		return realpath(__DIR__ . '/../../../../../');
	}


	public function getPublicPath() {
		return $this->getRootPath() . '/public';
	}

	public function getModulePath() {
		return $this->getRootPath() . '/src';
	}


	public function getLogPath() {
		return $this->createPath($this->getRootPath() . '/var/log');
	}


	public function getCachePath() {
		return $this->createPath($this->getRootPath() . '/var/cache');
	}


	protected function createPath($path) {

		if (!is_dir($path)) {
			$this->filesystem->mkdir($path);
		}

		return $path;
	}

}
