<?php

namespace common\interfaces;


interface StatusInterface
{

    const STATUS_ACTIVE = 1;
    const STATUS_SUSPEND = 0;
    const STATUS_DELETE = -1;
}
