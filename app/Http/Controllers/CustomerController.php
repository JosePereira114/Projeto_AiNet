<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\CustomerFormRequest;
use App\Http\Requests\UserFormRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CustomerController extends \Illuminate\Routing\Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(Customer::class);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customers = Customer::paginate(10);
        return view('customers.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $newCustomer = new Customer();
        return view('customers.create')->with('customer', $newCustomer);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CustomerFormRequest $request): RedirectResponse
    {
        $userData = $request->only(['name', 'email', 'photo_filename']);
        $userData['password'] = bcrypt($request->input('password'));
        $userData['type'] = 'C';
        $newUser = User::create($userData);
        $costumerData = $request->except(['name', 'email', 'password', 'photo_filename']);
        $costumerData['id'] = $newUser->id;
        $newCustomer = Customer::create($costumerData);
        $url = route('customers.show', ['customer' => $newCustomer]);
        $htmlMessage = "Customer <a href='$url'><u>{$newCustomer->user->name}</u></a> has been created successfully!";
        return redirect()->route('customers.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        return view('customers.show', compact('customer'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer): View
    {
        return view('customers.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserFormRequest $request, Customer $customer)
    {
        $customer->update($request->validated());
        $url = route('customers.show', ['customer' => $customer]);
        $htmlMessage = "Customer <a href='$url'><u>{$customer->name}</u></a> has been updated successfully!";
        return redirect()->route('customers.index')
            ->with('alert-type', 'success')
            ->with('alert-msg', $htmlMessage);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        try {
            $url = route('customers.show', ['customer' => $customer]);
            $customer->delete();
            return redirect()->route('customers.index')
                ->with('alert-type', 'success')
                ->with('alert-msg', "Customer <u>$customer->name</u> has been deleted successfully");
        } catch (\Exception $e) {
            return redirect()->route('customers.index')
                ->with('alert-type', 'danger')
                ->with('alert-msg', "Customer <u>$customer->name</u> cannot be deleted because it has related data");
        }
    }
}
