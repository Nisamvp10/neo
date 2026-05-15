<?php
namespace App\Controllers;
use CodeIgniter\Controller;
use App\Models\ProductManageModel;
use App\Models\CategoryModel;
use App\Models\SizechartModel;
use App\Models\ProductaddonModel;
use App\Models\ColoursModel;
use App\Models\ProductvariantImagesModel;
Use App\Services\ProductService;
class ProductController extends BaseController
{
    protected $productModel;
    protected $categoryModel;
    protected $productManageModel;
    protected $productSizeModel;
    protected $productAddonModel;
    protected $productColorModel;
    protected $productVariantImagesModel;
    protected $productService;

    function __construct()
    {
        $this->productModel = new ProductManageModel();
        $this->categoryModel = new CategoryModel();
        $this->productManageModel = new ProductManageModel();
        $this->productSizeModel = new SizechartModel();
        $this->productAddonModel = new ProductaddonModel();
        $this->productColorModel = new ColoursModel();
        $this->productVariantImagesModel = new ProductvariantImagesModel();
        $this->productService = new ProductService();
    }
    public function index()
    {
        $page = "Products";
        //$premiumProducts = $this->productManageModel->where(['product_status' => 1,'premium_product' =>1])->orderBy('id','DESC')->get()->getRow();
        $getAllProducts = $this->productModel->getAllProducts();
        $premiumProducts = [];
        if($getAllProducts) {
            foreach($getAllProducts as $row) {
                $productId = $row->id;
                if(!isset($premiumProducts[$productId])) {
                    $premiumProducts[$productId]=[
                        'id' => $row->id,
                        'product_title' => $row->product_title,
                        'compare_price' => $row->compare_price,
                        'price_offer_type' => $row->price_offer_type,
                        'price' => $row->price,
                        'product_image' => $row->product_image,
                        'description' => $row->description,
                        'short_description' => $row->short_description,
                        'category_id' => $row->category_id,
                        'category_name' => $row->category,
                        'sku' => $row->sku,
                        'stock' => $row->current_stock,
                        'stock_status' => $row->stock_status,
                        'variantImages' => []
                    ];
                    
                }
                if($row->variantimages) { 
                        $premiumProducts[$productId]['variantImages'][] = [
                            'image' => $row->variantimages,
                            'id' => encryptor($row->variantimageid)
                        ];
                    }   
                
            }
  
        }
        $premiumProducts = array_values($premiumProducts);
        // echo "<pre>";
        // print_r($premiumProducts);
        // echo "</pre>";
        // exit;
        return view('frontend/products/index',compact('premiumProducts','page'));
    }
   public function details()
    {
        $categorySlug = $this->request->getGet('category');
        $perPage = 12;
        $page = "Products";

        $category = null;

        if ($categorySlug) {
            $category = $this->categoryModel
                ->where('slug', $categorySlug)
                ->first();
        }
        if ($category) {
            $products = $this->productModel->getProducts($category['id'], $perPage);
        } else {
            $products = $this->productModel->getProducts(false, $perPage);
        }

        return view('frontend/products/index', [
            'products' => $products,
            'pager'    => $this->productModel->pager,
            'category' => $categorySlug,
            'page' => $page
        ]);
    }

    public function singleDetails($slug=false) {
        if(empty($slug)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        $product = $this->productModel->where(['product_status' => 1,'slug'=>$slug])->first();
        if(empty($product)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        $page = "Products";
        $pageTitle = $product['product_title'];
        // product size
        $productSize = $this->productSizeModel->where(['product_id' => $product['id']])->findAll();
        // product addon
        $productAddon = $this->productAddonModel->where(['product_id' => $product['id']])->findAll();
        // product color
        $productColor = $this->productColorModel->where(['product_id' => $product['id']])->findAll();
        // product variant images
        $productVariantImages = $this->productVariantImagesModel->where(['product_id' => $product['id']])->findAll();

    
        return view('frontend/products/productdetials',compact('product','page','pageTitle','productSize','productAddon','productColor','productVariantImages'));
    } 

    public function calculateProductPrice() {
        if(!empty($this->request->getPost())) {
            $result = $this->productService->calculateProductPrice($this->request->getPost());
            if($result){
                $result['success'] = true;
                $result['salesPrice'] = money_format_custom($result['salesPrice']);
                $result['basePrice']  = money_format_custom($result['basePrice']);
            }else{
                $result['success'] = false;
                $result['message'] = "Data not found";
            }
        }else{
            $result['success'] = false;
            $result['message'] = "Data not found";
        }
        return $this->response->setJSON($result);
    }

}