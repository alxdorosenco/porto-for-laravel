<?php

namespace AlxDorosenco\PortoForLaravel\Enums;

enum ContainerTypes: string
{
    case PORTO_CONTAINER_TYPE_DEFAULT = 'default';
    case PORTO_CONTAINER_TYPE_FULL = 'full';
    case PORTO_CONTAINER_TYPE_STANDARD = 'standard';
    case PORTO_CONTAINER_TYPE_API = 'api';
    case PORTO_CONTAINER_TYPE_WEB = 'web';
    case PORTO_CONTAINER_TYPE_CLI = 'cli';
}
