<?php

namespace App\Tests\Controller;

use App\Entity\User;
use App\Tests\TestBase;
use Symfony\Component\HttpFoundation\Response;

class CompanyControllerTest extends TestBase
{
    public function testIndex(): void
    {
        $this->logIn(User::ROLE_ADMIN);
        $this->client->request('GET', $this->router->generate('company_index'));
        $this->assertEquals(Response::HTTP_FOUND, $this->client->getResponse()->getStatusCode());
    }
}
