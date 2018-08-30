<?php
include'_config.php';
echo '<link rel="stylesheet" href="/css/aboutUs.css">';

$page->title = 'About Us';
$page->header();
?>

<!--<style>
    .p1 {
    width: 65%;
    margin: 40px auto;
    text-align: justify;
    padding: 20px;
    border-radius: 5px;
    display: table;
    border-spacing: 10px;
    box-shadow: 0 0 20px black;
    background-color: snow;
    font-size: 19px;
}
</style>-->

<body>
    <section>
        <div id="img">
            <img src="pic/Company_building.jpg" id="image_b" style="height:555px; width:1515px;">
        </div>
        <h2 style="text-align: center;">About Us</h2>
        <div class="p1">
            <p>
                RS Company is started because people demand for quicker delivery service and more high quality shoes.
                That's why RS is founded to satisfied this demand. Along the way, we have done so much things for you, but there are still much more we can improve to enhance your experience in our store.
                We want to be a company that will always give you the best quality of shoes and the fastest store to deliver it to your housefront.
                This is "RS", your choice of store to purchase quality shoes.
            </p>
        </div>

        <p style="text-align: center;">
            Address: Jalan Genting Klang, Setapak, Wilayah Perseketuan Kuala Lumpur @ Malaysia
        </p>
    </section>
</body>

<?php
$page->footer();
?>