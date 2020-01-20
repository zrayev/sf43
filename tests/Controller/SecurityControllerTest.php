<?php

namespace App\Tests\Controller;

use App\Tests\TestBase;

class SecurityControllerTest extends TestBase
{
    public function testLogin()
    {
        $this->client->request('GET', $this->router->generate('app_login'));

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Please sign in');
    }

}
