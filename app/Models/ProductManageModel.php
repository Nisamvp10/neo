<?php
namespace App\Models;
use CodeIgniter\Model;
class ProductManageModel extends Model{
    protected $table ="product_management";
    protected $primaryKey = 'id';
    protected $allowedFields = ['product_id','product_title','slug','category_id','price','product_type','compare_price','premium_product','latest_product',
    'product_more_info_title','featured_product','price_offer_type','short_description','description','seo_title','seo_description','product_image','product_status','created_at','created_by','updated_at','updated_by'];
    
    function getData($search='',$filter=false){
        $builder = $this->table('product_management');
        $builder->where('product_status', 1);
        if($search) {
            $builder->like('product_title', $search);
        }
        if($filter && $filter != 'all') {
            $builder->where('product_status', $filter);
        }
        return $builder->findAll();
    }
    public function getInfo($id){
        $builder = $this->db->table('product_management as pm')
            ->select('pm.id,pm.product_id,pm.product_title,pm.category_id,pm.price,pm.product_more_info_title,
            pm.compare_price,pm.product_image,pm.product_type,pm.latest_product,pm.product_status,pm.seo_title,pm.seo_description,pm.short_description,pm.description,pm.price_offer_type,pm.premium_product,pm.featured_product,pm.created_at,pm.updated_at,
           pvi.image as variantimages,pvi.id as variantimageid' )
          ->join('product_variant_images as pvi','pvi.product_id = pm.id','left');
        $builder->where('pm.id', $id);
        
        return $builder->get()->getResult();
    }

    public function getProducts($category_id=false,$perPage=null){
        $this->where('product_status', 1);
        if ($category_id) {
            $this->where('category_id', $category_id);
        }
        if ($perPage) {
            return $this->paginate($perPage);
        }
    }

    function productSingle($slug='') {
        $builder = $this->db->table('product_management as pm')
            ->select('pm.id,pm.product_id,pm.product_title,pm.category_id,pm.price,pm.compare_price,pm.product_image,pm.product_type,pm.product_status,pm.seo_title,pm.seo_description,pm.short_description,pm.description,pm.price_offer_type,pm.premium_product,pm.featured_product,pm.created_at,pm.updated_at,
           pvi.image as variantimages,pvi.id as variantimageid,
           c.category as category,
           p.product_name,p.sku,p.current_stock,p.status as stock_status')
          ->join('product_variant_images as pvi','pvi.product_id = pm.id','left')
          ->join('categories as c','c.id = pm.category_id','left')
          ->join('products as p','p.id = pm.product_id','left');
        $builder->where('pm.slug', $slug);
        
        return $builder->get()->getResult();
    }
    //se all product with varient
    function getAllProducts() {
        $builder = $this->db->table('product_management as pm')
            ->select('pm.id,pm.product_id,pm.product_title,pm.category_id,pm.price,pm.compare_price,pm.product_image,pm.product_status,pm.product_type,pm.seo_title,pm.seo_description,pm.short_description,pm.description,pm.price_offer_type,pm.premium_product,pm.featured_product,pm.created_at,pm.updated_at,
           pvi.image as variantimages,pvi.id as variantimageid,
           c.category as category,
           p.product_name,p.sku,p.current_stock,p.status as stock_status')
          ->join('product_variant_images as pvi','pvi.product_id = pm.id','left')
          ->join('categories as c','c.id = pm.category_id','left')
          ->join('products as p','p.id = pm.product_id','left');
        return $builder->get()->getResult();
    }

    function getproductBycategory($slug=false){
      $builder = $this->db->table('product_management as pm');

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

        $builder->where('c.slug', $slug);

        // Prevent duplicate rows when multiple sizes/fonts/colors share the same min price
        $builder->groupBy('pm.id');

        return $builder->get()->getResult();
    }
}

