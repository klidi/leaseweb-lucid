<?php
/**
 * Created by IntelliJ IDEA.
 * User: iraklid
 * Date: 31.10.20
 * Time: 8:50 PM
 */

namespace Framework\Http\Controllers;

use Framework\Features\Server\DeleteServerFeature;
use Framework\Features\Server\CreateServerFeature;
use Framework\Features\Server\GetServersFeature;
use Framework\Features\Server\ShowServerFeature;
use Illuminate\Http\JsonResponse;
use Lucid\Foundation\Http\Controller;
use Illuminate\Http\Request;
use Framework\Data\Server;
use Framework\Data\User;

class ServerController extends Controller
{

    public function index(User $user) : JsonResponse
    {
        return $this->serve(GetServersFeature::class, [
            'user' => $user
        ]);
    }

    /**
     * @param Request $request
     * @return Server
     */
    public function store(Request $request) : JsonResponse
    {
        return $this->serve(CreateServerFeature::class, [
            'request' => $request,
        ]);
    }

    /**
     * @param User $user
     * @param Server $server
     * @return Server
     */
    public function show(User $user, Server $server) : JsonResponse
    {
        return $this->serve(ShowServerFeature::class, [
            'server' => $server,
        ]);
    }

    public function delete(User $user, Server $server) : JsonResponse
    {
        return $this->serve(DeleteServerFeature::class, [
            'server' => $server,
        ]);
    }

}
