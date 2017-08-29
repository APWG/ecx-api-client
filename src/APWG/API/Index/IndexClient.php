<?php

namespace APWG\API\Index;

use APWG\API\AbstractClient;
use Psr\Http\Message\ResponseInterface;

/**
 * Interact with the Index API
 *
 * Class IndexClient
 * @package APWG\API\Index
 * @author Andrew Breksa <andrew@apwg.org>
 * @copyright Copyright (c) 2017 The Anti-Phishing Working Group
 */
class IndexClient extends AbstractClient {

	/**
	 * Returns the Swagger 2.0 YAML definition
	 *
	 * @return ResponseInterface
	 */
	public function getSpec() {
		return $this->_call('get', '/spec', []);
	}

	/**
	 * Returns the '/' index content of the API, a list of available modules, groups, and utilities
	 *
	 * @return ResponseInterface
	 */
	public function getIndex() {
		return $this->_call('get', '/', []);
	}
}