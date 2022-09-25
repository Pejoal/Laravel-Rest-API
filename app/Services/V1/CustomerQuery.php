<?php

namespace App\Services\V1;

use Illuminate\Http\Request;

class CustomerQuery
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


  public function transform(Request $request)
  {
    $eloQuery = []; // eloquent

    foreach ($this->safeParms as $parm => $operators) {
      $query = $request->query($parm);
      if (!isset($query)) {
        continue;
      }
      $column = $this->columnMap[$parm] ?? $parm;
      foreach ($operators as $operator) {
        if (isset($query[$operator])) {
          $eloQuery[] = [$column, $this->operatorMap[$operator], $query[$operator]];
        } 
      }
    }
    return $eloQuery;
  }
}
