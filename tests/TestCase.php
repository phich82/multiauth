<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\TestResponse;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * @inheritDoc
     */
    protected function setUp()
    {
        parent::setUp();

        $test = $this;

        TestResponse::macro('followRedirects', function ($testCase = null) use ($test) {
            $response = $this;
            $testCase = $testCase ?: $test;

            while ($response->isRedirect()) {
                $response = $testCase->get($response->headers->get('Location'));
            }

            return $response;
        });

        // Display test's names while running PHPUnit
        // $testName = str_replace(["test", "_"], ["", " "], $this->getName());
        // $testName = preg_replace_callback("/[a-zA-Z0-9]{3,}\b/", function ($match) {
        //     return ucfirst($match[0]);
        // }, $testName);

        // dump(" ->" . $testName);
    }

    /**
     * Call the given URI by Ajax and return the Response.
     *
     * @param string $uri
     * @param string $method
     * @param array $data
     * @param array $headers
     * @return TestResponse
     */
    public function ajax($uri, $method = 'GET', $data = [], array $headers = [])
    {
        $headers = array_merge(['HTTP_X-Requested-With' => 'XMLHttpRequest'], $headers);
        $server = $this->transformHeadersToServerVars($headers);
        return $this->call($method, $uri, $data, [], [], $server);
    }
}
