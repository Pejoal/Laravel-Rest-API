<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Filters\V1\CustomerFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreCustomerRequest;
use App\Http\Resources\V1\CustomerResource;
use App\Http\Requests\V1\UpdateCustomerRequest;
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

        // http://127.0.0.1:8000/api/v1/customers?postalCode[gt]=30000&includeInvoices=true
        // http://127.0.0.1:8000/api/v1/customers?page=2
        // http://127.0.0.1:8000/api/v1/customers?postalCode[gt]=30000
        // http://127.0.0.1:8000/api/v1/customers?state[eq]=Nevada
        // http://127.0.0.1:8000/api/v1/customers?postalCode[gt]=30000&type[eq]=I
        $filter = new CustomerFilter();
        $filterItems = $filter->transform($request); // [['coloum', 'operator', 'value']]

        $includeInvoices = $request->query('includeInvoices');

        $customers = Customer::where($filterItems);
        if ($includeInvoices) {
            $customers = $customers->with('invoices');
        }
        return new CustomerCollection($customers->paginate()->appends($request->query()));

        // if (count($filterItems) == 0) {
        //     return new CustomerCollection(Customer::paginate());
        // }
        // return new CustomerCollection(Customer::paginate());
        // return new CustomerCollection(Customer::where($filterItems)->paginate());

    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCustomerRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCustomerRequest $request)
    {
        return new CustomerResource(Customer::create($request->all()));
        // $return = ['message' => 'Customer Added Successfully'];
        // return json_encode($return);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
        $includeInvoices = request()->query('includeInvoices');
        if ($includeInvoices) {
            return new CustomerResource($customer->loadMissing('invoices'));
        }
        return new CustomerResource($customer);
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
        $customer->update($request->all());
        $return = ['message' => 'Customer Updated Successfully'];
        return json_encode($return);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();
        $return = ['message' => 'Customer Deleted Successfully'];
        return json_encode($return);
    }
}
