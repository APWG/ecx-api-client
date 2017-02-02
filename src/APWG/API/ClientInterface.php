<?php
namespace APWG\API;

use Psr\Http\Message\ResponseInterface;

/**
 * The API module client interface
 *
 * Interface ClientInterface
 * @package APWG\API
 * @author Andrew Breksa
 * @copyright Copyright (c) 2016. The Anti-Phishing Working Group
 */
interface ClientInterface {

    /**
	 * Internal method to call the API
	 *
     * @param $method
     * @param string $path the endpoint path relative to the base_uri
     * @param array $options the request (Guzzle) options
     * @return ResponseInterface
     */
    public function _call($method, $path, $options = []);

    /**
	 * Get the most recent request
	 *
     * @return ResponseInterface
     */
    public function getCache();

    /**
	 * Set the most recent request
	 *
     * @param ResponseInterface
     * $cache
     */
    public function setCache($cache);

}