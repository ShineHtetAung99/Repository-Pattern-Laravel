<?php

namespace App\Models\Customer\Repositories;

use Throwable;
use App\Models\File;
use App\Models\Customer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Customer\Requests\CustomerRequest;
use App\Models\Services\Customer\CustomerService;
use App\Models\Customer\Repositories\Interfaces\CustomerRepositoryInterface;


class CustomerRepository implements CustomerRepositoryInterface
{
    private  $CustomerService;
    public function __construct(CustomerService $CustomerService)
    {
        $this->CustomerService = $CustomerService;
    }

    /**
     * update customer from admin
     * @create_date 24/3/2023
     * @author  tz
     * @param App\Models\Requests\Customer\CustomerRequest $request
     * @return \Illuminate\Http\Resource\Frontend
     */
    public function storeCustomerData($request)
    {
        DB::beginTransaction();
        try {
            $name = File::uploadSingleFile('Customer',$request->profile_img,'images',0,'Customer','images');
            $data = [
                'name'=>$request->name,
                'photo'=>$name,
            ];
            $Customer = $this->CustomerService->CustomerCreate($data);
            if(is_null($Customer)) {
                DB::rollback();
                return response()->json([
                    'code'    =>  500,
                    'message'   =>  "Error on Create Customer",
                ],500);
            }else{
                DB::commit(); # when all db exc process is ok , final commit db
                return response()->json([
                    'code'    =>  200,
                    'message'   =>  "Success",
                    'Customer' => $Customer
                ],200);
            }
        } catch (\Throwable $th) {
            DB::rollback();
            logger($th->getMessage());
            Log::emergency($th->getMessage(), [
                'file' => __FILE__,
                'line' => __LINE__
            ]);
            return response()->json([
                'code'    =>  500,
                'message'   => "Error in Store Customer Repository",
            ],500);
        }
    }

    /**
     * update customer from admin
     * @create_date 24/3/2023
     * @author  tz
     * @param App\Models\Requests\Customer\UpdateCustomerRequest $request
     * @return \Illuminate\Http\Resource\Frontend
     */
    public function allCustomerData()
    {
        try {
            $Customers = $this->CustomerService->allCustomer();
            if(is_null($Customers)) {
                return response()->json([
                    'code'    =>  500,
                    'message'   =>  "Error on Create Customer",
                ],500);
            }else{
                return response()->json([
                    'code'    =>  200,
                    'message'   =>  "Success",
                    'Customer' => $Customers
                ],200);
            }
        } catch (\Throwable $th) {
            logger($th->getMessage());
            Log::emergency($th->getMessage(), [
                'file' => __FILE__,
                'line' => __LINE__
            ]);
            return response()->json([
                'code'    =>  500,
                'message'   => "Error in all Customer Repository",
            ],500);
        }
    }

    public function updateCustomerData($request)
    {
        DB::beginTransaction();
        try {
            $Customer = $this->CustomerService->updateCustomer($request);
            if(is_null($Customer)) {
                DB::rollback();
                return response()->json([
                    'code'    =>  500,
                    'message'   =>  "Error on Update Customer",
                ],500);
            }else{
                DB::commit(); # when all db exc process is ok , final commit db
                return response()->json([
                    'code'    =>  200,
                    'message'   =>  "Success",
                    'Customer' => $Customer
                ],200);
            }
        } catch (\Throwable $th) {
            DB::rollback();
            logger($th->getMessage());
            Log::emergency($th->getMessage(), [
                'file' => __FILE__,
                'line' => __LINE__
            ]);
            return response()->json([
                'code'    =>  500,
                'message'   => "Error in Update Customer Repository",
            ],500);
        }
    }

    public function deleteCustomerData($request)
    {
        DB::beginTransaction();
        try {
            $Customer = $this->CustomerService->deleteCustomer($request);
            if(is_null($Customer)) {
                DB::rollback();
                return response()->json([
                    'code'    =>  500,
                    'message'   =>  "Error on Delete Customer",
                ],500);
            }else{
                DB::commit(); # when all db exc process is ok , final commit db
                return response()->json([
                    'code'    =>  200,
                    'message'   =>  "Success",
                ],200);
            }
        } catch (\Throwable $th) {
            DB::rollback();
            logger($th->getMessage());
            Log::emergency($th->getMessage(), [
                'file' => __FILE__,
                'line' => __LINE__
            ]);
            return response()->json([
                'code'    =>  500,
                'message'   => "Error in Delete Customer Repository",
            ],500);
        }
    }

    public function customerUploadData($request)
    {
        DB::beginTransaction();
        try {
            $Customer = $this->CustomerService->customerUpload($request);
            if(is_null($Customer)) {
                DB::rollback();
                return response()->json([
                    'code'    =>  500,
                    'message'   =>  "Error on upload Customer photo",
                ],500);
            }else{
                DB::commit(); # when all db exc process is ok , final commit db
                return response()->json([
                    'code'    =>  200,
                    'message'   =>  "Success",
                    'Customer' => $Customer
                ],200);
            }
        } catch (\Throwable $th) {
            DB::rollback();
            logger($th->getMessage());
            Log::emergency($th->getMessage(), [
                'file' => __FILE__,
                'line' => __LINE__
            ]);
            return response()->json([
                'code'    =>  500,
                'message'   => "Error in upload Customer Repository",
            ],500);
        }
    }
}