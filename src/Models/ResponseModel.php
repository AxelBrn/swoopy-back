<?php

namespace App\Models;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;


/**
 * @author Axel Brionne
 */
class ResponseModel extends Response
{
    private string $message;
    private $data;
    private Serializer $serializer;

    /**
     * ResponseModel Constructor
     * @param mixed $data
     * @param int $statusCode
     * @param string $message
     * @param string $status
     */
    public function __construct($data = null, ?int $statusCode = Response::HTTP_OK, string $message = "Successful request")
    {
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $this->serializer = new Serializer($normalizers, $encoders);
        $this->data = $data;
        $this->message = $message;
        parent::__construct(null, $statusCode);
        $this->setContent($this->toJson());
    }


    private function toJson()
    {
        $content = [
            'status' => $this->statusText,
            'statusCode' => $this->statusCode,
            'message' => $this->message,
        ];

        if ($this->data !== null) {
            $content['data'] = json_decode($this->serializer->serialize($this->data, 'json'));
        }

        return json_encode($content);
    }

    /**
     * Set the value of data
     *
     * @return  self
     */
    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }

    /**
     * Set the value of message
     *
     * @param  string  $message
     *
     * @return  self
     */
    public function setMessage(string $message)
    {
        $this->message = $message;
        return $this;
    }

    /**
     * Sends content for the current web response.
     *
     * @return $this
     */
    public function sendContent()
    {
        $this->setContent($this->toJson());
        return parent::sendContent();
    }
}
