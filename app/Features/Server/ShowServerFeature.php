<?php

namespace Framework\Features\Server;

use Framework\Http\Jobs\RespondWithJsonJob;
use Framework\Http\Resources\Server as ServerResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;
use Lucid\Foundation\Feature;
use Framework\Data\Server;

class ShowServerFeature extends Feature
{
    private Server $server;

    /**
     * ShowServerFeature constructor.
     * @param Server $server
     */
    public function __construct(Server $server)
    {
        $this->server = $server;
    }

    /**
     * @return string
     */
    public function handle() : JsonResponse
    {
        if (Gate::authorize('owns-resource', $this->server))
        {
            return $this->run(new RespondWithJsonJob(new ServerResource($this->server), 200));
        }
    }
}
