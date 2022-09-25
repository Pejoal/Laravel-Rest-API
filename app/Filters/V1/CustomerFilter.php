<?php

namespace App\Filters\V1;

use App\Filters\ApiFilter;
use Illuminate\Http\Request;

class CustomerFilter extends ApiFilter
{
  protected $safeParms = [
    'name' => ['eq'],
    'type' => ['eq'],
    'email' => ['eq'],
    'adrress' => ['eq'],
    'city' => ['eq'],
    'state' => ['eq'],
    'postalCode' => ['eq', 'gt', 'lt', 'gte', 'lte'],
  ];

  protected $columnMap = [
    'postalCode' => 'postal_code',
  ];

  protected $operatorMap = [
    'eq' => '=',
    'gt' => '>',
    'gte' => '>=',
    'lt' => '<',
    'lte' => '<=',
  ]; // in operator & like operator


}
