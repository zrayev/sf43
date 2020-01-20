<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Routing\Router;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use App\Entity\User;

class TestBase extends WebTestCase
{

    /**
     * @var Client
     */
    protected $client;

        /**
     * @var Router
     */
    protected $router;

    public function setUp()
    {
        $this->client = static::createClient();
        $this->router = self::$container->get('router');
        $this->runCommand(['command' => 'doctrine:database:create']);
        $this->runCommand(['command' => 'doctrine:schema:update', '--force' => true]);
        $this->runCommand(['command' => 'doctrine:fixtures:load']);
    }

    public function tearDown()
    {
        $this->runCommand(['command' => 'doctrine:database:drop', '--force' => true]);
        $this->client = null;
    }

    /**
     * @param array $arguments
     *
     * @throws \Exception
     */
    protected function runCommand(array $arguments = []): void
    {
        $application = new Application($this->client->getKernel());
        $application->setAutoExit(false);
        $arguments['--quiet'] = true;
        $arguments['-e'] = 'test';
        $input = new ArrayInput($arguments);
        $application->run($input, new ConsoleOutput());
    }

    /**
     * @param $role
     */
    protected function logIn($role): void
    {
        $em = $this->client->getContainer()->get('doctrine.orm.entity_manager');
        $session = $this->client->getContainer()->get('session');
        $admin = $em
            ->getRepository(User::class)
            ->findByRole($role);
        $firewall = 'main';

//        $token = new UsernamePasswordToken($admin->getUsername(), null, $firewall, $admin->getRoles());
//        $session->set('_security_' . $firewall, serialize($token));

        $session->set('_security_' . $firewall, 'admin');
        $session->save();
        $cookie = new Cookie($session->getName(), $session->getId());
        $this->client->getCookieJar()->set($cookie);
    }
}
