<!-- Lets make a simple image magnifier -->
<?php 
include'_config.php';
$page->title='Check out';
$page->header();


?>

	<div class="magnify">
	<!-- This is the magnifying glass which will contain the original/large version -->
	<div class="large"></div>
	
	<!-- This is the small image -->
	<img class="small" src="http://thecodeplayer.com/uploads/media/iphone.jpg" width="200"/>
        <button>asdads</button>
</div>
<style>
/*Some CSS*/
* {margin: 0; padding: 0;}
.magnify {width: 200px; margin: 50px auto; position: relative; cursor: move}

/*Lets create the magnifying glass*/
.large {
	width: 500px; height: 500px;
	position: absolute;
	border:1px solid black; 
	
	/*Multiple box shadows to achieve the glass effect*/
	box-shadow: 0 0 0 7px rgba(255, 255, 255, 0.85), 
	0 0 7px 7px rgba(0, 0, 0, 0.25), 
	inset 0 0 40px 2px rgba(0, 0, 0, 0.25);
	
	/*hide the glass by default*/
	display: none;
}

/*To solve overlap bug at the edges during magnification*/
.small { display: block; }
</style>
<script>
$(document).ready(function(){

	var native_width = 0;
	var native_height = 0;
  $(".large").css("background","url('" + $(".small").attr("src") + "') no-repeat");

	//Now the mousemove function
	$(".magnify").mousemove(function(e){
		//When the user hovers on the image, the script will first calculate
		//the native dimensions if they don't exist. Only after the native dimensions
		//are available, the script will show the zoomed version.
		if(!native_width && !native_height)
		{
			//This will create a new image object with the same image as that in .small
			//We cannot directly get the dimensions from .small because of the 
			//width specified to 200px in the html. To get the actual dimensions we have
			//created this image object.
			var image_object = new Image();
			image_object.src = $(".small").attr("src");
			
			//This code is wrapped in the .load function which is important.
			//width and height of the object would return 0 if accessed before 
			//the image gets loaded.
			native_width = image_object.width;
			native_height = image_object.height;
		}
		else
		{
			//x/y coordinates of the mouse
			//This is the position of .magnify with respect to the document.
			var magnify_offset = $(this).offset();
			//We will deduct the positions of .magnify from the mouse positions with
			//respect to the document to get the mouse positions with respect to the 
			//container(.magnify)
			var mx = e.pageX - magnify_offset.left;
			var my = e.pageY - magnify_offset.top;
			
                        
			//Finally the code to fade out the glass if the mouse is outside the container
			if(mx < $(this).width() && my < $(this).height() && mx > 0 && my > 0)
			{
				$(".large").fadeIn(100);
			}
			else
			{
				$(".large").fadeOut(100);
			}
			if($(".large").is(":visible"))
			{
				//The background position of .large will be changed according to the position
				//of the mouse over the .small image. So we will get the ratio of the pixel
				//under the mouse pointer with respect to the image and use that to position the 
				//large image inside the magnifying glass
				var rx = Math.round(mx/$(".small").width()*native_width - $(".large").width()/2)*-1;
				var ry = Math.round(my/$(".small").height()*native_height - $(".large").height()/2)*-1;
				var bgp = rx + "px " + ry + "px";
				
				//Time to move the magnifying glass with the mouse
				var px = mx - $(".large").width()/2;
				var py = my - $(".large").height()/2;
				//Now the glass moves with the mouse
				//The logic is to deduct half of the glass's width and height from the 
				//mouse coordinates to place it with its center at the mouse coordinates
				
				//If you hover on the image now, you should see the magnifying glass in action
				$(".large").css({left: px, top: py, backgroundPosition: bgp});
			}
		}
	});
});
//$(document).ready(function(){
// $("button").click(function(){
//        var x = $(". large").offset();
//        alert("Top: " + x.top + " Left: " + x.left + mx + my);
//    });
//});
</script>
<?php 

$page->footer();
?>