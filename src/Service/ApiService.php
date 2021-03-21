<?php

namespace App\Service;

use GuzzleHttp\ClientInterface;
use Psr\Log\LoggerInterface;

/**
 * Class ApiService
 * @package App\Service
 */
class ApiService
{
    /** @var ClientInterface */
    private $guzzle;

    /** @var LoggerInterface */
    private $logger;

    /**
     * ApiService constructor.
     * @param ClientInterface $guzzle
     * @param LoggerInterface $logger
     */
    public function __construct(ClientInterface $guzzle, LoggerInterface $logger)
    {
        $this->guzzle = $guzzle;
        $this->logger = $logger;
    }

    /**
     * @return bool|mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getAllClassRoom()
    {
        try {
            $response = $this->guzzle->request("GET", "/api/class_rooms");

            return json_decode($response->getBody()->getContents(), true);
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());

            return false;
        }
    }

    /**
     * @param $id
     * @return bool|mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getClass($id)
    {
        try {
            $response = $this->guzzle->request("GET", "/api/class_rooms/{$id}");

            return json_decode($response->getBody()->getContents(), true);
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());

            return false;
        }
    }

    /**
     * @param $id
     * @return bool|mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function removeClass($id)
    {
        try {
            $response = $this->guzzle->request("DELETE", "/api/class_rooms/{$id}");

            return json_decode($response->getBody()->getContents(), true);
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());

            return false;
        }
    }

    /**
     * @param $id
     * @param $active
     * @return bool|mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function changeClassRoomActive($id, $active)
    {
        try {
            $response = $this->guzzle->request("PATCH", "/api/change-active/{$id}", [
                "body" => json_encode(compact('active')),
                "headers" => ["Content-Type" => "application/merge-patch+json"]
            ]);

            return  json_decode($response->getBody()->getContents(), true);
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());

            return false;
        }
    }
}
