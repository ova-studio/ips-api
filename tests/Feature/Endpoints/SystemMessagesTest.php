<?php

namespace OvaStudio\IpsApi\Tests\Feature\Endpoints;

use OvaStudio\IpsApi\IpsApi;
use OvaStudio\IpsApi\Tests\TestCase;

class SystemMessagesTest extends TestCase
{
    public function test_sending_message()
    {
        (new IpsApi())->system()->messages()->create(1, 'Test', 'Test');

        self::assertTrue(true);
    }
}
