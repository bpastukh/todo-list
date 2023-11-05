<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TaskControllerTest extends WebTestCase
{
    public function testIndex(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/task');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h2', 'Add your task');
    }

    public function testCanSeeTasks(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/task');

        $this->assertCount(2, $crawler->filter('p a'));
    }

    public function testCanAddTest(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/task');

        $client->submitForm('Submit', [
            'task[title]' =>  'Created from test task',
        ]);

        $this->assertResponseRedirects();
        $client->followRedirect();
        $this->assertSelectorExists('a:contains("Created from test task")');
    }
}
