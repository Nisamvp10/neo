<?php
use App\Models\ProductManageModel;
use App\Models\CategoryModel;
use App\Models\SizechartModel;
if(!function_exists('getCollections')){
    function getCollections($slug){
        $productManageModel = new ProductManageModel();
        $categoryModel = new CategoryModel();
        $category = $productManageModel->getproductBycategory($slug);
        return $category;
    }
}

if(!function_exists('lowPrizesizeItem')){
    function lowPrizesizeItem($productId){
       if($productId){
           $sizeChartModel = new SizechartModel();
           $defaultSize =  $sizeChartModel->where('product_id', $productId)->orderBy('extra_price', 'ASC')->limit(1)->get()->getRowArray();
           return $defaultSize;
       }else{
        return '';
       }
    }
}


if(!function_exists('GetProductList')){ 
    function getProductList($type = 'featured', $limit = 12){
        $productManageModel = new ProductManageModel();
        if($type == 'latest'){
            return $productManageModel->where(['latest_product' => 1,'product_status' => 1])->orderBy('id','DESC')->limit($limit)->get()->getResult();
        }elseif($type == 'featured'){
            return $productManageModel->where(['featured_product' => 1,'product_status' => 1])->orderBy('id','DESC')->limit($limit)->get()->getResult();
        }elseif($type == 'premium'){
            return $productManageModel->where(['premium_product' => 1,'product_status' => 1])->orderBy('id','DESC')->limit($limit)->get()->getResult();
        }
        return false; //$productManageModel->where($limit);
    }
}

if(!function_exists('findProductPrice')) {
    function findProductPrice($productId) {
        $productManageModel = new ProductManageModel();
        $sizeChartModel = new SizechartModel();
        //product 
        $product = $productManageModel->find($productId);
        $basePrice = 0;
        $salesPrice = 0;
        $discountAmount = 0;
        $offType = '';
        if($product['price']){
            $basePrice = $product['price'];
        }
        $defaultSize = lowPrizesizeItem($productId);
        if(!empty($defaultSize)){
            $basePrice = $defaultSize['extra_price'] + $product['price'];
        }
        if($product['price']){
            //saleparice 
            if($product['price_offer_type'] == 1){
                //flat rate discount
                $offType = 'RS';
                $salesPrice = $basePrice - $product['compare_price'];
                $discountAmount = $product['compare_price'];
            }elseif($product['price_offer_type'] == 2){
                //percentage discount
                $offType = '%';
                $discountAmount = ($basePrice / 100) * $product['compare_price'];
                $salesPrice = $basePrice - $discountAmount;
            }
            
        }
       

        return [
            "price" => $basePrice,
            "salesPrice" => $salesPrice,
            "discountAmount" => $discountAmount,
            "offSymbol" => $offType
        ];
        
    }
}