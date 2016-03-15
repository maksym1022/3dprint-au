<?php
ob_start();

GLOBAL $webnus_options;

$is_sticky = $webnus_options->webnus_header_sticky();

$scrolls_value = $webnus_options->webnus_header_sticky_scrolls();

$scrolls_value = !empty($scrolls_value) ? $scrolls_value : 150;

if( '1' == $is_sticky) {
?>

jQuery(document).ready(function(){ 
jQuery(function() {
		    var header = jQuery('#header');
		    var navHomeY = header.offset().top;
		    var isFixed = false;
		    var $w = jQuery(window);
		    $w.scroll(function(e) {
		        var scrollTop = $w.scrollTop();
		        var shouldBeFixed = scrollTop > <?php echo $scrolls_value; ?>;
		        if (shouldBeFixed && !isFixed) {
		            header.addClass('sticky');
		            isFixed = true;
		           
		        }
		        else if (!shouldBeFixed && isFixed)
		        {
		            header.removeClass("sticky");
		            isFixed = false;
		        }
		        e.preventDefault();
		    });
		});
	});
  

<?php
}

$out = ob_get_contents();

file_put_contents(get_template_directory(). '/js/dynjs.js', $out);

ob_end_clean();


?>