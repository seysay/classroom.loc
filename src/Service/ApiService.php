<?php

namespace App\Service;

use App\Entity\ClassRoom;
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
        try {
            $response = $this->guzzle->request("POST", "/api/class_rooms", compact('headers', 'body'));

            return json_decode($response->getBody()->getContents(), true);
        } catch (\Exception $e) {
            dd($e);
            $this->logger->error($e->getMessage());

            return false;
        }
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
        try {
            $response = $this->guzzle->request("PUT", "/api/class_rooms/{$id}", compact('headers', 'body'));

            return json_decode($response->getBody()->getContents(), true);
        } catch (\Exception $e) {
            dd($e);
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
        $entity = $this->repository->findOneById($id);
        $headers = ["Content-Type" => "application/merge-patch+json"];
        $activeChange = [
            "class" => $entity->getClass(),
            "created" => $entity->getCreated()->format('Y-m-d H:i:s'),
            "active"=> $active
        ];

        $body = json_encode($activeChange, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

        try {
            $response = $this->guzzle->request("PATCH", "/api/class_rooms/{$id}", compact('headers', 'body'));

            return  json_decode($response->getBody()->getContents(), true);
        } catch (\Exception $e) {
            dd($e);
            $this->logger->error($e->getMessage());

            return false;
        }
    }
}
