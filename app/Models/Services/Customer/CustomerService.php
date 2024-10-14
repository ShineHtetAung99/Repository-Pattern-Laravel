<?php
namespace App\Models\Services\Customer;

use App\Models\File;
use App\Models\Customer;
use App\Models\CustomerUpload;
use Illuminate\Support\Facades\Log;

class CustomerService
{
    public $CustomerModel; #Model
    public function __construct(Customer $CustomerModel)
    {
        $this->CustomerModel = $CustomerModel;
    }

    public function CustomerCreate($request) 
    {
        try {
            $Customer =  $this->CustomerModel->create($request);
            return $Customer;
        } catch (\Exception $e) {
            Log::debug($e->getMessage());
            Log::emergency($e->getMessage(), [
                'file' => __FILE__,
                'line' => __LINE__
            ]);
            return null;
        }
    }

    public function allCustomer() 
    {
        try {
            $customers = Customer::all();
            return $customers;
        } catch (\Exception $e) {
            Log::debug($e->getMessage());
            Log::emergency($e->getMessage(), [
                'file' => __FILE__,
                'line' => __LINE__
            ]);
            return null;
        }
    }

    public function updateCustomer($request) 
    {
        try {
            $id = $request->id;
            $customer = Customer::find($id);

            if(!empty($request->profile_img))
            {
                $res = delete_file_from_disk($customer->photo);
                $fileID = File::uploadSingleFile('Customer',$request->profile_img,'images',1,'Customer','images');
                $customer->photo = $fileID;
            }
            $customer->name = $request->name;
            $customer->save();
            return $customer;
        } catch (\Exception $e) {
            Log::debug($e->getMessage());
            Log::emergency($e->getMessage(), [
                'file' => __FILE__,
                'line' => __LINE__
            ]);
            return null;
        }
    }

    public function deleteCustomer($request) 
    {
        try {
            $deletecust = Customer::find($request->id);
            $res = delete_file_from_disk($deletecust->photo);
            $uploads = CustomerUpload::where('customer_id',$request->id)->get();
            foreach($uploads as $upload){
                $res = delete_file_from_disk($upload->photo);
            }
            $deletecust = Customer::find($request->id)->delete();
            return true;
        } catch (\Exception $e) {
            Log::debug($e->getMessage());
            Log::emergency($e->getMessage(), [
                'file' => __FILE__,
                'line' => __LINE__
            ]);
            return null;
        }
    }

    public function customerUpload($request) 
    {
        try {
            foreach($request->photos as $photo){
                $name = File::uploadSingleFile('Customer',$photo,'uploads',1,'Customer','uploads');
                CustomerUpload::create([
                    'customer_id'=>$request->customer_id,
                    'photo'=>$name,
                ]);
            }
            $customer = Customer::find($request->customer_id);
            return $customer;
        } catch (\Exception $e) {
            Log::debug($e->getMessage());
            Log::emergency($e->getMessage(), [
                'file' => __FILE__,
                'line' => __LINE__
            ]);
            return null;
        }
    }
}