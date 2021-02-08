<?php
/**
 * Created by PhpStorm
 * Author: Mumtoz Kodirov
 * Date: 07.02.2021
 * Time: 12:17
 */

namespace PhpSwaggerAutoTester;

class Tester
{
    protected $schema;
    protected $output;

    public function __construct()
    {
        $this->output = new \Codeception\Lib\Console\Output([]);
        $this->output->writeln(PHP_EOL);
    }

    public function usingSchema(Schema $schema)
    {
        $this->schema = $schema;

        return $this;
    }

    public function runTests()
    {
        foreach ($this->schema->getPaths() as $path => $methods) {
            foreach ($methods as $method => $schema) {
                $this->output->writeln('===');
                $this->{$method . 'Test'}($path, $schema);
            }
        }
    }

    public function getTest($path, $schema)
    {
        $url = $this->schema->getScheme() . '://' . $this->schema->getHost() . $this->schema->getBasePath() . $path;

        $parameters = [];
        foreach ($schema['parameters'] as $parameter) {
            if ($parameter->in === 'query') {
                if (in_array($parameter->type, ['integer', 'long', 'float', 'double', 'byte', 'boolean']))
                    $parameters[$parameter->name] = 0;
                else if (in_array($parameter->type, ['string', 'password']))
                    $parameters[$parameter->name] = '';
            }
        }

        if ($parameters) {
            $url .= '?' . http_build_query($parameters);
        }

        echo 'testing GET ' . $path . PHP_EOL;

//        $this->actor->sendGet($url);
//        $this->output->writeln('✓ GET: ' . $path);
//
//        $this->actor->seeResponseCodeIs(200);
//        $this->output->writeln('✓ CODE IS 200');
//
//        $this->actor->seeResponseIsJson();
//        $this->output->writeln('✓ RESPONSE IS JSON');
    }

    public function postTest($path, $schema)
    {
//        $url = $this->schema->getScheme() . '://' . $this->schema->getHost() . $this->schema->getBasePath() . $path;
//
//        $parameters = [];
//        foreach ($schema->parameters as $parameter) {
//            if ($parameter->in === 'query') {
//                if (in_array($parameter->type, ['integer', 'long', 'float', 'double', 'byte', 'boolean']))
//                    $parameters[$parameter->name] = 0;
//                else if (in_array($parameter->type, ['string', 'password']))
//                    $parameters[$parameter->name] = '';
//            }
//        }
//
//        if ($parameters) {
//            $url .= '?' . http_build_query($parameters);
//        }
//
//        $this->actor->sendPost($url);
//        $this->output->writeln('✓ POST: ' . $path);
//
//        $this->actor->seeResponseCodeIs(200);
//        $this->output->writeln('✓ CODE IS 200');
//
//        $this->actor->seeResponseIsJson();
//        $this->output->writeln('✓ RESPONSE IS JSON');
    }

    public function putTest($path, $schema)
    {
//        $this->actor->wantTo('Test ' . $path . ' with PUT');
    }

    public function deleteTest($path, $schema)
    {
//        $this->actor->wantTo('Test ' . $path . ' with DELETE');
    }
}