<?php 

class Page
{
    public $root;
    public $title;
    

    function __construct() {
        $this->root = $_SERVER['DOCUMENT_ROOT'];
        $this->title = 'Untitled';
        
        $this->home_page  = '/';
//        Need to see first
        $this->login_page = '/account/login.php';
        $this->user = isset($_SESSION['auth_user']) ? $_SESSION['auth_user'] : null;
     }
    public function header() {
        include $this->root . '/include/_header.php';
    }
    public function footer() {
        include $this->root . '/include/_footer.php';
    }
     public function is_post() {
        return $_SERVER['REQUEST_METHOD'] == 'POST';
    }
    public function temp($key, $value = null) {
       if ($value) {
            $_SESSION["temp_$key"] = $value;
        }
        else {
            if (isset($_SESSION["temp_$key"])) {
                $value = $_SESSION["temp_$key"];
                unset($_SESSION["temp_$key"]);
                return $value;
            }
        }
    }
    
}
class Html
{
    public function text($name, $value = '', $maxlength = '', $attr = ''){
        echo "<input type='text' name='$name' id='$name' value='$value' maxlength='$maxlength' $attr>";
    }
    
     public function password($name, $value = '', $maxlength = '', $attr = '') {
        echo "<input type='password' name='$name' id='$name' value='$value' maxlength='$maxlength' $attr>";
    }
    
     public function hidden($name, $value = '', $attr = '') {
        echo "<input type='hidden' name='$name' id='$name' value='$value' $attr>";
    }
    
    public function select($name, $items, $selected = '', $default = true, $attr = '') {
        echo "<select name='$name' id='$name' $attr>";
        if ($default) echo '<option value="">- Select One -</option>';
        foreach ($items as $value => $text) {
            $status = $value == $selected ? 'selected' : '';
            echo "<option value='$value' $status>$text</option>";
        }
        echo '</select>';
    }
}


class Date
{
    public function month_select($name, $attr=''){
         echo "<select name='$name' id='$name' $attr>";
        for($i=1;$i<=12;$i++){
                echo  "<option value='$i'>$i</option>";
        }
        echo "</select>";
    }
    public function year_select($name, $attr=''){
        echo "<select name='$name' id='$name' $attr maxlength='4'>";
        $d=date(y);
        for($i = 0; $i <= 50; $i++){
            $a = $d + $i;
            if($a <= 99){
                echo  "<option value=20$a>20$a</option>";
            }
        }
        
        echo "</select>";
    }
}
class Cart
{
    // TODO: Restore shopping cart from session variable
    function __construct() {
        $this->items = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
    }
    
    // TODO: Set an item (id and quantity)
    public function set($id, $quantity) {
        $n = (int)$quantity;
        if ($n > 0) {
            $this->items[$id] = $n;
        }
        else {
            $this->remove($id); // Remove item if quantity 0
        }
        $_SESSION['cart'] = $this->items;
    }
    
    // TODO: Get the quantity of an item
    public function get($id) {
        return isset($this->items[$id]) ? $this->items[$id] : 0;
    }
    
    // TODO: Remove an item
    public function remove($id) {
        unset($this->items[$id]);
        $_SESSION['cart'] = $this->items;
    }
    
    // TODO: Remove all items
    public function clear() {
        $this->items = [];
        $_SESSION['cart'] = $this->items;
    }
    
    // TODO: Return all ids (keys)
    public function ids() {
        return array_keys($this->items);
    }
    
    // TODO: Return items count
    public function count() {
        return count($this->items);
    }
    
    // TODO: Return total quantity
    public function quantity() {
        return array_sum($this->items);
    }
    
    // Debug
    public function dump() {
        var_dump($this->items);
    }
}    

//date_default_timezone_set('Asia/Kuala_Lumpur');
//session_start();
//ob_start();

$html = new Html();
$page = new Page();
$date = new Date();
$cart = new Cart();
?>