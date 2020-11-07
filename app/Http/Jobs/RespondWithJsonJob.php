<?php
/**
 * Created by IntelliJ IDEA.
 * User: iraklid
 * Date: 31.10.20
 * Time: 11:12 AM
 */

namespace Framework\Http\Jobs;


use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Routing\ResponseFactory;

class RespondWithJsonJob
{
    public function __construct($content, $status = 200, array $headers = [], $options = 0)
    {
        $this->content = $content;
        $this->status = $status;
        $this->headers = $headers;
        $this->options = $options;
    }

    public function handle(ResponseFactory $factory) : string
    {
        $response = [
            'data' => $this->content,
            'status' => $this->status,
        ];

        return $factory->json($response, $this->status, $this->headers, $this->options);
    }
}
