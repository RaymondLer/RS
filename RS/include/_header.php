<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="/java/jquery-3.3.1.min.js"></script>
        <link rel="shortcut icon" href="/pic/Mainlogo.png">
        <link rel='stylesheet' href="/css/header.css">
        <link rel='stylesheet' href='/css/footer.css'>
        
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <title><?=$this->title?> </title>
        
<header>
    <div id="navl"><a href='/main.php' title='Main Page'><img src="/pic/Mainlogo.png" alt="Web Logo" width=80px" height="80px"></a></div>
            <ul>
                <li class="drop1">
                    <a href="javascript:void(0)" class="men">Men</a>
                    <div class="dropdown-content">
                        <a href="#">Link 1</a>
                        <a href="#">Link 2</a>
                        <a href="#">Link 3</a>
                    </div>
                </li>
                <li class="drop2">
                    <a href="javascript:void(0)" class="women">Women</a>
                    <div class="dropdown-content">
                        <a href="#">Link 1</a>
                        <a href="#">Link 2</a>
                        <a href="#">Link 3</a>
                    </div>
                </li>
                    
                
</ul>   
     <div id="wraph">
                <form class="search-container" action="/action_page.php">
                    <input type="text" placeholder="Search..." name="search">
                        <button type="submit"><i class="fa fa-search"></i></button>
                </form>
            
            <div id="navr">
                         <ul><li class="people"> <a href="javascript:void(0)" class="info"><img src="/pic/people.png" width="50px" height="50px"></a>
                                 <div class="dropdown-pic">
                                     <div class="dropdown-pic_header">
                                     Welcome
                                     </div>
                                     <a href="/account/login.php">Login</a>
                                     <a href="/account/register.php">Register</a>
                                     <div id="hidden">
                                     <a href="#">Order List</a> 
                                     <a href="#">Logout</a>
                                     </div>
                                 </div>
                             </li>
                             <a href="#" title="Favourite"><img src="/pic/like1.png" alt="favourite" width="50px" height="50px"></a>
                             <a href="/cartList.php" title="Cart"><img src="/pic/cart.png" alt="Cart" width="50px" height="50px"></a>
                </ul>
          
          </div>
     </div>
        </header>  