<?php 

//Page Class
class Page
{
    public $root;
    public $title;
    // For Secruity
    public $home_page;
    public $login_page;
    public $user;
            

    function __construct() {
        $this->root = $_SERVER['DOCUMENT_ROOT'];
        $this->title = 'Untitled';
        // For Secruity
        $this->home_page  = '/';
        $this->login_page = '/account/login.php';
        $this->user = isset($_SESSION['auth_user']) ? $_SESSION['auth_user'] : null;
     }
     
    public function header() {
        include $this->root . '/include/_header.php';
    }
    
    public function footer() {
        include $this->root . '/include/_footer.php';
    }
     
    public function get($name, $default = '', $escape = true, $trim = true) {
        $value = isset($_GET[$name]) ? $_GET[$name] : $default;
        
        if ($escape) $value = htmlspecialchars($value);
        if ($trim)   $value = trim($value);
        
        return $value;
    }
    
    public function post($name, $default = '', $escape = true, $trim = true) {
        $value = isset($_POST[$name]) ? $_POST[$name] : $default;
        
        if ($escape) $value = htmlspecialchars($value);
        if ($trim)   $value = trim($value);
        
        return $value;
    }
    
    public function get_array($name, $default = [], $escape = true, $trim = true) {
        $items = isset($_GET[$name]) ? $_GET[$name] : $default;
        
        for ($i = 0; $i < count($items); $i++) {
            if ($escape) $items[$i] = htmlspecialchars($items[$i]);
            if ($trim)   $items[$i] = trim($items[$i]);
        }
        
        return $items;
    }
    
    public function post_array($name, $default = [], $escape = true, $trim = true) {
        $items = isset($_POST[$name]) ? $_POST[$name] : $default;
        
        for ($i = 0; $i < count($items); $i++) {
            if ($escape) $items[$i] = htmlspecialchars($items[$i]);
            if ($trim)   $items[$i] = trim($items[$i]);
        }
        
        return $items;
    }
    
    public function is_get() {
        return $_SERVER['REQUEST_METHOD'] == 'GET';
    }
    
    public function is_post() {
        return $_SERVER['REQUEST_METHOD'] == 'POST';
    }
    
    public function redirect($url = '') {
        if ($url == '') {
            $url = $_SERVER['REQUEST_URI'];
        }
        
        ob_clean();
        header("Location: $url");
        exit();
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
    
    public function pdo() {
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
            PDO::ATTR_EMULATE_PREPARES => false
        ];
        return new PDO('mysql:host=localhost;port=3306;dbname=product', 'root', '', $options);
    }
    
    // Security
    public function authorize($roles = '') {
        $arr = explode(',', $roles);
        
        if ($this->user && $roles == '') {
            // User signed in --> OK
        }
        else if ($this->user && in_array($this->user->role, $arr)) {
            // User signed in. Role matched --> OK
        }
        else {
            $return = $_SERVER['REQUEST_URI'];
            $this->redirect($this->login_page . '?return=' . urlencode($return));
        }
    }
    
    public function sign_in($name, $role, $redirect = true) {
        $user = new stdClass();
        $user->name = $name;
        $user->role = $role;
        $user->is_admin  = $role == 'admin';
        $user->is_customer = $role == 'customer';
        
        $_SESSION['auth_user'] = $this->user = $user;
        
        if ($redirect) {
            $return = $this->get('return');
            if ($return) {
                $this->redirect($return);
            }
            else {
                $this->redirect($this->home_page);
            }
        }
    }
    
    public function sign_out($redirect = true) {
        unset($_SESSION['auth_user']);
        $this->user = null;
        
        if ($redirect) {
            $this->redirect($this->home_page);
        }
    }
    
        // Generate random password
    public function random_password() {
        $s = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $password = '';
        
        for ($n = 1; $n <= 10; $n++) {
            $i = rand(0, strlen($s) - 1);
            $password .= $s[$i];
        }
        
        return $password;
    }

    // Email
    public function email($address, $subject, $body, $isHTML = true) {
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 587;
        $mail->SMTPSecure = 'tls';
        $mail->SMTPAuth = true;
        $mail->Username = 'aacs3173@gmail.com';
        $mail->Password = 'password3173';
        $mail->setFrom('aacs3173@gmail.com', 'PHP Admin');
        
        $mail->addAddress($address);
        $mail->Subject = $subject;
        $mail->Body = $body;
        $mail->isHTML($isHTML);
        
        return $mail->send();
    }
}

//HTML Class
class Html
{
    public function text($name, $value = '', $maxlength = '', $attr = ''){
        echo "<input type='text' name='$name' id='$name' value='$value' maxlength='$maxlength' $attr>";
    }
   public function textArea($name, $col, $row){
       echo "<textarea name='$name' id='$name' cols='$col' rows='$row'></textarea>";
   }
     public function password($name, $value = '', $maxlength = '', $attr = '') {
        echo "<input type='password' name='$name' id='$name' value='$value' maxlength='$maxlength' $attr>";
    }
    
     public function hidden($name, $value = '', $attr = '') {
        echo "<input type='hidden' name='$name' id='$name' value='$value' $attr>";
    }
    
    public function radio_list($name, $items, $checked = '', $break = false, $attr = '') {
        foreach ($items as $value => $text) {
            $status = $value == $checked ? 'checked' : '';
            echo "<label><input type='radio' name='$name' id='$name-$value' value='$value' $status $attr>$text</label>";
            if ($break) echo '<br>';
        }
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
    
    public function errors($err) {
        if($err) {
            echo '<ul class="errors">';
            foreach ($err as $e) {
                echo "<li>$e</li>";
            }
            echo '</ul>';
        }
    }
    
    public function error($err, $key) {
        if (isset($err[$key])) { // The field has error?
            echo "<span class='error'>$err[$key]</span>";
        }
    }
    
    public function focus($name, $err = []) {
        if ($err) {
            $name = array_keys($err)[0];
        }       
        echo "<script>$('[name^=$name]').first().focus();</script>";
    }
    
    public function success($message) {
        if ($message) {
            echo "<p class='success'>$message</p>";
        }
    }
}

//Date Class
class Date
{
    public function month_select($name, $attr=''){
         echo "<select name='$name' id='$name' $attr>";
        for ($i = 1; $i <= 12; $i++) {
                echo  "<option value='$i'>$i</option>";
        }
        echo "</select>";
    }
    public function year_select($name, $attr=''){
        echo "<select name='$name' id='$name' $attr maxlength='4'>";
        $d = date(y);
        for ($i = 0; $i <= 50; $i++) {
            $a = $d + $i;
            if ($a <= 99){
                echo  "<option value=20$a>20$a</option>";
            }
        }      
        echo "</select>";
    }
}

//Cart Class
class Cart
{
    // Restore shopping cart from session variable
    function __construct() {
        $this->items = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
    }
    
    // Set an item (id and quantity)
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
    
    // Get the quantity of an item
    public function get($id) {
        return isset($this->items[$id]) ? $this->items[$id] : 0;
    }
    
    // Remove an item
    public function remove($id) {
        unset($this->items[$id]);
        $_SESSION['cart'] = $this->items;
    }
    
    // Remove all items
    public function clear() {
        $this->items = [];
        $_SESSION['cart'] = $this->items;
    }
    
    // Return all ids (keys)
    public function ids() {
        return array_keys($this->items);
    }
    
    // Return items count
    public function count() {
        return count($this->items);
    }
    
    // Return total quantity
    public function quantity() {
        return array_sum($this->items);
    }
    
    // Debug
    public function dump() {
        var_dump($this->items);
    }
}    

date_default_timezone_set('Asia/Kuala_Lumpur');
session_start();
ob_start();

$html = new Html();
$page = new Page();
$date = new Date();
$cart = new Cart();
?>
