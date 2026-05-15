<?= $this->extend('template/layout/main') ?>

<?= $this->section('content') ?>
<style>
    .section-card{
         background:#fff;
            border-radius:16px;
            padding:24px;
            margin-bottom:24px;
            box-shadow:0 2px 10px rgba(0,0,0,0.06);
        }

        .title{
            font-size:20px;
            font-weight:700;
            margin-bottom:20px;
        }

        .btn-add{
            background:#000;
            color:#fff;
            padding:10px 16px;
            border-radius:10px;
            font-size:14px;
        }

        .remove-btn{
            background:#ef4444;
            color:#fff;
            padding:8px 14px;
            border-radius:8px;
        }

        .preview-box{
            background:#0f172a;
            border-radius:20px;
            min-height:300px;
            position:relative;
            overflow:hidden;
        }

        .color-preview{
            width:40px;
            height:40px;
            border-radius:100%;
            border:2px solid #ddd;
        }

        canvas{
            width:100%;
            height:300px;
        }
</style>
    <!-- titilebar -->
    <div class="flex items-center justify-between">
        <div class="col-lg-12">
            <div class="d-flex justify-content-between align-items-center mb-0">
                <h1 class="h3 mb-0"><?= $page ?? '' ?></h1>
                <?php
                if(haspermission('','create_product_management')) { ?>
                <div>
                    <a onclick="openModal()"  class="btn btn-primary"> 
                        <!-- onclick="toggleModal('bannerModal', true)"  -->
                        <i class="bi bi-plus-circle me-1"></i> Add <?=$page;?>
                    </a>
                </div>
                <?php } ?>
            </div>
        </div>
    </div><!-- closee titilebar -->

    <!-- body -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden p-4">
        <div class="flex flex-col md:flex-row gap-4 mb-6">
            <!-- Column 1: Search Input -->
            <div class="flex-1 relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-search text-gray-400">
                    <circle cx="11" cy="11" r="8"></circle>
                    <path d="m21 21-4.3-4.3"></path>
                </svg>
                </div>
                <input type="text" id="searchProductInput" placeholder="Search Title, or location..." class="pl-10 pr-3 py-2 w-full border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
            </div>
                <!-- Column 2: Status Dropdown -->
            <div class="w-full md:w-48">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-filter text-gray-400">
                        <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon>
                    </svg>
                    </div>
                    <select id="filerProductStatus" class="pl-10 pr-3 py-2 w-full border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 appearance-none">
                    <option value="all">All Products</option>
                    <option value="1">Active</option>
                    <option value="2">Inactive</option>
                    </select>
                </div>
            </div>
            </div>
            
            
            </div>
            <!-- table -->
             <div class="overflow-x-auto">
                <div id="servicesTable"></div>
            </div>
            <!-- close table -->
</div><!-- body -->
<!-- productModal -->

 <?= view('modal/productMnagementModal');?>
<!-- view('modal/editBannerModal'); -->
<?= view('modal/uploadGalleryModal');?>
<?= view('modal/iconsModal');?>
<?= view('modal/multiImgModal');?>
 <!-- Cose Modal -->
<?= $this->endSection(); ?>
<?= $this->section('scripts') ?>
<script>
    App.init({
        siteUrl: '<?=base_url();?>',
        cust: '<?=base_url('admin/'.slugify(getappdata('product_management')));?>',
    });
</script>
<script src="<?=base_url('public/assets/js/productmanagement.js');?>"></script>
<script src="<?=base_url('public/assets/js/sweetalert.js');?>"></script>

<script>

// PRODUCT TYPE TOGGLE
$('#product_type').change(function () {
    if ($(this).val() === 'custom') {
        $('#custom_section').show();
        $('#normal_section').hide();
    } else {
        $('#normal_section').show();
        $('#custom_section').hide();
    }
}).trigger('change');


// ADD SIZE (NORMAL)
 $('#addSizeNormal').click(function(){
    let index = $('.size-item').length;

        $('#normalSizeContainer').append(`

            <div class="grid grid-cols-6 gap-3 border p-3 rounded-2xl size-item">
                <div class="contents">
                    <input type="text" name="size_name[]" placeholder="Size Name" id="size_name${index}" class="border rounded-xl p-3">
                    <span class="invalid-feedback" id="size_name${index}_error"></span>
                </div>
                <div class="contents">
                    <input type="text" name="size_width[]" placeholder="Width" id="size_width${index}" class="border rounded-xl p-3">
                    <span class="invalid-feedback" id="size_width${index}_error"></span>
                </div>
                <div class="contents">
                    <input type="text" name="size_height[]" placeholder="Height" id="size_height${index}" class="border rounded-xl p-3">
                    <span class="invalid-feedback" id="size_height${index}_error"></span>
                </div>
                <div class="contents">
                    <input type="number" name="size_price[]" placeholder="Price" id="size_price${index}" class="border rounded-xl p-3">
                    <span class="invalid-feedback" id="size_price${index}_error"></span>
                </div>
                <div class="contents">
                    <input type="number" name="size_multiplier[]" placeholder="Multiplier" id="size_multiplier${index}" class="border rounded-xl p-3">
                    <span class="invalid-feedback" id="size_multiplier${index}_error"></span>
                </div>
                <button type="button" class="remove-btn remove">Remove</button>
            </div>

        `);

    });
// // ADD ADDON
// $('#addAddon').click(function () {
//     $('#addonContainer').append(`
//         <div class="flex gap-2">
//             <input name="addons[][name]" placeholder="Addon Name" class="border p-2 rounded">
//             <input name="addons[][price]" placeholder="Price" class="border p-2 rounded">
//             <button type="button" class="remove text-red-500">X</button>
//         </div>
//     `);
// });


$('#addAddon').click(function () {

    let index = $('.addon-item').length;

    $('#addonContainer').append(`
        <div class="grid grid-cols-5 gap-2">
            <div class="contents">
                <input name="addons_name[]" placeholder="Addon Name" id="addons_name${index}" class="border p-2 rounded w-full border rounded-xl ">
                <span class="invalid-feedback" id="addons_name${index}_error"></span>
            </div>
            <div class="contents">
                <input name="addons_price[]" placeholder="Price" id="addons_price${index}" class="border p-2 rounded w-full border rounded-xl ">
                <span class="invalid-feedback" id="addons_price${index}_error"></span>
            </div>
            <!-- Description Editor -->
            <div class="contents">
                <textarea  name="addons_description[]" id="addons_description${index}"  class="editor border p-2 rounded w-full border rounded-xl " placeholder="Addon Description"></textarea>
                <span class="invalid-feedback" id="addons_description${index}_error"></span>
            </div>
            <!-- Image Upload -->
            <div class="contents">
                <input type="file" name="addons_image[]" id="addons_image${index}" accept="image/*" class="border p-2 rounded w-full border rounded-xl ">
                <span class="invalid-feedback" id="addons_image${index}_error"></span>
            </div>
            <button type="button" class="remove-btn remove text-red-500 px-3 border rounded-xl p-3">X</button>
        </div>
    `);

    // Initialize editor
    $('.editor').last().summernote({
        height: 150
    });
});


 $('#addFont').click(function(){

        $('#fontContainer').append(`

            <div class="grid grid-cols-5 gap-3 border p-4 rounded-2xl font-item">

                <input type="text"
                    placeholder="Font Name"
                    class="border rounded-xl p-3 font-name">

                <input type="number"
                    placeholder="Base Price"
                    class="border rounded-xl p-3 font-base">

                <input type="number"
                    placeholder="Extra Letter Price"
                    class="border rounded-xl p-3 font-extra">

                <input type="file"
                    class="border rounded-xl p-2">

                <button type="button"
                    class="remove-btn remove">
                    Remove
                </button>

            </div>

        `);

        updatePreviewOptions();

    });



// ADD FONT
$('#addFont').click(function () {
    $('#fontContainer').append(`
        <div class="grid grid-cols-4 gap-2">
            <input name="fonts[][name]" placeholder="Font Name" class="border p-2 rounded font-name">
            <input name="fonts[][base]" placeholder="Base Price" class="border p-2 rounded font-base">
            <input name="fonts[][extra]" placeholder="Extra Price" class="border p-2 rounded font-extra">
            <button type="button" class="remove text-red-500">X</button>
        </div>
    `);
});

// ADD SIZE (CUSTOM)
$('#addSizeCustom').click(function () {
    $('#sizeCustomContainer').append(`
        <div class="flex gap-2">
            <input name="sizes[][name]" placeholder="Size Name" class="border p-2 rounded size-name">
            <input name="sizes[][multi]" placeholder="Multiplier" class="border p-2 rounded size-multi">
            <button type="button" class="remove text-red-500">X</button>
        </div>
    `);
});


 // ================= COLORS =================

    $('#addColor').click(function(){

        $('#colorContainer').append(`

            <div class="grid grid-cols-6 gap-2 border p-2 rounded-2xl color-item">
                <input type="text" name="colors_name[]" placeholder="Color Name" class="border rounded-xl p-3 color-name">
                <input type="color" name="colors_code[]" class="border rounded-xl p-1 h-14 color-code">
                <input type="number" name="colors_extra[]" placeholder="Extra Price" class="border rounded-xl p-3">
                <input type="file" name="colors_image[]" class="border rounded-xl p-2">
                <div class="color-preview"></div>
                <button type="button" class="remove-btn remove">Remove</button>
            </div>

        `);

      //  updatePreviewOptions();

    });



     // ================= COLOR PREVIEW =================

    $(document).on('change','.color-code',function(){

        let color = $(this).val();

        $(this).closest('.color-item')
            .find('.color-preview')
            .css('background',color);

        updatePreviewOptions();

    });


// REMOVE
$(document).on('click', '.remove', function () {
    $(this).parent().remove();
});

// PREVIEW OPTIONS
function updatePreview() {
    let fontSelect = $('#preview_font');
    let sizeSelect = $('#preview_size');

    fontSelect.empty();
    sizeSelect.empty();

    $('.font-name').each(function (i) {
        let name = $(this).val();
        let base = $('.font-base').eq(i).val();
        let extra = $('.font-extra').eq(i).val();

        if (name) {
            fontSelect.append(`<option data-base="${base}" data-extra="${extra}">${name}</option>`);
        }
    });

    $('.size-name').each(function (i) {
        let name = $(this).val();
        let multi = $('.size-multi').eq(i).val();

        if (name) {
            sizeSelect.append(`<option data-multi="${multi}">${name}</option>`);
        }
    });
}

$(document).on('keyup change', 'input', updatePreview);

// CALCULATE
function calc() {
    let text = $('#preview_text').val().replace(/\s/g, '');
    let len = text.length;

    let font = $('#preview_font option:selected');
    let size = $('#preview_size option:selected');

    if (!font.val() || len === 0) {
        $('#preview_price').text(0);
        return;
    }

    let base = parseFloat(font.data('base'));
    let extra = parseFloat(font.data('extra'));
    let multi = parseFloat(size.data('multi'));

    let price = base + ((len - 1) * extra);
    price = price * multi;

    $('#preview_price').text(price);
}

$(document).on('keyup change', '#preview_text, #preview_font, #preview_size', calc);

</script>
<?= $this->endSection() ?>


