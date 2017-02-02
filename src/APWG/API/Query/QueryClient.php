<?php
namespace APWG\API\Query;

use APWG\API\AbstractClient;
use Psr\Http\Message\ResponseInterface;

/**
 * Interact with the Query API module
 *
 * Class QueryClient
 * @package APWG\API\Query
 * @author Andrew Breksa
 * @copyright Copyright (c) 2016. The Anti-Phishing Working Group
 */
class QueryClient extends AbstractClient {

    /**
     * Search across all available modules
     *
     * @param array $options an associative array of query parameters
     * @return ResponseInterface
     */
    public function search($options = []) {
        return $this->_call('get', 'query', [
            'query' => $options
        ]);
    }
}