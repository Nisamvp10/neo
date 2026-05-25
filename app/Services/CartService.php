<?php
namespace App\Services;
use App\Models\CartModel;
use App\Models\CartItemModel;
use App\Models\ProductModel;
use App\Models\CategoryModel;
use App\Models\CouponcodeModel;
use App\Models\ProductManageModel;
use App\Models\CustomerOrderModel;
use App\Services\ProductService;
use App\Models\CartAddonItemsModel;
use App\Models\CartItemCustomizationModel;
use App\Models\ProductFontsModel;

class CartService
{
    protected $cartModel;
    protected $itemModel;
    protected $productModel;
    protected $categoryModel;
    protected $productManageModel;
    protected $couponcodeModel;
    protected $customerOrderModel;
    protected $cartSessionId = null;
    protected $productService;
    protected $cartAddonItemsModel;
    protected $cartItemCustomizationModel;
    protected $productFontsModel;

    public function __construct()
    {
        $this->cartModel = new CartModel();
        $this->itemModel = new CartItemModel();
        $this->productModel = new ProductModel();
        $this->categoryModel = new CategoryModel();
        $this->productManageModel = new ProductManageModel();
        $this->couponcodeModel = new CouponcodeModel();
        $this->customerOrderModel = new CustomerOrderModel();
        $this->productService = new ProductService();
        $this->cartAddonItemsModel = new CartAddonItemsModel();
        $this->cartItemCustomizationModel = new CartItemCustomizationModel();
        $this->productFontsModel = new ProductFontsModel();
    }
    private function getCartSessionId()
    {
        if ($this->cartSessionId !== null) {
            return $this->cartSessionId;
        }

        helper('cookie');
        $sessionId = get_cookie('cart_session');
        
        if (!$sessionId) {
            $sessionId = session_id();
            if (empty($sessionId)) {
                $sessionId = bin2hex(random_bytes(16));
            }
            set_cookie('cart_session', $sessionId, 30 * 24 * 60 * 60);
        }
        
        $this->cartSessionId = $sessionId;
        return $sessionId;
    }

    // gust puracjse now i am create session change to cookie
    public function getMyCart()
    {
       $cart = $this->getCart();
       return $cart;
    }

    private function getCart()
    {
        $session = session();
        
        $user = $session->get('user');
        $userId = 0;

        if ($user && isset($user['isLoggedIn']) && $user['isLoggedIn'] === true) {
            $userId = $user['userId']; // use 'id' not userId
        }

        $sessionId = $this->getCartSessionId();

        if ($userId) {
            $this->mergeCartAfterLogin();
            $cart = $this->cartModel->where('user_id', $userId)->first();
            if ($cart) {
                return $cart;
            }
        }

        return $this->cartModel->where('session_id', $sessionId)->first();
    }

    /* ==========================================
    NEW FUNCTION : MERGE SESSION CART TO USER
    ========================================== */
    public function mergeCartAfterLogin()
    {
        $session = session();
        $user = $session->get('user');

        if (!$user || !$user['isLoggedIn']) return;

        $userId = $user['userId'];
        $sessionId = $this->getCartSessionId();

        if (!$sessionId) return;

        // Session cart
        $sessionCart = $this->cartModel->where('session_id', $sessionId)->where('user_id', 0)->first();

        if (!$sessionCart) return;

        // User cart
        $userCart = $this->cartModel->where('user_id', $userId)->first();

        // If user has no cart → assign session cart
        if (!$userCart) {

            $this->cartModel->update($sessionCart['id'], [
                'user_id' => $userId
            ]);

            return;
        }

        // Merge Items
        $sessionItems = $this->itemModel->where('cart_id', $sessionCart['id'])->findAll();

        foreach ($sessionItems as $sItem) {

            $existing = $this->itemModel->where('cart_id', $userCart['id'])->where('product_id', $sItem['product_id'])->first();

            if ($existing) {

                $newQty = $existing['quantity'] + $sItem['quantity'];

                $this->itemModel->update($existing['id'], [
                    'quantity' => $newQty,
                    'subtotal' => $newQty * $existing['price']
                ]);

            } else {

                $this->itemModel->insert([
                    'cart_id' => $userCart['id'],
                    'product_id' => $sItem['product_id'],
                    'price' => $sItem['price'],
                    'quantity' => $sItem['quantity'],
                    'subtotal' => $sItem['subtotal']
                ]);
            }
        }

        // Delete old session cart
        $this->itemModel->where('cart_id', $sessionCart['id'])->delete();
        $this->cartModel->delete($sessionCart['id']);
    }


     private function createCart()
    {
        $session = session();
        $user = $session->get('user');
        $userId = 0;

        if ($user && isset($user['isLoggedIn']) && $user['isLoggedIn'] === true) {
            $userId = $user['userId']; // use 'id' not userId
        }
        return $this->cartModel->insert([
            'user_id'    => $userId,
            'session_id' => $this->getCartSessionId(),
            'is_guest' => $userId > 0 ? 2 : 1,
            'created_at' => date('Y-m-d H:i:s')
        ]);
    }

   public function add($data)
    {
        
        $productPriceList = $this->productService->calculateProductPrice($data);
     
        $productId = $data['product_id'] ?? null;
        $qty       = max(1, (int)($data['qty'] ?? 1));

        $product = $this->productManageModel->find($productId);
        $stockItem = $this->productModel->find($product['product_id']);
        if (!$product || $stockItem['current_stock'] < $qty) {
            return ['status' => false, 'message' => 'Out of stock'];
        }

        $salesPrice = $productPriceList['salesPrice'];
        $discountAmount = $productPriceList['discountAmount'];
        $basePrice = $productPriceList['basePrice'];

        $cart = $this->getCart();
        $cartId = $cart['id'] ?? $this->createCart();

        $item = $this->itemModel->where('cart_id', $cartId)->where('product_id', $productId)->first();
        $newQty = $qty ?? 1;//$item ? $item['quantity'] + $qty : $qty;

        if ($newQty > $stockItem['current_stock']) {
            return ['status' => false, 'message' => 'Stock exceeded'];
        }

        // add add-ons
        $addons = $data['addon_ids'] ?? [];
        $addOnTotal = 0;
        $addonsInsertIds = [];
        $addonDatas = [];
        if(!empty($data['addon_ids'])){
            foreach ($addons as $addonId => $adonitemId) {
                $addon = $this->productService->findAddon($adonitemId);
            
                if ($addon) {
                    // if addon exist already in cart 
                  //  $existingAddon = $this->cartAddonItemsModel->where('cart_item_id', $item['id'])->where('addon_id', $addon['id'])->first();
                  $existingAddon = $this->cartAddonItemsModel->where('addon_id', $addon['id'])->first();
                    //remove old add on items 
                    $fromColoursIds = array_filter($data['addon_ids']);
                    $existingAddonItm = $this->cartAddonItemsModel->where('addon_id', $addon['id'])->findColumn('addon_id');
                    if(!empty($existingAddonItm)){
                        $oldaddondata  = array_diff($existingAddonItm, $fromColoursIds);
                        if(!empty($oldaddondata)){
                            $this->cartAddonItemsModel->where('cart_item_id', $item['id'])->whereIn('addon_id', $oldaddondata)->delete();                
                        }
                    }

                    if ($existingAddon) {

                        $this->cartAddonItemsModel->update($existingAddon['id'], [
                            'cart_item_id' => $item['id'],
                            'addon_id' => $addon['id'],
                            'addon_name' => $addon['addon_name'],
                            'addon_price' => $addon['addon_price'],
                        ]);
                        $basePrice += $addon['addon_price'];
                    } else {
                        $addonDatas[] = [
                            //'cart_item_id' => $item['id'] ?? '',
                            'addon_id' => $addon['id'],
                            'addon_price' => $addon['addon_price'],
                            'addon_name' => $addon['addon_name'],
                            'created_at' => date('Y-m-d H:i:s')
                        ];
                        //$addonsInsertIds[] = $this->cartAddonItemsModel->insertID;
                        $basePrice += $addon['addon_price'];
                    }
                }
            }
        }


        $addonIds = isset($data['addon_ids']) ? $data['addon_ids'] : [];
        sort($addonIds);
        $rowHash = md5(json_encode([

            'type'        => ($product['product_type'] == 1 ? 'normal' : 'custom'),
            'product_id'  => $productId,
            'size_id'     => isset($data['size_id']) ? $data['size_id'] : '',
            'color_id'    => isset($data['color_id']) ? $data['color_id'] : '',
            'font_id'     => isset($data['font_id']) ? $data['font_id'] : '',
            'custom_text' => trim($data['text'] ?? ''),
            'addons'      => $addonIds

        ]));

        //cart_item_id	custom_text	font_id	font_name	color_id	color_name	size_id	size_name	preview_image	calculated_price

        if(!empty($data['size_id']) || !empty($data['color_id']) || !empty($data['font_id']) || !empty($data['custom_text']) || !empty($data['preview_image']) || !empty($data['calculated_price'])){
            //check exist data from database 
            $sutmBasePrice = 0;
            $fontExtraPrice = 0;
            $size = $this->productService->productSizeByid($data['size_id']);
            $exisitCartItemCustomization =[];
            if(!empty($item)){
                 $exisitCartItemCustomization = $this->cartItemCustomizationModel->where('cart_item_id', $item['id'])->first();
            }
            if(!empty($data['color_id'])){
                $color = $this->productService->productColorByIds($data['color_id']);
                $data['color_name'] = $color['color_name'];
                $data['color_price'] = $color['extra_price'];
                $sutmBasePrice += $color['extra_price'];
            }
            if(!empty($data['size_id'])){
               
                $data['size_name'] = $size['size_name'];
                $data['size_price'] = $size['extra_price'];
                $sutmBasePrice += $size['extra_price'];
            }
            if(!empty($data['font_id'])){
                $font = $this->productService->productFont($data['font_id']);
                $data['font_name'] = $font['font_name'];
                $data['font_price'] = $font['extra_letter_price'];
                $fontExtraPrice = $font['extra_letter_price'];
                $sutmBasePrice += $font['base_price'];
            }
        
            //normal product
            $textLength = 0;
            if(isset($data['text'])){
                $textLength = trim($data['text']);
                $textLength = preg_replace('/\s+/', '', $textLength);
                $textLength = strlen($textLength);
                $sutmBasePrice += ($textLength * $fontExtraPrice);
            }

            $sizeCalculated = ($textLength > 0) ? ($size['width'] * $textLength) : $size['width'] ?? $size['width'];
            $cust_datas = [
                'font' => $data['font_name'] ?? '',
                'color' => $data['color_name'] ?? '',
                'size' => [
                    'size_id' => $data['size_id'] ?? '',
                    'size_name' => $data['size_name'] ?? '',
                    'size_price' => $data['size_price'] ?? '',
                    'width' => $sizeCalculated,
                    'height' => $size['height'] ?? $size['height'],
                    'strlen' => $textLength,
                ],
                'custom_text' => $data['text'] ?? '',
                'calculated_price' => $sutmBasePrice ?? 0
            ];
            
          $customTxt = $data['text'] ?? '';
          $customTxt = trim($customTxt);

            $custmizeData = [
                'size_id' => $data['size_id'] ?? '',
                'size_name' => $data['size_name'] ?? '',
                'size_price'=>$data['size_price'] ?? '',
                'color_id' => $data['color_id'] ?? '',
                'color_name' => $data['color_name'] ?? '',
                'colour_price'=>$data['color_price'] ?? '',
                'font_id' => $data['font_id'] ?? '',
                'font_name' => $data['font_name'] ?? '',
                'font_price'=>$data['font_price'] ?? '',
                'custom_text' => $customTxt,
                'preview_image' => $data['preview_image'] ?? '',
                'calculated_price' => $sutmBasePrice ?? 0,
                'cust_datas' => json_encode($cust_datas),
            ];
            if($exisitCartItemCustomization){
                $this->cartItemCustomizationModel->update($exisitCartItemCustomization['id'],$custmizeData);
            }else{
               // $custmizeData['cart_item_id'] = $cartId;
               // $this->cartItemCustomizationModel->insert($custmizeData);
            }
        }


        if ($item) {
            if($item['row_hash'] == $rowHash){
                $newQty = $qty ?? 1;
            }
            $this->itemModel->update($item['id'], [
                'quantity' => $newQty,
                'subtotal' =>  $productPriceList['salesPrice'],
                'discount_amount' => $productPriceList['discountAmount'],
                'price' => $productPriceList['unitPrice'],
                'product_name' => $product['product_title'],
                'product_type' => ($product['product_type'] == 1 ? 'normal' : 'custom'),
                'row_hash' => $rowHash,
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        } else {
            $this->itemModel->insert([
                'cart_id' => $cartId,
                'product_id' => $productId,
                'price' => $productPriceList['unitPrice'],
                'subtotal' => $productPriceList['salesPrice'],
                'discount_amount' => $productPriceList['discountAmount'],
                'product_name' => $product['product_title'],
                'product_type' => ($product['product_type'] == 1 ? 'normal' : 'custom'),
                'row_hash' => $rowHash,
                'quantity' => $qty,
                'created_at' => date('Y-m-d H:i:s')
            ]);
            $itemId = $this->itemModel->getInsertID();
            if(!empty($addonDatas)){
               
                foreach ($addonDatas as $key => $addonData) {
                    $addonData['cart_item_id'] = $itemId;
                    $this->cartAddonItemsModel->insert($addonData);
                }
            }

            $custmizeData['cart_item_id'] = $itemId;
            $this->cartItemCustomizationModel->insert($custmizeData);

        }
        return [
            'status' => true,
            'message' =>'Added to cart',
            'cartCount' => $this->itemModel
                ->where('cart_id', $cartId)
                ->countAllResults()
        ];
    }

    public function remove($data)
    {
        $productId = $data['product_id'] ?? null;

        $cart = $this->getCart();
        if (!$cart) {
            return ['status' => false, 'message' => 'Cart not found'];
        }

        $item = $this->itemModel
            ->where('cart_id', $cart['id'])
            ->where('product_id', $productId)
            ->first();
            //echo $this->itemModel->getLastQuery();

        if (!$item) {
            return ['status' => false, 'message' => 'Item not found in cart'];
        }
         if($cart['couponcode_id'] != null && $cart['coupon_discount'] != null){
           $this->removeCoupon($cart);
        }
        $this->itemModel->delete($item['id']);

        return [
            'status' => true,
            'message' => 'Item removed successfully',
            'cartCount' => $this->itemModel
                ->where('cart_id', $cart['id'])
                ->countAllResults()
        ];
    }

    public function update(array $data)
    {
        $cart = $this->getCart();
        if (!$cart) {
            return ['status' => false, 'message' => 'Cart not found'];
        }

        if (!isset($data['item_id']) || !isset($data['quantity'])) {
            return ['status' => false, 'message' => 'Invalid request'];
        }

        $itemIds   = $data['item_id'];
        $quantities = $data['quantity'];

        $total = 0;

        foreach ($itemIds as $index => $itemId) {
            $itemId = decryptor($itemId);
            $qty = (int) $quantities[$index];

            if ($qty < 1) {
                $this->itemModel->delete($itemId);
                continue;
            }

            $item = $this->itemModel
                ->where('id', $itemId)
                ->where('cart_id', $cart['id'])
                ->first();

            if (!$item) continue;

            $productmanage = $this->productManageModel->find($item['product_id']);
            $product = $this->productModel->find( $productmanage['product_id']);

            if (!$productmanage || $qty > $product['current_stock']) {
                return [
                    'status' => false,
                    'message' => 'Stock exceeded for ' . $productmanage['product_title']
                ];
            }

            $subtotal = $qty * $item['price'];

            $this->itemModel->update($itemId, [
                'quantity' => $qty,
                'subtotal' => $subtotal
            ]);
            $total += $subtotal;
        }

        //update coupon discount and coupon id in cart
        //check cart couponcode_id and coupon_discount is not null
        if(!empty($cart['couponcode_id']) && !empty($cart['coupon_discount'])){
           $this->couponCodeApply($cart['couponcode_id'],$cart['id']);
        }

        return [
            'status' => true,
            'message' => 'Cart updated successfully',
            'total' => $total
        ];
    }


    

    public function getCartItems()
    {
        $cart = $this->getCart();
        if (!$cart) {
            return [];
        }

        $items = $this->itemModel->where('cart_id', $cart['id'])->findAll();

        if (empty($items)) {
            return [];
        }
        // Products
        $productIds = array_column($items, 'product_id');
        if (empty($productIds)) {
            return [];
        }

        $products = $this->productManageModel->whereIn('id', $productIds)->findAll();
        $products = array_column($products, null, 'id');

        // Categories
        $categoryIds = array_unique(array_column($products, 'category_id'));

        if (!empty($categoryIds)) {
            $categories = $this->categoryModel
                ->whereIn('id', $categoryIds)
                ->findAll();
            $categories = array_column($categories, null, 'id');
        } else {
            $categories = [];
        }

        // Build cart response
        $cartItems = [];

        foreach ($items as $item) {
            $product = $products[$item['product_id']] ?? null;
            if (!$product) continue;

            $category = $categories[$product['category_id']] ?? null;

            $cartItems[] = [
                'id'            => $item['id'],
                'product_id'    => $item['product_id'],
                'product_title' => $product['product_title'],
                'slug'          => $product['slug'],
                'category_name' => $category['category'] ?? null,
                'price'         => $item['price'],
                'quantity'      => $item['quantity'],
                'subtotal'      => $item['subtotal'],
                'image'         => $product['product_image'],
                'info'          => $this->cartItemCustomizationModel->select('cust_datas')->where('cart_item_id', $item['id'])->first()
            ];
        }

        return $cartItems;
    }
    public function deleteCart($data)
    {
        $cart = $this->getCart();
        if (!$cart) {
            return ['status' => false, 'message' => 'Cart not found'];
        }

        $this->cartModel->where('id', $cart['id'])->delete();

        return [
            'status' => true,
            'message' => 'Cart deleted successfully'
        ];
    }
    public function couponCodeApply($couponCode,$type = false)
    {
        $cart = $this->getCart();
        if (!$cart) {
            return ['status' => false, 'message' => 'Cart not found'];
        }
        if($type == false){
            $coupon = $this->couponcodeModel->where(['coupencode'=> $couponCode, 'is_active' => 1])->first();
        }else{
            $this->cartModel->update($cart['id'], ['couponcode_id' => null,'coupon_discount' => null]);
            $coupon = $this->couponcodeModel->where(['id'=> $couponCode, 'is_active' => 1])->first();
        }
        if (!$coupon) {
            return ['status' => false, 'message' => 'Coupon code not valid'];
        }
        $cartItems = $this->getCartItems();
        if(empty($cartItems)){
            return ['status' => false, 'message' => 'Cart is empty'];
        }
        $total = 0;
        foreach ($cartItems as $item) {
            $total += $item['subtotal'];
        }
       //$coupon['minimumShopping'] is 150 the $total is 150 or 150 above condition is true 
        if($total < $coupon['minimumShopping']){
            return ['status' => false, 'message' => 'Minimum shopping amount is '.$coupon['minimumShopping']];
        }
        $discount = ($coupon['discount_type'] == 2) ? $total * ($coupon['discount'] / 100) : $coupon['discount'];
        //the maximum_discount_amount discount is limited 500 the discount graterthan 500 then set 500
        if($coupon['maximum_discount_amount'] < $discount){
            $discount = $coupon['maximum_discount_amount'];
        }
        
        //orderpurchsed history check the coupon is used by same user then return false
        $orderHistory = $this->cartModel->where(['couponcode_id' => $coupon['id'], 'user_id' => $cart['user_id']])->first();
        if($orderHistory){
            return ['status' => false, 'message' => 'Coupon code is already used'];
        }
        
        //coupon valid from date to valid to date from date is coupon start date and to date is coupon end date
        if($coupon['validity_from'] <= date('Y-m-d') && $coupon['validity_to'] >= date('Y-m-d')){
            $discount = $discount;
        }
        else{
            return ['status' => false, 'message' => 'Coupon code is expired'];
        }
        // if coupon is used by same user then return false
        $couponUsed = $this->customerOrderModel->where(['coupen_code_id' => $coupon['id'], 'user_id' => $cart['user_id']])->first();
        if($couponUsed){
            return ['status' => false, 'message' => 'Coupon code is already used'];
        }
        $total = $total - $discount;
        //insert coupon_discount and coupon id in cart
        $this->cartModel->update($cart['id'], [
            'couponcode_id' => $coupon['id'],
            'coupon_discount' => $discount
        ]);
        return [
            'status' => true,
            'message' => 'Coupon code applied successfully',
            'total' => $total
        ];
    }


}