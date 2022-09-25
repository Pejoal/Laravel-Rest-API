<?php

namespace App\Filters\V1;

use App\Filters\ApiFilter;
use Illuminate\Http\Request;

class InvoicesFilter extends ApiFilter
{
  protected $safeParms = [
    'customerId' => ['eq'],
    'amount' => ['eq', 'gt', 'lt', 'gte', 'lte'],
    'status' => ['eq','ne'],
    'billedDate' => ['eq'],
    'paidDate' => ['eq'],
  ];

  protected $columnMap = [
    'customerId' => 'customer_id',
    'billedDate' => 'billed_date',
    'paidDate' => 'paid_date',
  ];

  protected $operatorMap = [
    'eq' => '=',
    'gt' => '>',
    'gte' => '>=',
    'lt' => '<',
    'lte' => '<=',
    'ne' => '!=',
  ]; // in operator & like operator


}
