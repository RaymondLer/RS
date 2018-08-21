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
    
}
class Html
{
    public function text($name, $value = '', $maxlength = '', $attr = ''){
        echo "<input type='text' name='$name' id='$name' value='$value' maxlength='$maxlength' $attr>";
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
        for($i=0;$i<=50;$i++){
            $a=$d+$i;
            if($a<=99){
                echo  "<option value=20$a>20$a</option>";
            }
        }
        
        echo "</select>";
    }
}
    



$html = new Html();
$page = new Page();
$date = new Date();
?>