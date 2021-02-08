<?php
/**
 * Created by PhpStorm
 * Author: Mumtoz Kodirov
 * Date: 07.02.2021
 * Time: 12:43
 */

namespace PhpSwaggerAutoTester;

class Schema
{
    protected $version = '2.0';
    protected $scheme = 'http';
    protected $host = '';
    protected $basePath = '';
    protected $paths = [];
    protected $definitions = [];

    public function __construct($filename = '')
    {
        if ($filename) {
            $this->loadFromJson($filename);
        }
    }

    public function loadFromJson($filename)
    {
        $schema = json_decode(file_get_contents($filename), true);

        $this->version = $schema->swagger;

        if (count($schema['schemes'])) {
            $this->scheme = $schema['schemes'][0];
        }

        if (isset($schema['host'])) {
            $this->host = $schema['host'];
        }

        if (isset($schema['basePath'])) {
            $this->basePath = $schema['basePath'];
        }

        if (isset($schema['paths'])) {
            $this->paths = $schema['paths'];
        }

        if (isset($schema['definitions'])) {
            $this->definitions = $schema['definitions'];
        }

        return $this;
    }

    public function usingScheme($scheme)
    {
        $this->scheme = $scheme;

        return $this;
    }

    public function usingVersion($version)
    {
        $this->version = $version;

        return $this;
    }

    public function usingHost($host)
    {
        $this->host = $host;

        return $this;
    }

    public function usingBasePath($basePath)
    {
        $this->basePath = $basePath;

        return $this;
    }

    public function getScheme()
    {
        return $this->scheme;
    }

    public function getHost()
    {
        return $this->host;
    }

    public function getBasePath()
    {
        return $this->basePath;
    }

    public function getPaths()
    {
        return $this->paths;
    }

    public function getDefinitions()
    {
        return $this->definitions;
    }
}