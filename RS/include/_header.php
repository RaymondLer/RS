<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="/js/jquery-3.3.1.min.js"></script>
        <script src="/js/jq.js"></script>
        <link rel="shortcut icon" href="/pic/Mainlogo.png">
        <link rel='stylesheet' href="/css/header.css">
        <link rel='stylesheet' href='/css/footer.css'>

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <title><?= $this->title ?> </title>

    <header>
        <?php

        class tempPdo {

            public function pdo() {
                $options = [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
                    PDO::ATTR_EMULATE_PREPARES => false
                ];
                return new PDO('mysql:host=localhost;port=3306;dbname=product', 'root', '', $options);
            }

        }

        $tempPdo = new tempPdo();
        $pdo = $tempPdo->pdo();
        $stm = $pdo->query("SELECT DISTINCT category FROM product WHERE gender LIKE 'male'");
        $male = $stm->fetchAll();
        $stm = $pdo->query("SELECT DISTINCT category FROM product WHERE gender LIKE 'female'");
        $female = $stm->fetchAll();
        ?>
        <div id="navl"><a href='/' title='Main Page'><img src="/pic/Mainlogo.png" alt="Web Logo" width=80px" height="80px"></a></div>
        <ul>
            <li class="drop1">
                <a href="javascript:void(0)" class="men">Men</a>
                <div class="dropdown-content">
                    <?php // $and = urlencode('&') ?>
                    <?php
                    foreach ($male as $m):
                        $category = urlencode($m->category);
                        ?>
                        <a href="/?g=Male&c=<?= $category ?>"><?= $m->category ?></a>
                    <?php endforeach; ?>
                </div>
            </li>
            <li class="drop2">
                <a href="javascript:void(0)" class="women">Women</a>
                <div class="dropdown-content">
                    <?php
                    foreach ($male as $m):
                        $category = urlencode($m->category);
                        ?>
                        <a href="/?g=Female&c=<?= $category ?>"><?= $m->category ?></a>
                    <?php endforeach; ?>

                </div>
            </li>

        </ul>   
        <div id="wraph">
            <form class="search-container" action="/search.php">
                <input type="text" placeholder="Search..." name="search">
                <button type="submit"><i class="fa fa-search"></i></button>
            </form>

            <div id="navr">
                <ul><li class="people"> <a href="javascript:void(0)" class="info"><img src="/pic/people.png" width="50px" height="50px"></a>
                        <div class="dropdown-pic">
                            <div class="dropdown-pic_header">
                                Welcome<?php
                                if ($this->user) {
                                    echo ", {$this->user->name}!";
                                }
                                ?>
                            </div>                      
                            <?php
                            if ($this->user) {
                                echo '<a href="/account/logout.php">Logout</a>';
                                if ($this->user->is_customer) {
                                    echo '<a href="/orderList.php">Order List</a>';
                                    echo '<a href="/account/change_profile.php">Change Profile</a>';
                                    echo '<a href="/account/change_pwd.php">Change Password</a>';
                                } else if ($this->user->is_admin) {
                                    echo '<a href="/account/admin/admin_order_list.php">Order History</a>';
                                    echo '<a href="/account/admin/product_add.php">Add Product</a>';
                                    echo '<a href="/account/admin/product_list.php">Product List</a>';
                                    echo '<a href="/account/admin/admin_register.php">Register Admin</a>';
                                }
                            } else {
                                echo '<a href="/account/login.php">Login</a>';
                                echo '<a href="/account/register.php">Register</a>';
                            }
                            ?>                                                                                                                                            
                        </div>
                    </li>
                    <label for="cart" id="cart">
                        <a href="/cartList.php" title="Cart" name="cart" id="countCart"><img src="/pic/cart.png" alt="Cart" width="50px" height="50px">
                            <?php
                            global $cart;
                            if ($cart->items) {
                                ?><label id="count"><?php
                                    global $cart; // Access to global variable
                                    if ($cart->items) {
                                        $n = $cart->count();
                                        echo $n;
                                    }
                                    ?></label>
                            <?php } ?>
                        </a>
                    </label>
                </ul>
            </div>
        </div>
    </header>