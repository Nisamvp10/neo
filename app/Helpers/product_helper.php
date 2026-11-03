<?php
use App\Models\ProductManageModel;
use App\Models\CategoryModel;
use App\Models\SizechartModel;
use App\Models\ProductFontsModel;
if(!function_exists('getCollections')){
    function getCollections($slug){
        $productManageModel = new ProductManageModel();
        $categoryModel = new CategoryModel();

        if($slug == "all"){
            $db = \Config\Database::connect();
            $builder = $db->table('product_management as pm');

            $builder->select('
                pm.id,
                pm.product_id,
                pm.product_title,
                pm.category_id,
                pm.price,
                pm.slug,
                pm.compare_price,
                pm.product_image,
                pm.product_status,
                pm.product_type,
                pm.seo_title,
                pm.seo_description,
                pm.short_description,
                pm.description,
                pm.price_offer_type,
                pm.premium_product,
                pm.featured_product,
                pm.created_at,
                pm.updated_at,

                c.category as category,

                ps.size_name,
                ps.width,
                ps.height,
                ps.extra_price as extra_price,
                ps.multiplier,

                pf.font_name,
                pf.base_price as font_price,

                pc.color_name,
                pc.extra_price as color_price
            ');

            $builder->join('categories as c', 'c.id = pm.category_id', 'left');

            // JOIN LOWEST PRICE SIZE
            $builder->join(
                '(SELECT product_id, MIN(extra_price) as min_price 
                FROM product_sizes 
                GROUP BY product_id) as lowest_size',
                'lowest_size.product_id = pm.id',
                'left'
            );
            $builder->join(
                'product_sizes as ps',
                'ps.product_id = pm.id 
                AND ps.extra_price = lowest_size.min_price',
                'left'
            );

            // JOIN LOWEST PRICE FONT
            $builder->join(
                '(SELECT product_id, MIN(base_price) as min_font_price 
                FROM product_fonts 
                GROUP BY product_id) as lowest_font',
                'lowest_font.product_id = pm.id',
                'left'
            );
            $builder->join(
                'product_fonts as pf',
                'pf.product_id = pm.id 
                AND pf.base_price = lowest_font.min_font_price',
                'left'
            );

            // JOIN LOWEST PRICE COLOR
            $builder->join(
                '(SELECT product_id, MIN(extra_price) as min_color_price 
                FROM product_colors 
                GROUP BY product_id) as lowest_color',
                'lowest_color.product_id = pm.id',
                'left'
            );
            $builder->join(
                'product_colors as pc',
                'pc.product_id = pm.id 
                AND pc.extra_price = lowest_color.min_color_price',
                'left'
            );

            $builder->where('pm.product_status', 1);
            $builder->groupBy('pm.id');

            return $builder->get()->getResult();
        }

        $category = $productManageModel->getproductBycategory($slug);
        return $category;
    }
}

if(!function_exists('lowPrizesizeItem')){
    function lowPrizesizeItem($productId){
       if($productId){
           $sizeChartModel = new SizechartModel();
           $defaultSize =  $sizeChartModel->where('product_id', $productId)->orderBy('extra_price', 'ASC')->limit(1)->get()->getRowArray();
          if($defaultSize['extra_price'] == 0){
            $defaultSize =  $sizeChartModel->where('product_id', $productId)->orderBy('id', 'ASC')->limit(1)->get()->getRowArray();
          }
           return $defaultSize;
       }else{
        return '';
       }
    }
}

if(!function_exists('getLowpriceFont')){
    function getLowpriceFont($productId){
       if($productId){
           $productFontsModel = new ProductFontsModel();
           $defaultFont =  $productFontsModel->where('product_id', $productId)->orderBy('base_price', 'ASC')->limit(1)->get()->getRowArray();
           return $defaultFont;
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