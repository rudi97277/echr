<?php

namespace App\Enums;

use App\Traits\ExtractConstant;

class SalaryEnum
{
    use ExtractConstant;

    //code
    const BASE_SALARY = 'BASE_SALARY';
    const ALLOWANCE = 'ALLOWANCE';
    const BONUS = 'BONUS';
    const BPJS = 'BPJS';
    const PH21 = 'PH21';

    //type
    const ADDITION = 'ADDITION';
    const SUBSTRACTION = 'SUBSTRACTION';
}
