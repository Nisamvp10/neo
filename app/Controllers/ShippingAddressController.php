<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ShippingAddressModel;
use App\Models\UsersregistrationsModel;
use App\Services\CartService;

class ShippingAddressController extends BaseController
{
    protected $userModel;
    protected $cartService;

    public function __construct()
    {
        $this->userModel = new UsersregistrationsModel();
        $this->cartService = new CartService();
    }

    public function save()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Invalid request'
            ]);
        }

        helper('cookie');
        $sessionId = get_cookie('cart_session');

        $rules = [
            'name' => 'required',
            'shipping_phone' => 'required|min_length[10]|max_length[20]',
            'email' => 'required|valid_email',
            'streetAddress' => 'required',
            'city' => 'required',
            'state' => 'required',
            'zipCode' => 'required|min_length[6]|max_length[6]',
            'country' => 'required',
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'status' => false,
                'errors' => $this->validator->getErrors()
            ]);
        }

        $phone = $this->request->getPost('shipping_phone');
        $email = $this->request->getPost('email');

        // 🔍 Check user
        $user = $this->userModel->where('phone', $phone)->where('email', $email)->first();

        if ($user) {
            $userId = $user['id'];
        } else {
            // 🆕 Create new user
            $this->userModel->insert([
                'name' => $this->request->getPost('name'),
                'phone' => $phone,
                'email' => $email,
                'status' => 1,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
            ]);
            $userId = '';// $this->userModel->insertID();
        }

        //  Auto login
        //session()->set('user', ['userId' => $userId,'isLoggedIn' => true]);

        // 🔄 Merge guest cart → user cart
        $this->cartService->mergeCartAfterLogin();

        // 📦 Save address
        $model = new ShippingAddressModel();

        $data = [
            'user_id' => $userId ?? 0,
            'session_id' => $sessionId,
            'full_name' => $this->request->getPost('name'),
            'phone' => $phone,
            'email' => $email,
            'address_line1' => $this->request->getPost('streetAddress'),
            'city' => $this->request->getPost('city'),
            'state' => $this->request->getPost('state'),
            'postal_code' => $this->request->getPost('zipCode'),
            'country' => $this->request->getPost('country'),
            'is_default' => 1,
            'created_at' => date('Y-m-d H:i:s'),
        ];

        // reset default
        $model->where('user_id', $userId)->set(['is_default' => 0])->update();

        $model->insert($data);

        return $this->response->setJSON([
            'status' => true,
            'message' => 'Address saved & cart merged'
        ]);
    }

    // 📍 GET ADDRESS
    public function getShippingAddress()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['status' => false]);
        }

        helper('cookie');
        $sessionId = get_cookie('cart_session');
        $model = new ShippingAddressModel();

        $phone = $this->request->getPost('phone');
        $email = $this->request->getPost('email');
        $user = session('user');
        //
        $data = [];
        if ($user) {
            $data = $model->where('user_id', $user['userId'])->findAll();
        } else {

            if(!empty($phone) || !empty($email)){
                $data = $this->userModel->where('phone', $phone)->orWhere('email', $email)->first();
                $where = ['user_id' => $data['id']];
            }else{
                $where = ['session_id' => $sessionId];
            }
            $data = $model->where($where)->findAll();
           // echo $model->getLastQuery();

        }
     
        $isLogin = $user ? true : false;
        $results = view('frontend/user/shipping-address-list', compact('data','isLogin'));
       
        return $this->response->setJSON([
            'status' => true,
            'result' => $results
        ]);
    }

    // ⭐ SET DEFAULT
    public function setDefaultAddress()
    {
        helper('cookie');
        $sessionId = get_cookie('cart_session');

        $id = decryptor($this->request->getPost('address_id'));
        $model = new ShippingAddressModel();

        $user = session('user');

        if ($user) {
            $model->where('user_id', $user['userId'])->set(['is_default' => 0])->update();
        } else {
            $model->where('session_id', $sessionId)->set(['is_default' => 0])->update();
        }

        $model->update($id, ['is_default' => 1]);

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Default address updated'
        ]);
    }

    
    public function addressDelete() {
         if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['status' => false]);
        }

        $model = new ShippingAddressModel();

        $id =decryptor($this->request->getPost('id'));
        if(!empty($id)){
            if($model->delete($id)){
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Address deleted'
                ]);
            }
            else{
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Opps! Address not deleted try again'
                ]);
            }
        } else{
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Opps! Address not deleted try again'
            ]);
        }
    }
}