<?php

use PhpSwaggerAutoTester\Schema;

class ApiCest
{
    protected $schema;

    public function __construct()
    {
        $this->schema = new Schema();
        $this->schema->loadFromJson(__DIR__ . '/_data/swagger.json');

        $this->output = new \Codeception\Lib\Console\Output([]);
    }

    /**
     * @dataProvider _scenarios
     */
    public function testAction(ApiTester $I, \Codeception\Example $data)
    {
        $this->output->writeln('');

        if ($data['method'] === 'GET') {
            $this->_testGet($I, $data['path'], $data['schema']);
        } else if ($data['method'] === 'POST') {
            $this->_testPost($I, $data['path'], $data['schema']);
        }
    }

    public function _scenarios()
    {
        $actions = [];

        foreach ($this->schema->getPaths() as $path => $methods) {
            foreach ($methods as $method => $schema) {
                $actions[] = ['method' => strtoupper($method), 'path' => $path, 'schema' => $schema];
            }
        }

        return $actions;
    }

    /**
     * @doesNotPerformAssertions
     */
    public function _testGet(ApiTester $I, $path, $schema)
    {
        $url = $this->schema->getScheme() . '://' . $this->schema->getHost() . $this->schema->getBasePath() . $path;

//        $parameters = [];
//        foreach ($schema['parameters'] as $parameter) {
//            if ($parameter['in'] === 'query') {
//                if (in_array($parameter['type'], ['integer', 'long', 'float', 'double', 'byte', 'boolean']))
//                    $parameters[$parameter['name']] = 0;
//                else if (in_array($parameter['type'], ['string', 'password']))
//                    $parameters[$parameter['name']] = '';
//            }
//        }
//
//        if ($parameters) {
//            $url .= '?' . http_build_query($parameters);
//        }

        $I->sendGet($url);
        $this->output->writeln('GET ' . $path);

        $I->seeResponseCodeIs(200);
        $this->output->writeln('RESPONSE CODE IS 200');

        $I->seeResponseIsJson();
        $this->output->writeln('RESPONSE IS JSON');

        $I->seeResponseIsValidOnJsonSchema(__DIR__ . '/_data/swagger.json');
        $this->output->writeln('RESPONSE IS VALID');
    }

    /**
     * @doesNotPerformAssertions
     */
    public function _testPost(ApiTester $I, $path, $schema)
    {
        $url = $this->schema->getScheme() . '://' . $this->schema->getHost() . $this->schema->getBasePath() . $path;

//        $parameters = [];
//        foreach ($schema['parameters'] as $parameter) {
//            if ($parameter['in'] === 'query') {
//                if (in_array($parameter['type'], ['integer', 'long', 'float', 'double', 'byte', 'boolean']))
//                    $parameters[$parameter['name']] = 0;
//                else if (in_array($parameter['type'], ['string', 'password']))
//                    $parameters[$parameter['name']] = '';
//            }
//        }
//
//        if ($parameters) {
//            $url .= '?' . http_build_query($parameters);
//        }

        $I->sendPost($url);
        $this->output->writeln('POST ' . $path);

        $I->seeResponseCodeIs(201);
        $this->output->writeln('RESPONSE CODE IS 403');

        $I->seeResponseIsJson();
        $this->output->writeln('RESPONSE IS JSON');

        $I->seeResponseIsValidOnJsonSchema();
        $this->output->writeln('RESPONSE IS VALID JSON');
    }
}
