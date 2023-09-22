<?php

namespace App\Enums;

enum Role: int
{
    case Admin = 1;
    case PO = 2;
    case Supervisor = 3;
    case TL = 4;
    case TM = 5;
    case AIC = 6;
}
