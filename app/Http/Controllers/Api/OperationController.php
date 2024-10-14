<?php

namespace App\Http\Controllers\Api;

use App\Models\File;
use App\Models\Customer;
use Illuminate\Http\Request;

use App\Models\CustomerUpload;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;
use App\Models\Customer\Requests\CustomerRequest;
use App\Models\Customer\Repositories\Interfaces\CustomerRepositoryInterface;


class OperationController extends Controller
{
    private CustomerRepositoryInterface $CustomerRepository;
    public function __construct(CustomerRepositoryInterface $CustomerRepository)
    {
        $this->CustomerRepository = $CustomerRepository;
    }

     /**
     * store customer
     * @create_date 14/10/2024
     * @author  tz
     * @param App\Models\Requests\Customer\CustomerRequest $request
     * @return \Illuminate\Http\Resource\Frontend
     */
    public function storeCustomerData(CustomerRequest $request)
    { 
        try {
            return $this->CustomerRepository->storeCustomerData($request);
        } catch (\Throwable $th) {
            logger($th->getMessage());
            return response()->json([
                'code'    =>  500,
                'message'   => "Error on store_customer_data controller",
                // 'message'   =>  trans('errorMessage.SE_005'),
            ],500);
        }
    }
    public function allCustomerData(Request $request)
    {
        try {
            return $this->CustomerRepository->AllCustomerData();
        } catch (\Throwable $th) {
            logger($th->getMessage());
            return response()->json([
                'code'    =>  500,
                'message'   => "Error on allCustomerData controller",
            ],500);
        }
    }

    public function updateCustomerData(Request $request)
    {
        try {  
            return $this->CustomerRepository->updateCustomerData($request);
        } catch (\Throwable $th) {
            logger($th->getMessage());
            return response()->json([
                'code'    =>  500,
                'message'   => "Error on updateCustomerData controller",
            ],500);
        }
    }
    public function deleteCustomerData(Request $request)
    {
        try {  
            return $this->CustomerRepository->deleteCustomerData($request);
        } catch (\Throwable $th) {
            logger($th->getMessage());
            return response()->json([
                'code'    =>  500,
                'message'   => "Error on deleteCustomerData controller",
            ],500);
        }
    }

    public function customerUploadData(Request $request)
    {
        try {  
            return $this->CustomerRepository->customerUploadData($request);
        } catch (\Throwable $th) {
            logger($th->getMessage());
            return response()->json([
                'code'    =>  500,
                'message'   => "Error on deleteCustomerData controller",
            ],500);
        }
    }

}
