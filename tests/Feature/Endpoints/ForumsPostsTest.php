<?php

namespace OvaStudio\IpsApi\Tests\Feature\Endpoints;

use OvaStudio\IpsApi\IpsApi;
use OvaStudio\IpsApi\Tests\TestCase;

class ForumsPostsTest extends TestCase
{
    public function test_post_create()
    {
        $post = (new IpsApi())->forums()->posts()->create(2928, '<p>Test</p>');

        self::assertTrue(true);
        self::assertNotNull($post->id);
    }
}
