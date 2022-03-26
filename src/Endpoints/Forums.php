<?php

namespace OvaStudio\IpsApi\Endpoints;

use OvaStudio\IpsApi\Endpoints\Forums\Posts;

class Forums extends AbstractEndpoint
{
    public function posts() : Posts
    {
        return new Posts($this->api);
    }
}
