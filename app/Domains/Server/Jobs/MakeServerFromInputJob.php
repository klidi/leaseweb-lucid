<?php

namespace Framework\Domains\Server\Jobs;

use Framework\Data\Collections\RamModules;
use Framework\Data\ValueObjects\Price;
use Illuminate\Support\Facades\Auth;
use Framework\Data\Server;
use Lucid\Foundation\Job;
use Framework\Data\User;

class MakeServerFromInputJob extends Job
{
    private int $assetId;
    private string $name;
    private int $brandId;
    private Price $price;
    private RamModules $ramModules;
    private User $user;


    /**
     * MakeServerFromInputJob constructor.
     * @param int $assetId
     * @param string $name
     * @param int $brandId
     * @param Price $price
     * @param RamModules $ramModules
     */
    public function __construct(int $assetId, string $name, int $brandId, Price $price, RamModules $ramModules)
    {
        $this->assetId = $assetId;
        $this->name    = $name;
        $this->brandId = $brandId;
        $this->price   = $price;
        $this->ramModules = $ramModules;
        $this->user = Auth::user();
    }

    /**
     * Execute the job
     *
     * @return Server
     */
    public function handle() : Server
    {
        $server = new Server();
        $server->asset_id  = $this->assetId;
        $server->user_id   = $this->user->id;
        $server->name      = $this->name;
        $server->brand_id  = $this->brandId;
        $server->price     = $this->price;
        $server->ram_modules = $this->ramModules;
        $server->save();
        return $server;
    }
}
