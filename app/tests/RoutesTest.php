<?php

class RoutesTest extends TestCase
{
    public function testIsOkHomeRequest()
    {
        $this->client->request('GET', '/');

        $this->assertTrue($this->client->getResponse()->isOk());
    }

    public function testIsOkNewsRequest()
    {
        $this->client->request('GET', '/get-currencies');

        $this->assertTrue($this->client->getResponse()->isOk());
    }
}
