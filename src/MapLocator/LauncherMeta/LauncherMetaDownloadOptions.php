<?php

namespace Aternos\Sherlock\MapLocator\LauncherMeta;

class LauncherMetaDownloadOptions
{
    protected LauncherMetaFile $client;
    protected ?LauncherMetaFile $client_mappings = null;
    protected LauncherMetaFile $server;
    protected ?LauncherMetaFile $server_mappings = null;

    public function __construct($data)
    {
        $this->client = new LauncherMetaFile($data->client);
        if (isset($data->client_mappings)) {
            $this->client_mappings = new LauncherMetaFile($data->client_mappings);
        }
        $this->server = new LauncherMetaFile($data->server);
        if (isset($data->server_mappings)) {
            $this->server_mappings = new LauncherMetaFile($data->server_mappings);
        }
    }

    /**
     * @param string $type server or client
     * @return ?LauncherMetaFile
     */
    public function getMappings(string $type): ?LauncherMetaFile
    {
        return match ($type) {
            "server", "server_mappings" => $this->server_mappings,
            "client", "client_mappings" => $this->client_mappings,
            default => throw new \InvalidArgumentException("Invalid type $type, must be 'client' or 'server'"),
        };
    }
}