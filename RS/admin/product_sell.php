<?php 
//include('../database.php');
include'../_config.php';
echo "<link rel='stylesheet' href='/css/product_sell.css'>";
$page->title='Product Submit';
$page->header();

// post the product 


//Maybe get the product name to compare the product name is crash
?>
<body>
    <!--?php while($row = mysqli_fetch_array($results))?-->

    <section>
        
        <form method="post" action="#" >
            <h1>Product detail</h1>
            <div class="input-group">
              <label>Product name:</label>
              <input type="text" name="product_name">
           </div>
            <div class="input-group">
            <label>Description:</label>
            <input type="text" name="description">
            </div>
            <div class="input-group">
                <label>Category:</label>
                <input type="text" name="category" width='100px'>
            </div>
            <div class="input-group">
                <label>Image url:</label>
                <input type="text" name="image_url">
            </div>
            <div class="input-group">
                <label>Price:</label>
                <input type="text" name="price" value='RM'>
            </div>
            <div id='coverB'>
            <div class="buttons">
                <button tpe="submit" name="save" class="btn">Save</button>
                <button type="reset" name="reset" class='btn'>Reset</button>
            </div>
            </div>
        </form>
    </section>


</body>

<?php 
$page->footer();
?>