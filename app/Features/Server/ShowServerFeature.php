<?php

namespace Framework\Features\Server;

use Framework\Http\Resources\Server as ServerResource;
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
    public function handle() : string
    {
        if (Gate::authorize('owns-resource', $this->server))
        {
            return new ServerResource($this->server);
        }
    }
}
