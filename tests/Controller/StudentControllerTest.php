<?php

namespace App\Tests\Controller;

use App\Tests\TestBase;
use Symfony\Component\HttpFoundation\Response;

class StudentControllerTest extends TestBase
{
    public function testIndex(): void
    {
        $this->client->request('GET', $this->router->generate('student_index'));
        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Student index');
    }
}
