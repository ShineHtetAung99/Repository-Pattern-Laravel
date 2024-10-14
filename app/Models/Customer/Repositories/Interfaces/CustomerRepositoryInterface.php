<?php

namespace App\Models\Customer\Repositories\Interfaces;


interface CustomerRepositoryInterface
{
    public function storeCustomerData($request);
    public function allCustomerData();
    public function updateCustomerData($request);
    public function deleteCustomerData($request);
    public function customerUploadData($request);
}