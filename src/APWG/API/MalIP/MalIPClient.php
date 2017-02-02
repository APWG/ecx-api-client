<?php
namespace APWG\API\MalIP;

use APWG\API\AbstractClient;
use Psr\Http\Message\ResponseInterface;

/**
 * Interact with the Mal_IP API module
 *
 * Class MalIPClient
 * @package APWG\API\MalIP
 * @author Andrew Breksa
 * @copyright Copyright (c) 2016. The Anti-Phishing Working Group
 */
class MalIPClient extends AbstractClient {

    /**
     * Searches the mal_ip module
     *
     * @param array $options an associative array of query parameters
     * @return ResponseInterface
     */
    public function search($options = []) {
        return $this->_call('get', 'mal_ip', [
            'query' => $options
        ]);
    }

    /**
     * Gets a specific phish
     *
     * @param int $id the mal_ip id
     * @param array $options an associative array of query parameters
     * @return ResponseInterface
     */
    public function get($id, $options = []) {
        return $this->_call('get', 'mal_ip/' . $id, [
            'query' => $options
        ]);
    }

    /**
     * Checks that a mal_ip by that ID exists and returns a last-modified header
     *
     * @param int $id the mal_ip id
     * @return ResponseInterface
     */
    public function head($id) {
        return $this->_call('head', 'mal_ip/' . $id);
    }

    /**
     * Submits a new mal_ip entry
     *
     * @param array $data an associative array of mal_ip data
     * @param array $options an associative array of query parameters
     * @return ResponseInterface
     */
    public function create($data, $options = []) {
        return $this->_call('post', 'mal_ip', [
            'json' => $data,
            'query' => $options
        ]);
    }

    /**
     * Tag yourself as a collaborator for a entity
     *
     * @param int $id
     *
     * @return ResponseInterface
     */
    public function collaborate($id) {
        return $this->_call('post', 'mal_ip/' . $id . '/collaborate', []);
    }

    /**
     * Search your collaborations for this module
     *
     * @param array $options
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function collaborations($options = []) {
        return $this->_call('get', 'mal_ip/collaborate', [
            'query' => $options,
        ]);
    }

    /**
     * Remove yourself as a collaborator from a entity
     *
     * @param int $id
     *
     * @return ResponseInterface
     */
    public function removeCollaboration($id) {
        return $this->_call('delete', 'mal_ip/' . $id . '/collaborate', []);
    }

    /**
     * View your collaboration entry for a specific entity
     *
     * @param int $id
     * @return ResponseInterface
     */
    public function collaboration($id) {
        return $this->_call('get', 'mal_ip/' . $id . '/collaborate', []);
    }

	/**
     * Search this modules submitted brands 
     * 
     * @param array $options
     *
     * @return ResponseInterface
     */
    public function brands($options = []) {
        return $this->_call('get', 'mal_ip/brands', [
            'query' => $options,
        ]);
    }

    /**
     * Get a Last-Modified header with the timestamp of the last collaboration activity for a specific entity
     *
     * @param int $id
     * @return ResponseInterface
     */
    public function lastCollaboration($id) {
        return $this->_call('head', 'mal_ip/' . $id . '/collaborate', []);
    }

}