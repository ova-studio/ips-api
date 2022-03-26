<?php

namespace OvaStudio\IpsApi\Endpoints;

use OvaStudio\IpsApi\Endpoints\System\Messages;

class System extends AbstractEndpoint
{
    public function messages() : Messages
    {
        return new Messages($this->api);
    }
}
