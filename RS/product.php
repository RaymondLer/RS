<?php 
include'_config.php';
$page->title='Product detail';
$page->header();
echo '<link rel="stylesheet" href="/css/product.css">';

?>
<div class="wrap_aside_section">
<aside><div class="img_container">
        <img class="product_img" src="/product/1033.jpg"><div id="image_div"></div>
       
        </div>
</aside>
<section>
    <div class="product_brand">
        Nike
    </div>
    <div class="product_name">
        LEBRON SOLDIER XII SFG
    </div>
    <div class="product_price">
       RM 566.00
    </div>
     <div class="product_description">
        -The LeBron Soldier XII SFG Basketball Shoe delivers lightweight, responsive cushioning for the court with Nike Zoom Air cushioning. Adjustable hook-and-loop straps offer adjustable, secure lockdown.
     </div>
    <div class="delivery">
        DELIVERED IN<br>
Klang Valley, Johor, Penang: 1-3 days; Rest of Peninsular Malaysia: 1-4 days; Sabah, Sarawak, Brunei: 3-5 days. All in working days
    </div>
    <div id="sold_by">
        SOLD BY RS
    </div>
</section>
    <div class="right_bar">
        <form id="product_size">
            <h3>SELECT SIZE</h3><br>
            Not Sure?  See Size Details(US size)
            <div>
            
            <select name="product_size" id="size">
                <option value="">Size</option>
                <option value="25">25</option>
                <option value="26">26</option>
                <option value="27">27</option>
                <option value="28">28</option>
                <option value="29">29</option>
            </select>
                <div>
                <input type="button" href="#" id="add_bag" value="Add to Bag"></div>
                <div><input type="button" href="#" id="add_cart" value="Add to Cart"></div>
                </div>
        </form>
    </div>
</div>






<?php 
echo '';
$page->footer();
?>