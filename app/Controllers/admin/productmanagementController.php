<?php
namespace App\Controllers\admin;
use CodeIgniter\Controller;
use App\Models\CategoryModel;
use App\Models\ProductModel;
use App\Models\ProductManageModel;
use App\Controllers\UploadImages;
use App\Models\ProductvariantImagesModel;
use App\Models\SizechartModel;
use App\Models\ProductaddonModel;
use App\Models\ColoursModel;
class ProductmanagementController extends Controller
{
    protected $categoryModel;
    protected $productModel;
    protected $productManageModel;
    protected $imgUploader;
    protected $productvariantImagesModel;
    protected $sizeChartModel;
    protected $productaddonModel;
    protected $productColorModel;
    function __construct() {
        $this->imgUploader = new UploadImages();
        $this->categoryModel = new CategoryModel();
        $this->productModel = new ProductModel();
        $this->productManageModel = new ProductManageModel();
        $this->productvariantImagesModel = new ProductvariantImagesModel();
        $this->sizeChartModel = new SizechartModel();
        $this->productaddonModel = new ProductaddonModel();
        $this->productColorModel = new ColoursModel();
    }
    public function index()
    {
       $page = (haspermission('','product_management')) ? ucwords(getappdata('product_management')) : lang('Custom.permissiondenied');
       $route = (haspermission('','product_management')) ? 'admin/productmanagement/index' : 'admin/pages-error-404';
       $categories = $this->categoryModel->where('is_active',1)->findAll();
       //$products = 
       return view($route,compact('page','categories'));
    }

    public function getProductBycategory($id=false) {
        $validStatus = false;
        $validMsg    = '';
        $validResult = '';

        if(!$this->request->isAJAX()) {
            $validMsg = lang('Custom.invalidRequest');
        }
        if(!haspermission('','product_management')) {
             $validMsg = lang('Custom.permissiondenied');
        }else{
            
           $products = $this->productModel->select('id,product_name')->where('category_id', $id)->where('current_stock >', 0)->where('status', 1)->findAll();

            if($products) {
                $validStatus = true;
                $validResult = $products;

            }
        }
        return $this->response->setJson([
            'success' => $validStatus,
            'message' => $validMsg,
            'products' => $validResult
        ]);
    }

    public function list() {
        $validMsg = '';
        $status = false;
        if(!hasPermission('','product_management')) {
            $validMsg = $message = lang('Custom.permissionDenied');
        }
        if(!$this->request->isAJAX()) {
          $validMsg = $message = lang('Custom.invalidRequest');
        }
        $status = false;
        $result ='';
        $search = $this->request->getPost('search');
        $filter = $this->request->getPost('filter');
        $data   = $this->productManageModel->getData($search,$filter);
        //echo  $this->productManageModel->getLastQuery();
        if($data) {

            foreach($data as &$key) {
                $key['id'] = encryptor($key['id']);
                $key['image'] = validImg($key['product_image']);
                $price =  dicountPrice($key['price'],$key['price_offer_type'],$key['compare_price']); // money_format_custom($key['price']);
                $totalDiscount = totalDiscount($key['compare_price'],$key['price_offer_type'],$key['price']);
                $key['compare_price'] = ($key['price_offer_type'] == 2) ? '<del>'.money_format_custom($totalDiscount).'%</del>' : '<del>'.money_format_custom($totalDiscount).'<del>';
                $key['price'] = money_format_custom($price);
            }
            $status = true;
            $validMsg = '';
            $result = $data;
        }
        return $this->response->setJSON(['success' => $status , 'result' => $result,'message' => $validMsg]);

    }

    function productPurchaseDetail($id = false)
    {
        $validStatus = false;
        $validMsg    = '';
        $validResult = [];

        if (!$this->request->isAJAX()) {
            $validMsg = lang('Custom.invalidRequest');
        } elseif (!haspermission('', 'product_management')) {
            $validMsg = lang('Custom.permissiondenied');
        } else {

            $products = $this->productModel->getPurchaseDetail($id); 

            if (!empty($products)) {

                $totalAmount   = 0;
                $totalQuantity = 0;
                $sku           = '';

                foreach ($products as $item) {
                    $totalAmount   += ($item->price * $item->quantity);
                    $totalQuantity += $item->quantity;
                    $sku            = $item->sku;
                }

                $averagePrice = $totalQuantity > 0 ? round($totalAmount / $totalQuantity, 2) : 0;

                $validStatus = true;
                $validResult = [
                    'product_id'     => $id,
                    'total_quantity' => $totalQuantity,
                    'total_amount'   => $totalAmount,
                    'average_price'  => $averagePrice,
                    'sku'            => $sku
                ];
            }
        }

        return $this->response->setJSON([
            'success'  => $validStatus,
            'message'  => $validMsg,
            'products' => $validResult
        ]);
    }

    public function save() {
        if(!$this->request->isAJAX()){
            return $this->response->setJSON(['success' => false,'message' => lang('Custom.invalidRequest')]);
        }
        if(!haspermission('','create_product_management')) {
            return $this->response->setJSON(['success' => false,'message' => lang('Custom.permissiondenied')]);
        }
        $message = '';
        $validStatus = false;
        $rules = [
            'title'         => 'required|min_length[3]',
            'category'      => 'required',
            'note'          => 'required',
            'products'      => 'required',
            'price'         => 'required',
           // 'current_stock' => 'required',
            //'status'        => 'required',
        ];
        if (!$this->validate($rules)) {
            return $this->response->setJSON(['success' => false,'errors' => $this->validator->getErrors()]);
        }
        $id = decryptor($this->request->getPost('itmId'));

        // size Chart Like Regular ,Meduim,Large etc
        // validate name filed ,width,height,price,multiplier not empty 
        // and validate price and width and height and multiplier is number
        $sizename = $this->request->getPost('size_name');
        $sizewidth = $this->request->getPost('size_width');
        $sizeheight = $this->request->getPost('size_height');
        $sizeprice = $this->request->getPost('size_price');
        $sizemultiplier = $this->request->getPost('size_multiplier');

        
        $sizechartValidator = [];
        if(isset($sizename)){
            if(!empty($sizename)){
                foreach($sizename as $key => $value){
                if(empty($value)) {
                    $sizechartValidator['size_name'.$key] = 'required';
                }
                if(empty($sizewidth[$key]) || !is_numeric($sizewidth[$key])) {
                    $sizechartValidator['size_width'.$key] = 'required|numeric';
                }
                if(empty($sizeheight[$key]) || !is_numeric($sizeheight[$key])) {
                    $sizechartValidator['size_height'.$key] = 'required|numeric';
                }
                // if(empty($sizeprice[$key]) || !is_numeric($sizeprice[$key])) {
                //     $sizechartValidator['size_price'.$key] = 'required';
                // }
                if(empty($sizemultiplier[$key]) || !is_numeric($sizemultiplier[$key])) {
                   // $sizechartValidator['size_multiplier'.$key] = 'required|numeric|greater_than_equal_to[0, true]';
                    $sizechartValidator['size_multiplier'.$key] = 'required';
                }
                }
            }
            if (!empty($sizechartValidator) && !$this->validate($sizechartValidator)) {
                return $this->response->setJSON(['success' => false,'errors' => $this->validator->getErrors()]);
            }

            $sizeChartItems = [];
            if(empty($sizechartValidator)){
                foreach($sizename as $key => $size){
                    $sizeChartItems[]= [
                        'size_name'   => $size,
                        'width'       => $sizewidth[$key],
                        'height'      => $sizeheight[$key],
                        'extra_price' => $sizeprice[$key],
                        'multiplier'  => $sizemultiplier[$key],
                    ];
                }
            }
        }
        // close size chart 

        // addons 
         $addons_name = $this->request->getPost('addons_name');
         $addons_price = $this->request->getPost('addons_price');
         $addons_description = $this->request->getPost('addons_description');
         $addons_image = $this->request->getPost('addons_image');
         $addonDatas = [];
         if(isset($addons_name)){
            $addonsValidator = [];
            if(!empty($addons_name)){
                foreach($addons_name as $key => $value){
                if(empty($value)) {
                 $addonsValidator['addons_name'.$key] = 'required';
                }
                if(empty($addons_price[$key]) || !is_numeric($addons_price[$key])) {
                 $addonsValidator['addons_price'.$key] = 'required';
                }
                // if(empty($addons_description[$key]) || !is_numeric($addons_description[$key])) {
                //  $addonsValidator['addons_description'.$key] = 'required|numeric';
                // }
                // if(empty($addons_image[$key]) || !is_numeric($addons_image[$key])) {
                //  $addonsValidator['addons_image'.$key] = 'required|numeric';
                // }
             }
         }
         if (!empty($addonsValidator) && !$this->validate($addonsValidator)) {
             return $this->response->setJSON(['success' => false,'errors' => $this->validator->getErrors()]);
         }
       
         if(empty($addonsValidator)){
            foreach($addons_name as $key => $value){
                
                $addonDatas[] = [
                    'addon_name'        => $value,
                    'addon_price'       => $addons_price[$key],
                    'description' => $addons_description[$key],
                   // 'addon_image'       => $addons_image[$key],
                ];
            }
         }
        }
        // close addons 

        //colors
        $colors_name = $this->request->getPost('colors_name');
        $colors_code = $this->request->getPost('colors_code');
        $colors_extra = $this->request->getPost('colors_extra');
        $colors_image = $this->request->getPost('colors_image');
        $colors_image = $this->request->getPost('colors_image');
        $colorsData = [];
        if(isset($colors_name)){

            // validate color name + extra price + color image + color code

            // create validation array
            $color_validation = [];

            foreach($colors_name as $key => $value){

                if(empty($value))
                    $color_validation['color_name.'.$key] = 'required';

                if(empty($colors_code[$key]))
                    $color_validation['color_code.'.$key] = 'required';

                if(empty($colors_extra[$key]) || !is_numeric($colors_extra[$key]))
                    $color_validation['color_extra.'.$key] = 'required|numeric|greater_than_equal_to[0, true]';

                // Only validate image if selected
                if(!empty($colors_image[$key])){
                    $color_validation['color_image.'.$key] = 'uploaded[color_image.'.$key.']|max_size[color_image.'.$key.',1024]|is_image[color_image.'.$key.']';
                }

            }

            // run validation
            if(count($color_validation) > 0 && !$this->validate($color_validation)){
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }

            // store validated data
          
            foreach($colors_name as $key => $value){
                $colorsData[] = [
                    'color_name'  => $value,
                    'color_code'  => $colors_code[$key],
                    'extra_price' => $colors_extra[$key],
                    //'image'       => $colors_image[$key],
                    'preview_image' => '',
                    'status'        => 1,
                ];
            }

            // save to session
            //session()->set('product_colors', $colorsData);

            // Upload color images if files are present
            if(!empty($this->request->getFiles('colors_image')) && empty($id)){
                $colorImages =$this->request->getFileMultiple('colors_image');
                foreach($colorImages as $key => $image){
                    if ($image->isValid() && !$image->hasMoved()) {
                        $upload = json_decode($this->imgUploader->uploadimg($image, 'product_colors'), true);
                        if($upload['status'] == true){
                            $colorsData[$key]['preview_image'] = $upload['file'];
                        }
                    }
                }

            }
        }


        $file = $this->request->getFile('file');
        $selectedImage = $this->request->getPost('selected_image');

        if ($file && $file->isValid() && !$file->hasMoved()) {
            // Upload new image
            $upload = json_decode($this->imgUploader->uploadimg($file, 'products'), true);
            $imagePath = ($upload['status'] == true ? $upload['file']: '');
        } else {
            // Keep old image if no new upload
            $imagePath = $selectedImage;
        }

        // multiple Images
        $selectedImages = $this->request->getPost('selected_images')[0] ?? '[]';
        $selectedImages = html_entity_decode($selectedImages); // decode &quot;
        $selectedImages = json_decode($selectedImages, true);

        $uploadedPaths = [];
        if(!empty($selectedImages)){
        foreach ($selectedImages as $img) {
            if (strpos($img, 'data:image') === 0) {
                // Handle base64 image
                list($type, $data) = explode(';', $img);
                list(, $data) = explode(',', $data);
                $data = base64_decode($data);

                if (strpos($type, 'image/jpeg') !== false) $ext = '.jpeg';
                elseif (strpos($type, 'image/jpg') !== false) $ext = '.jpg';
                elseif (strpos($type, 'image/png') !== false) $ext = '.png';
                elseif (strpos($type, 'image/webp') !== false) $ext = '.webp';
                elseif (strpos($type, 'image/gif') !== false) $ext = '.gif';
                else $ext = '.jpg';

                $fileName = time() . '_' . uniqid() . $ext;
                $uploadPath =  './uploads/products/' . $fileName;

                if (!is_dir(dirname($uploadPath))) {
                    mkdir(dirname($uploadPath), 0777, true);
                }
                file_put_contents($uploadPath, $data);
                $uploadedPaths[] = 'uploads/products/' . $fileName;
                } else {
                    $uploadedPaths[] = $img;
                }
            }
        }


       $data = [
            'product_title' => $this->request->getPost('title'),
            'category_id'   => (int) $this->request->getPost('category'),
            'slug'           =>  slugify($this->request->getPost('title')),
            'product_id'    => (int) $this->request->getPost('products'),
            'price'         => (float) $this->request->getPost('price'),
            'current_stock' => (int) $this->request->getPost('current_stock'),
            'status'        => (int) $this->request->getPost('status'),
            'compare_price' => (float) $this->request->getPost('compare_price'),
            'price_offer_type' => (int) ($this->request->getPost('price_offer_type') ?? 1),
            'short_description' => $this->request->getPost('note'),
            'description' => $this->request->getPost('description'),
            'seo_title' => $this->request->getPost('meta_title'),
            'seo_description' => $this->request->getPost('meta_keywords'),
            'product_status'=> $this->request->getPost('status') ? 1 : 0,
            'premium_product'=> $this->request->getPost('premium') ? 1 : 0,
            'featured_product'=> $this->request->getPost('featured') ? 1 : 0,
            'latest_product'=> $this->request->getPost('latest') ? 1 : 0,
            'product_type' => ($this->request->getPost('type') == 'normal' ? 1: 2),
            'product_more_info_title' => $this->request->getPost('pointtitle'),
        ];
      
        if(!empty($imagePath)) {
            $data['product_image'] = str_replace(base_url(),'',$imagePath);
        }

        if($id){
          
            $existingSizeDbIds  = $this->sizeChartModel->where('product_id', $id)->findColumn('id');
            $existingSizeDbIds = $existingSizeDbIds ?? [];

            $size_id = $this->request->getPost('size_id') ?? [];
            $formSizeIds = array_filter($size_id);

            /* =========================================
            * DELETE REMOVED ITEMS
            * =========================================*/
            $deleteIds = array_diff($existingSizeDbIds, $formSizeIds);
            if (!empty($deleteIds)) {

                $this->sizeChartModel->whereIn('id', $deleteIds)->delete();
            }
            /* =========================================
            * Insert and update   size chart
            * =========================================*/
            if(!empty($sizename)) {
                foreach($sizename as $key => $size) {

                    if(empty(trim($size))){
                        continue;
                    }
                    
                    $sizeChartData = [
                        'product_id'    => $id,
                        'size_name'   => $size,
                        'width'       => $sizewidth[$key],
                        'height'      => $sizeheight[$key],
                        'extra_price' => $sizeprice[$key],
                        'multiplier'  => $sizemultiplier[$key],
                        'status'      => 1
                    ];                    
                    if(!empty($size_id[$key])){
                        $this->sizeChartModel->update($size_id[$key], $sizeChartData);
                    }else{
                        $this->sizeChartModel->insert($sizeChartData);
                    }
                }
            }
             /* =========================================
            * close  size chart
            * =========================================*/ 
            
            $colorIds = $this->request->getPost('color_id')?? [];
            $colorImages   = $this->request->getFiles()['colors_image'] ?? [];
            $existingcolourIds  = $this->productColorModel->where('product_id', $id)->findColumn('id');
            $existingcolourIds = $existingcolourIds ?? [] ;
            $fromColoursIds = array_filter($colorIds);


            // DELETE REMOVED IEMS
            $deletedIds = array_diff($existingcolourIds,$fromColoursIds);
            if(!empty($deletedIds)){
                foreach($deletedIds as $colourItem){
                    if(!empty($colorImages[$colourItem])){
                        if (!empty($colorImages[$colourItem]) && file_exists(FCPATH . $colorImages[$colourItem])) {
                            echo FCPATH . $colorImages[$colourItem];
                            unlink(FCPATH . $colorImages[$colourItem]);
                        }
                    }
                    $this->productColorModel->where('id', $colourItem)->delete();
                }
            }
            if(!empty($colors_name)){
                foreach($colors_name as $index => $colour){

                    if(empty(trim($colour))){
                        continue;
                    }
                    $colorOldImage = '';

                    if (!empty($colorIds[$index])) {

                        $oldData = $this->productColorModel->find($colorIds[$index]);
                        $colorOldImage = $oldData['preview_image'] ?? '';
                    }
                    $colorImagePath = $colorOldImage;
                    if (!empty($colorImages[$index]) && $colorImages[$index]->isValid() && !$colorImages[$index]->hasMoved()) {

                       /* DELETE OLD IMAGE*/
                        if (!empty($colorOldImage) && file_exists(FCPATH . $colorOldImage)) {
                            unlink(FCPATH . $colorOldImage);
                        }

                        /* CUSTOM UPLOADER*/
                        $upload = json_decode($this->imgUploader->uploadimg($colorImages[$index],'product_colors'),true);

                       

                        if (!empty($upload['status']) && $upload['status'] == true) {
                            $colorImagePath = $upload['file'];
                        }
                    }


                     $colorData = [
                        'product_id'   => $id,
                        'color_name'   => $colour,
                        'color_code'   => $colors_code[$index],
                        'extra_price' => $colors_extra[$index],
                        'preview_image' => $colorImagePath,
                        'status'        => 1
                    ];
                    if(!empty($colorIds[$index])){
                        $this->productColorModel->update($colorIds[$index], $colorData);
                    }else{
                        $this->productColorModel->insert($colorData);
                    }
                }
            }
         // close Colour 
        // Open addon
        $addonIds = $this->request->getPost('addon_id')?? [];
        $existingAddonIds  = $this->productaddonModel->where('product_id', $id)->findColumn('id');
        $existingAddonIds = $existingAddonIds ?? [];
        $fromaddonids = array_filter($addonIds);
        
        // DELETE REMOVED ITEMS
        $deletedAddonIds = array_diff($existingAddonIds,$fromaddonids);
        if(!empty($deletedAddonIds)) {
            $this->productaddonModel->whereIn('id', $deleteIds)->delete();
        }
        
        if(!empty($addons_name)){

            foreach($addons_name as $index => $addOn){

                if(empty(trim($addOn))) {
                    continue;
                }

                $addOndatas = [
                    'product_id' => $id,
                    'addon_name'    => $addOn,
                    'addon_price'   => $addons_price[$index],
                    'description' => $addons_description[$index],
                ];

                if(!empty($addonIds[$index])){
                     $this->productaddonModel->update($addonIds[$index], $addOndatas);
                }else{
                    $this->productaddonModel->insert($addOndatas);
                }
                
            }
        }
                              
            $this->productManageModel->update($id,$data);
             if(!empty($uploadedPaths)) {
                foreach ($uploadedPaths as $url) {
                        
                        $this->productvariantImagesModel->insert(['product_id'=> $id,'image' => str_replace(base_url(),'',$url)]);
                }
            }
            $message = 'Data successfully updated';
            $validStatus = true;
        }else{
            $insertId = $this->productManageModel->insert($data,true);
           if($insertId){

           
                if(is_array($addonDatas) && count($addonDatas) > 0){
                        foreach ($addonDatas as &$addon) {
                            $addon['product_id'] = $insertId;
                        }
                    $this->productaddonModel->insertBatch($addonDatas);
                }
                if(!empty($sizeChartItems) && count($sizeChartItems) > 0){
                        foreach ($sizeChartItems as &$sizeChart) {
                            $sizeChart['product_id'] = $insertId;
                        }
                    $this->sizeChartModel->insertBatch($sizeChartItems);
                }
                if(is_array($colorsData) && count($colorsData) > 0){
                        foreach ($colorsData as &$colorData) {
                            $colorData['product_id'] = $insertId;
                        }
                    $this->productColorModel->insertBatch($colorsData);
                }

                if(!empty($uploadedPaths) && count($uploadedPaths) > 0){
                    foreach ($uploadedPaths as &$uploadedPath) {
                            $uploadedPath['product_id'] = $insertId;
                        }
                    $this->productvariantImagesModel->insertBatch($uploadedPaths);
                }          
                    $message = 'Data successfully added';
                    $validStatus = true;
            }else{
                $message = 'Data not added';
                $validStatus = false;
            }
        }
        return $this->response->setJSON(['success' => $validStatus,'message' => $message]);
    }

    public function getinfo($id =false) {
       
        if(!haspermission('','create_product_management')) {
            return $this->response->setJSON(['success' => false,'message' => lang('Custom.permissiondenied')]);
        }
        $product = [];
        $id = decryptor($id);
        $data = $this->productManageModel->getInfo($id);
        if($data){
            foreach($data as $row) {
                $productId = $row->id;

                if(!isset($product[$productId])) {
                    $product[$productId] = [
                        'id' => encryptor($row->id),
                        'product_title' => $row->product_title,
                        'product_id' => $row->product_id,
                        'category_id' => $row->category_id,
                        'price' => $row->price,
                        'compare_price' => $row->compare_price,
                        'image' => validImg($row->product_image),
                        'product_status' => $row->product_status,
                        'seo_title' => $row->seo_title,
                        'seo_description' => $row->seo_description,
                        'short_description' => $row->short_description,
                        'description' => $row->description,
                        'price_offer_type' => $row->price_offer_type,
                        'premium_product' => $row->premium_product,
                        'product_type' => $row->product_type,
                        'latest_product' => $row->latest_product,
                        'featured_product' => $row->featured_product,
                        'created_at' => $row->created_at,
                        'updated_at' => $row->updated_at,
                        'variantimages' => [],
                        'highlights'    => [],
                        'product_size' => [],
                        'product_color' => [],
                        'product_addon' => [],
                    ];
                }
                if($row->variantimages) {

                    $product[$productId]['variantimages'][] = [
                        'image' => $row->variantimages,
                        'id' => encryptor($row->variantimageid)
                    ];
                }
            }

            // product size
            $product[$productId]['product_size'] = $this->sizeChartModel->where('product_id',$productId)->findAll();
            // product color
            $product[$productId]['product_color'] = $this->productColorModel->where('product_id',$productId)->findAll();
            // product addon
            $product[$productId]['product_addon'] = $this->productaddonModel->where('product_id',$productId)->findAll();
            // product highlight
           // $product[$productId]['product_highlight'] = $this->producthighlightModel->where('product_id',$productId)->findAll();
        }


        $product = array_values($product);
        return $this->response->setJSON(['success' => true,'message' => lang('Custom.success'),'result' => $product]);
    }
    
    public function glleryDelete($id) {
        if(!hasPermission('','create_product_management')) {
            return $this->response->setJSON(['success' => false , 'message' => lang('Custom.permissionDenied')]);
        }
        if(!$this->request->isAJAX()) {
            return $this->response->setJSON(['success' => false , 'message' => lang('Custom.invalidRequest')]);
        }
       
        if(empty($id)) {
            return $this->response->setJSON(['success' => false , 'message' => 'ddss d']);
        }
        $status = false;
        $msg = '';
        $item = $this->productvariantImagesModel->find(decryptor($id));
        if($item) {
            if($this->productvariantImagesModel->where(['id' => decryptor($id)])->delete()) {
                $status  = true;
                $msg = 'Successfully Deleted';
            }else{
                $msg = '!Opps try agian';
            }
        }else{
            $msg = '!Opps try agian';
        }
        return $this->response->setJSON(['success' => $status , 'message' => $msg]);
    }

    public function delete($id) {
        if(!hasPermission('','delete_product_management')) {
            return $this->response->setJSON(['success' => false , 'message' => lang('Custom.permissionDenied')]);
        }
        if(!$this->request->isAJAX()) {
            return $this->response->setJSON(['success' => false , 'message' => lang('Custom.invalidRequest')]);
        }
      
        $status = false;
        $msg = '';
        $item = $this->productManageModel->find(decryptor($id));
        if($item) {
            if($this->productManageModel->update(decryptor($id),['product_status'=>2])) {
                $status  = true;
                $msg = 'Successfully Deleted';
            }else{
                $msg = '!Opps try agian';
            }
        }else{
            $msg = '!Opps try agian';
        }
        return $this->response->setJSON(['success' => $status , 'message' => $msg]);
    }

}