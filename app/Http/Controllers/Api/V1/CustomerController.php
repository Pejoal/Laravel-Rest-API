<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Filters\V1\CustomerFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Resources\V1\CustomerResource;
use App\Http\Requests\UpdateCustomerRequest;
use App\Http\Resources\V1\CustomerCollection;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // return new CustomerCollection(Customer::all());

        // http://127.0.0.1:8000/api/v1/customers?page=2
        // http://127.0.0.1:8000/api/v1/customers?postalCode[gt]=30000
        // http://127.0.0.1:8000/api/v1/customers?state[eq]=Nevada
        // http://127.0.0.1:8000/api/v1/customers?postalCode[gt]=30000&type[eq]=I
        $filter = new CustomerFilter();
        $queryItems = $filter->transform($request); // [['coloum', 'operator', 'value']]
        Customer::where($queryItems);
        if (count($queryItems) == 0) {
            return new CustomerCollection(Customer::paginate());
        }
        // return new CustomerCollection(Customer::paginate());
        // return new CustomerCollection(Customer::where($queryItems)->paginate());

        $customers = Customer::where($queryItems)->paginate();
        return new CustomerCollection($customers->appends($request->query()));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCustomerRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCustomerRequest $request)
    {
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
        return new CustomerResource($customer);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCustomerRequest  $request
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCustomerRequest $request, Customer $customer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        //
    }
}
