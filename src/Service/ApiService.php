<?php

namespace App\Service;

use App\Repository\ClassRoomRepository;
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

    /** @var ClassRoomRepository */
    private $repository;

    /**
     * ApiService constructor.
     * @param ClientInterface $guzzle
     * @param LoggerInterface $logger
     * @param ClassRoomRepository $repository
     */
    public function __construct(ClientInterface $guzzle, LoggerInterface $logger, ClassRoomRepository $repository)
    {
        $this->guzzle = $guzzle;
        $this->logger = $logger;
        $this->repository = $repository;
    }

    /**
     * @return bool|mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getAllClassRoom()
    {
        return $this->sendRequest("GET", "/api/class_rooms");
    }

    /**
     * @param $id
     * @return bool|mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getClass($id)
    {
        return $this->sendRequest("GET", "/api/class_rooms/{$id}");
    }

    /**
     * @param $apiSchema
     * @return bool|mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function createClassRoom($apiSchema)
    {
        $headers = [
            'Content-Type' => 'application/json'
        ];
        $body = json_encode($apiSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

        return $this->sendRequest("POST", "/api/class_rooms", compact('headers', 'body'));
    }

    /**
     * @param $id
     * @param $apiSchema
     * @return bool|mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function editClassRoom($id, $apiSchema)
    {
        $headers = [
            'Content-Type' => 'application/json'
        ];
        $body = json_encode($apiSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

        return $this->sendRequest("PUT", "/api/class_rooms/{$id}", compact('headers', 'body'));
    }

    /**
     * @param $id
     * @return bool|mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function removeClass($id)
    {
        return $this->sendRequest("DELETE", "/api/class_rooms/{$id}");
    }

    /**
     * @param $id
     * @param $active
     * @return bool|mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function changeClassRoomActive($id, $active)
    {
        $entity = $this->repository->findOneById($id);
        $headers = ["Content-Type" => "application/merge-patch+json"];
        $activeChange = [
            "class" => $entity->getClass(),
            "created" => $entity->getCreated()->format('Y-m-d H:i:s'),
            "active"=> $active
        ];

        $body = json_encode($activeChange, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

        return $this->sendRequest("PATCH", "/api/class_rooms/{$id}", compact('headers', 'body'));
    }

    /**
     * @param $method
     * @param $uri
     * @param array $options
     * @return bool|mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function sendRequest($method, $uri, $options = [])
    {
        try {
            $response = $this->guzzle->request($method, $uri, $options);

            return  json_decode($response->getBody()->getContents(), true);
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());

            return false;
        }
    }
}
