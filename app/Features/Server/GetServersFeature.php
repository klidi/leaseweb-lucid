<?php

namespace Framework\Features\Server;

use Framework\Data\User;
use Framework\Http\Jobs\RespondWithJsonJob;
use Framework\Http\Resources\ServerCollection;
use Illuminate\Http\JsonResponse;
use Lucid\Foundation\Feature;

class GetServersFeature extends Feature
{
    private User $user;
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function handle() : JsonResponse
    {
        return $this->run( new RespondWithJsonJob(new ServerCollection($this->user->servers()->paginate(10))));
    }
}
