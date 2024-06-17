<?php

namespace App\Enums;

use App\Traits\ExtractConstant;

class SalaryEnum
{
    use ExtractConstant;

    //code
    const BASE_SALARY = '1-BASE_SALARY';
    const ALLOWANCE = '2-ALLOWANCE';
    const BONUS = '3-BONUS';
    const BPJS = '4-BPJS';
    const PH21 = '5-PH21';

    //type
    const ADDITION = 'ADDITION';
    const SUBSTRACTION = 'SUBSTRACTION';
}
