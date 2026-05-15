<?php
namespace App\Services;
use App\Models\ProductManageModel;
use App\Models\ProductAddonModel;
use App\Models\ColoursModel;
use App\Models\SizechartModel;
class ProductService
{
    private $productManageModel;
    private $productAddonModel;
    private $productColorModel;
    private $productSizeModel;
    public function __construct() {
        $this->productManageModel = new ProductManageModel();
        $this->productAddonModel = new ProductAddonModel();
        $this->productColorModel = new ColoursModel();
        $this->productSizeModel = new SizechartModel();
    }
    private function getProductPrice($productId) {
        $productData = $this->productManageModel->where('id', $productId)->get()->getRowArray();
        return $productData;
    }
    private function productSize($sizeId){
        $size = $this->productSizeModel->where('id', $sizeId)->get()->getRowArray();
        return $size;
    }
    private function productAddons($addonIds){
        $addons = $this->productAddonModel->whereIn('id', $addonIds)->get()->getResultArray();
        return $addons;
    }
    private function productColor($colorId){
        $color = $this->productColorModel->where('id', $colorId)->get()->getRowArray();
        return $color;
    }
    public function calculateProductPrice($postData) {
       $productId = $postData['product_id'];
       $addonIds = (isset($postData['addon_ids'])) ? $postData['addon_ids'] : [];
       $productSizeId = (isset($postData['size_id'])) ? $postData['size_id'] : '';
       $productColorId = (isset($postData['color_id'])) ? $postData['color_id'] : '';
       $quantity = (isset($postData['qty'])) ? $postData['qty'] : 1;
       $productInfo = $this->getProductPrice($productId);
       $basePrice = 0;
       $offer = 0;
       $salesPrice = 0;
       if($productInfo) {
            $basePrice = $productInfo['price'];
       }
       if($quantity > 1){
            $basePrice *= $quantity;
        }

       if(!empty($productSizeId)){
            $size = $this->productSize($productSizeId);
            if($size){
                $basePrice += (float)$size['extra_price'];

            }
        }
        if(!empty($productColorId)){
            $color = $this->productColor($productColorId);
            if($color){
                $basePrice += (float)$color['extra_price'];

            }
        }
        if(!empty($addonIds)){
            $addons = $this->productAddons($addonIds);
            if($addons){
                foreach($addons as $addon){
                    $basePrice += (float)$addon['addon_price'];
                }
            }
        }
        
        if($productInfo['compare_price'] > 0) {
            if($productInfo['price_offer_type'] == 1){
                //flat discount
                $discountAmount = $productInfo['compare_price'];
                $salesPrice = $basePrice - $discountAmount;
            }elseif($productInfo['price_offer_type'] == 2){
                //percentage discount
                $discountAmount  = ($basePrice / 100) * $productInfo['compare_price'];
                $salesPrice = $basePrice - $discountAmount;
            }
        }

       $dataPriceList =[
            'basePrice' => $basePrice,
            'salesPrice' => $salesPrice,
            'discountAmount' => $discountAmount,
            'offer' => $offer
       ];
       return $dataPriceList;
    }
}