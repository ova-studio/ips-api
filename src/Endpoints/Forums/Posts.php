<?php

namespace OvaStudio\IpsApi\Endpoints\Forums;

use OvaStudio\IpsApi\Endpoints\AbstractEndpoint;
use OvaStudio\IpsApi\IpsApi;
use stdClass;

class Posts extends AbstractEndpoint
{
    private const ENDPOINT = 'forums/posts';

    private int $author;
    private ?string $author_name;
    private bool $anonymous = false;

    public function __construct(IpsApi $api)
    {
        parent::__construct($api);

        $this->withAuthor(config('services.ips.default_user', 1));
    }

    public function withAuthor(int $author, ?string $author_name = null) : static
    {
        $this->author = $author;
        $this->author_name = $author_name;

        return $this;
    }

    public function anonymousMode(bool $anonymous = true) : static
    {
        $this->anonymous = $anonymous;

        return $this;
    }

    public function create(int $topic, string $post) : stdClass
    {
        $data = [
            'topic' => $topic,
            'author' => $this->author,
            'post' => $post,
        ];

        if ($data['author'] === 0)
            $data['author_name'] = $this->author_name;

        if ($this->anonymous)
            $data['anonymous'] = 1;

        $response = $this->api->client->post(self::ENDPOINT, [
            'form_params' => $data
        ]);

        return json_decode($response->getBody());
    }
}
