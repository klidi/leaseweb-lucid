<?php
/**
 * Created by IntelliJ IDEA.
 * User: iraklid
 * Date: 31.10.20
 * Time: 11:11 AM
 */

namespace Framework\Http\Jobs;

use Illuminate\Routing\ResponseFactory;

class RespondWithJsonErrorJob
{
    public function __construct(string $message = 'An error occurred', int $code = 400, int $status = 400, array $headers = [], $options = 0)
    {
        $this->content = [
            'status' => $status,
            'error' => [
                'code' => $code,
                'message' => $message,
            ],
        ];

        $this->status = $status;
        $this->headers = $headers;
        $this->options = $options;
    }

    public function handle(ResponseFactory $response)
    {
        return $response->json($this->content, $this->status, $this->headers, $this->options);
    }
}
