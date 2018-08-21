<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Product Hover Zoom</title>
<style>
body{background:url(../background2.png)}
h1 {  font-family: Helvetica, Arial, sans-serif;  text-align: center; font-size:50px; margin-top:20px; color:#fff;
	  text-shadow: 2px 2px 0px rgba(255,255,255,.7), 5px 7px 0px rgba(0, 0, 0, 0.1); 
}
.js-hover-zoom {
    position: relative;
}
.js-orig-img {
width: 420px;
height: 420px;
float: left;
margin-left:90px;
}
.js-cursor-orig-overlay {
    opacity: .5;
    width: 100%;
    height: 100%;
    display: block;
    position: absolute;
}
.js-cursor-zoom-box {
display: none;
background: #fff;
opacity: 0.5;
border: 1px solid #606060;
position: absolute;
float: left;
margin-left:90px;
width: 160px;
height: 160px;
cursor: move;
}
.js-large-img {
background: #fff;
width: 400px;
height: 416px;
position: relative;
float:left;
display: none;
overflow:hidden;
border:2px solid black;
margin-left:20px;
}
.js-large-img-inner {
position: absolute;
transform: scale(1.5);
}
#bounded_box {
width: 76%;
height: 553px;
margin:60px auto;
}
</style>
<script type="text/javascript" src="/java/jquery-3.3.1.min.js"></script>
<script>
(function($) {
    var methods = {
        init: function(options) {
            var settings = $.extend({
                'largeImg': ''
            }, options);

            return this.each(function() {
                var $container = $(this);
                var $div = $('<div />');

                var $origImg = $('.js-orig-img');
                var $largeImg = $('.js-large-img');
                var $largeImgInner = $largeImg.find('.js-large-img-inner');
                var $origOffset = $origImg.offset();
                
                $largeImg.after($div.addClass('js-cursor-zoom-box'));

                var $zoomBox = $('.js-cursor-zoom-box');

                var hovered = false;

                $origImg.mouseenter(function() {
                    $('.js-orig-img').css('background-color', '#000');
                    hovered = true;
                    $zoomBox.fadeIn();
                    $largeImg.fadeIn();
                });

                $zoomBox.mouseleave(function() {
                    hovered = false;
                    $zoomBox.fadeOut();
                    $('.js-cursor-orig-overlay').remove();
                    $largeImg.fadeOut();
                });
                
                $('.js-orig-img').mouseenter(function() {
                    var $overlay = $('<div />').addClass('js-cursor-orig-overlay');
                    $(this).prepend($overlay);
                }).mouseleave(function() {
                   
                });

                $(document).bind('mousemove', function(e) {
                    if (!hovered) {
                        return;
                    }
                    var relX = e.pageX - $origOffset.left; // x coordinate relative to .js-orig-img
                    var relY = e.pageY - $origOffset.top; // y coordinate relative to .js-orig-img
                    
                    $largeImgInner.css({
                        left: $zoomBox.position().left - $zoomBox.position().left * 2,
                        top: $zoomBox.position().top - $zoomBox.position().top * 2
                        
                    });

                    $zoomBox.css({
                        left: Math.min(Math.max(relX - 100, 0), $origImg.width() - $zoomBox.width()),
                        top: Math.min(Math.max(relY  - 100, 0), $origImg.height() - $zoomBox.height())
                    });
                });
            });
        }
    };

    $.fn.hoverZoom = function(method) {
        if (methods[method]) {
            return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
        } else if (typeof method === 'object' || !method) {
            return methods.init.apply(this, arguments);
        } else {
            return false;
        }
    };
})(jQuery);

$(function() {
    $('.js-hover-zoom').hoverZoom();
});
</script>
</head>

<body>
<h1>Product Hover Zoom | Version: 2</h1>

<div class="js-hover-zoom" id="bounded_box">
  <div class="js-orig-img">
      <img src="/product/Shoes/1001.jpg" width="420" height="420" />
  </div>

  <div class="js-large-img">
    <div class="js-large-img-inner">
      <img src="/product/Shoes/1001.jpg" />
    </div>
  </div>
  
</div>

</body>
</html>