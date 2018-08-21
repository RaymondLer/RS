<?php
include'_config.php';
$page->title='Check out';
$page->header();
echo '<link rel="stylesheet" href="/css/check_out.css">';


$arr_state=[
    'TG'=>'Terengganu',
    'PL'=>'Perlis',
    'KD'=>'Kedah',
    'JH'=>'Johor',
    'SG'=>'Selangor',
    'PP'=>'Pulau Pinang',
    'MK'=>'Melaka',
    'PH'=>'Pahang',
    'SB'=>'Sabah',
    'SW'=>'Sarawak',
    'NS'=>'Negeri Sembilan',
    'KL'=>'Kuala Lumpur'
];

$arr_month=[
  01,02,03  
];
$arr_year=[
    2018,2019,2020
];        


$name='';
$contact_number='';
$address='';
$state='';
$town_city='';
$postal_code='';
$card_number='';
$month='';
$year='';
$security_code='';
$card_name='';


?>

<aside>asdasa</aside>
<section>
    <div class="form_information">
        <div>
            <label for="name">Name:</label>
            <?php $html->text('name',$name,100,'autofocus')?>
        </div>
        <div>
            <label for="contact_number">Contact number</label>
            <?php $html->text('contact_number',$contact_number,12)?>
        </div>
        <div>
            <label for="address">Address</label>
            <?php $html->text('address',$address,100)?>
        </div>
        <div>
            <label for="state">State</label>
            <?php $html->select('state',$arr_state,$state)?>
        </div>
        <idv>
            <label for="town_city">Town/city</label>
            <?php $html->text('town_city',$town_city,40)?>
        </idv>
        <idv>
            <label for="postal_code">Postal Code</label>
            <?php $html->text('postal_code',$postal_code,5)?>
        </idv>

        


    </div>
    <div class='payment'>
        <div class='credit_card'>
            <div class='upper'>
                <div>We accept <img src='/pic/visa_mater_american.png' height='50px'></div>
                <div>You will not be chargerd until you have review and placed your order in the next step.</div>
            </div>
            <form>
                <label for='card_number'>Card Number</label>
                 <?php $html->text('card_number',$card_number,16)?>
                <label for='expiry_date'>Expiry Date(MM/YYYY></label>
                 <?php $date->month_select('month')?>
                <?php $date->year_select('year')?>
                <label for='security_code'>Security Code</label>
                 <?php $html->text('security_code',$security_code,3)?>
                <label for='owner_name'>Owner Card,s Name</label>
                 <?php $html->text('card_name',$card_name,30)?>         
            </form>
            <button type='submit' id="button">Continue to Last Step</button>
        </div>
    </div>
    <div class="review_place_order">
        <div id="upp">
            <!--product pictured
                Brand
                porduct
                Quantity
                size
                X icon(Delete the order)
            -->
            <!-- quantity*price
            -->
            
        </div>
        <div class="calculate_total">
           <!-- total-->
        </div>
        <button id="button">Order Now</button>
    </div>
</section>
<?php

$page->footer();
?>
