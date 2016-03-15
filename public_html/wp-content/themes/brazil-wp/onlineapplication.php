<?php

/*

Template Name: Online application

*/

//session_start();

get_header();
GLOBAL $webnus_options, $woocommerce;
	if( WC()->cart->get_cart_contents_count() == 0 ){
		$quote_tab = '<li>2. Quote</li>';
		$uploadFilesButton = '<button type="button" id="uploadFilesButton" class="yui3-button button alt" style="width:250px; height:35px;">Next Step</button>';
	}else{
		$cart_url = $woocommerce->cart->get_cart_url();
		$quote_tab = '<a href="'.$cart_url.'"><li>2. Quote</li></a>';
		$uploadFilesButton = '<button type="button" id="uploadFilesButton" class="yui3-button button alt pass" style="width:250px; height:35px;">Next Step</button>';
	}
//if( isset($_GET['reset']) )
	//$woocommerce->cart->empty_cart(); //clear cart when reupload
	
$last_time = get_the_time(' F Y');
$separate=( substr( get_permalink(), -1 ) == "/" ? "?" : "&" );

GLOBAL $webnus_page_options_meta;


$show_titlebar = null;
$titlebar_bg = null;
$titlebar_fg = null;
$have_sidebar = false;
$sidebar_pos = null;

$meta = $webnus_page_options_meta->the_meta();

if(!empty($meta)){
$show_titlebar =  isset($meta['webnus_page_options'][0]['show_page_title_bar'])?$meta['webnus_page_options'][0]['show_page_title_bar']:null;
$titlebar_bg =  isset($meta['webnus_page_options'][0]['title_background_color'])?$meta['webnus_page_options'][0]['title_background_color']:null;
$titlebar_fg =  isset($meta['webnus_page_options'][0]['title_text_color'])?$meta['webnus_page_options'][0]['title_text_color']:null;
$titlebar_fs =  isset($meta['webnus_page_options'][0]['title_font_size'])?$meta['webnus_page_options'][0]['title_font_size']:null;
$sidebar_pos =  isset($meta['webnus_page_options'][0]['sidebar_position'])?$meta['webnus_page_options'][0]['sidebar_position']:'right';
$have_sidebar = !( 'none' == $sidebar_pos )? true : false;

}
if($show_titlebar && ( 'show' == $show_titlebar)):
?>
<section id="headline" style="<?php

/// To change the title bar background color
if(!empty($titlebar_bg)) echo ' background-color:'.$titlebar_bg.';'; 

/// To change the title bar text color 


 ?>">
    <div class="container">
      <h3 style="<?php /* TEXT COLOR OF TITLE */ if(!empty($titlebar_fg)) echo ' color:'.$titlebar_fg.';'; if(!empty($titlebar_fs)) echo ' font-size:'.$titlebar_fs.';';  ?>"><?php the_title(); ?></h3>
      
    </div>
</section>
<?php if( 1 == $webnus_options->webnus_enable_breadcrumbs() ) { ?>
      <div class="breadcrumbs-w"><div class="container"><?php if('webnus_breadcrumbs') webnus_breadcrumbs(); ?></div></div>
<?php } ?>
<?php
endif;
?>

<?php
$step = $_GET['step'];
if($step == '')
	$step = 1;
?>

<!-- Start Dale addition 02-04-2015 -->
<!--section class="container">
  <div>
  <p style="font-size:1.3em;">If you are experiencing issues with our online quoting system, please send your files with <a href="https://www.wetransfer.com/?to=stl@3dprint-au.com&msg=Please%20provide%20a%20quote%20for%20the%20attached%20files.%20Add%20any%20other%20comments%20here" target="_blank" >wetransfer</a>.</p>
  </div>
</section-->
<!-- End Dale addition 02-04-2015 -->

<section id="main-content" class="container">
<div class="application-container" class="woocommerce">
<div class="process-tabs">
	<ul>
		<li class="active">1. Upload</li>
		<!--li>2. Quote</li-->
		<?php echo $quote_tab ?>
		<li>3. Address</li>
		<li>4. Payment</li>
		<li>5. All Done!</li>
	</ul>
</div>

<?php if($step == 1) : ?>

<div id="uploadContainer">
	<div class="message"></div>
	<form id="upload-files" method="post" action="<?php echo get_permalink().$separate; ?>step=2">
		<div id="uploaderContainer">
			<div class="emailRequest">
			<div class="input-text">
				<label for="email">Email <span class="redrisk">*</span></label>
				<input type="text" style="<?php if (isset($_SESSION['stlemail'])) {echo 'background-color:white';} else {echo 'background-color:yellow';} ?>" name="email" id="email" value="<?php echo $_SESSION['stlemail'] ?>" /> 
				<span class="required"></span>
			</div>
		</div>
			<div id="selectFilesButtonContainer">
			</div>
		<div class="input-radio">
			<input type="radio" class="select_unit" name="select_unit" id="mm" value="sq mm" checked /><label style="float: left;" for="mm">mm</label>
			<input type="radio" class="select_unit" name="select_unit" id="inch" value="sq. in." /><label style="float: left;" for="inch">inch</label>
			<input type="hidden" id="unit" name="unit" value="sq mm" />
			<input type="hidden" id="action" name="action" value="add_to_cart" />
		</div>
			
		
			<div id="overallProgress">
			</div>
		</div>

		<div id="filelist">
		  <table id="filenames">
			<thead>
				<tr id="message">
					<td colspan="3" id="details_message">
						
					</td>
				</tr>
				<tr>
					<th width="40%">File name</th>
					<th width="30%">File size</th>
					<th width="30%">Percent uploaded</th>
				</tr>

			</thead>
			<tbody>
			</tbody>
			<tfoot>
				<tr id="nofiles">
					<td colspan="3" id="ddmessage">
						<strong>No files selected.</strong>
					</td>
				</tr>
			</tfoot>
		  </table>
		</div>
		<div id="uploadFilesButtonContainer">
			<?php echo $uploadFilesButton ?>
			<!--button type="button" id="uploadFilesButton" class="yui3-button button alt" style="width:250px; height:35px;">Next Step</button-->
		</div>
	</form>
</div>

<script src="http://yui.yahooapis.com/3.18.1/build/yui/yui-min.js"></script>
<script>
jQuery(document).ready(function(){
	jQuery('.select_unit').live( 'change', function(){
		jQuery( "#unit" ).val( jQuery(".select_unit:checked").val() );
	});
});

YUI({filter:"raw"}).use("uploader", function(Y) {	
	
	//Y.one("#overallProgress").set("text", "Uploader type: " + Y.Uploader.TYPE);
	if (Y.Uploader.TYPE != "none" && !Y.UA.ios) {		
		var uploader = new Y.Uploader({width: "250px",
									  height: "35px",
									  selectButtonLabel: "Upload your 3D Models",
									  multipleFiles: true,
									  swfURL: "<?php echo site_url(); ?>/flashuploader.swf?t=" + Math.random(),
									  uploadURL: "<?php echo get_permalink().$separate; ?>task=stlupload&email="+document.getElementById('email').value + "&unit=" + document.getElementById('unit').value,
									  simLimit: 2,
									  withCredentials: false
									 });
		var uploadDone = false;
		var progressUpload = false;
		
		//alert( Y.Uploader.TYPE );
		if (Y.Uploader.TYPE == "html5") {
			uploader.set("dragAndDropArea", "body");
			uploader.render("#selectFilesButtonContainer");
			
			Y.one("#ddmessage").setHTML("<strong></strong>");

			uploader.on(["dragenter", "dragover"], function (event) {
				var ddmessage = Y.one("#ddmessage");
				if (ddmessage && Y.one("#nofiles")) {
					ddmessage.setHTML("<strong>Files detected, drop them here!</strong>");
					ddmessage.addClass("yellowBackground");
				}
			});

			uploader.on(["dragleave", "drop"], function (event) {
				var ddmessage = Y.one("#ddmessage");
				if (ddmessage && Y.one("#nofiles")) {
					ddmessage.setHTML("<strong> </strong>");
					ddmessage.removeClass("yellowBackground");
				}
			});
			
			/*uploader.on("drop", function (event) {
				var email=document.getElementById('email').value;
				if(email==''){
					var fileTable = Y.one("#filenames tbody");
					fileTable.setHTML("");
					uploader.set("fileList", []); //clear files
					alert("Please input the email to get upload !");
				}else
				uploader.uploadAll("<?php echo get_permalink().$separate; ?>task=stlupload&email="+email);			
			});*/
		}
		
		Y.Uploader = Y.UploaderFlash;
		
		
		uploader.render("#selectFilesButtonContainer");
	
		
		uploader.on("fileselect", function (event) {
			var email=document.getElementById('email').value;
			var maxSize = 1024*1024*25; //64MB
			if( (email=='') || (!valid_email_address(email)) ){
				uploader.set("fileList", []); //clear files
				var fileTable = Y.one("#filenames tbody");
				fileTable.setHTML("");
				var ddmessage = Y.one("#ddmessage");
				var details_message = Y.one("#details_message");
				if (ddmessage && Y.one("#nofiles")) {
					ddmessage.setHTML("<strong></strong>");
					ddmessage.removeClass("yellowBackground");
				}
								details_message.setHTML("<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>&times;</button><strong>Oh snap!</strong> You need to enter your email is valid before uploading STL files.</div>");
				
			}else{
				var fileList = event.fileList, newFileList = [];
				var fileTable = Y.one("#filenames tbody");
				
				Y.each(fileList, function (fileInstance) {
					var extension=fileInstance.get("name").split('.').pop();
					
					if( extension.toLowerCase() != "stl" && extension.toLowerCase() != "zip"){
						//alert("Oh snap! We only accept STL files, please email orders@3dprint-au.com if you have different files");
						var details_message = Y.one("#details_message");
						details_message.setHTML("<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>&times;</button><strong>Oh snap!</strong> We only accept STL and Zip files had contain STL file, please email orders@3dprint-au.com if you have different files</div>");
						//uploader.set("enabled", true);
					}					
					else if (fileInstance.get("size") > maxSize) {
						//alert( fileInstance.get("size") + " : " + maxSize );
						//alert( 'Max file size is 25MB, please send using wetransfer.com to orders@3dprint-au.com' );
						var details_message = Y.one("#details_message");
						details_message.setHTML("<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>&times;</button><strong>Oh snap!</strong> Max file size is 24MB, please send using wetransfer.com to orders@3dprint-au.com</div>");
					}else
						newFileList.push(fileInstance); //no error
						
				});
				uploader.set('fileList', newFileList);
				fileList = newFileList;
				
				//if exist product in list upload
				if (fileList.length > 0 && Y.one("#nofiles")) {
					//Y.one("#nofiles").remove();
				}
				
					
			  
				/* if (uploadDone) {
					uploadDone = false;
					fileTable.setHTML("");
				} */

				Y.each(fileList, function (fileInstance) {									
					fileTable.append("<tr id='" + fileInstance.get("id") + "_row" + "'>" +
										"<td class='filename'>" + fileInstance.get("name") + "</td>" +
										"<td class='filesize'>" + numberWithCommas( fileInstance.get("size") ) + "</td>" +
										"<td class='percentdone'><i class='vc_bar'>&nbsp;</i><span class='text'>Hasn't started yet</span></td>" );
				});
				
				if( fileList.length > 0 )
				uploader.uploadAll("<?php echo get_permalink().$separate; ?>task=stlupload&email="+email+"&unit="+document.getElementById('unit').value);	//upload files				 
				/*//ajax request
				jQuery.ajax({
					type:"POST", url: brazil_wp.ajaxurl, dataType: 'JSON',
					data: {
						'action' : 'clear_directory_before_upload',
						'email' : document.getElementById('email').value
					},
					success: function(data) { uploader.uploadAll("<?php echo get_permalink().$separate; ?>task=stlupload&email="+email+"&unit="+document.getElementById('unit').value);	},
					error: function(errorThrown){ //error }
				}); */
				
			}
		});
		
		
		uploader.on("uploadprogress", function (event) {
			if(jQuery("#" + event.file.get("id") + "_row").length > 0) {
				var fileRow = Y.one("#" + event.file.get("id") + "_row");
			
				if( fileRow.one(".percentdone .text").get("text") != 'Finished!' ){
					fileRow.one(".percentdone .text").set("text", event.percentLoaded + "%");
					fileRow.one(".percentdone .text").setStyle("color", "#000");
					fileRow.one(".percentdone .vc_bar").setStyle('width', event.percentLoaded + "%");
				}
			}			
		});

		uploader.on("uploadstart", function (event) {
			
			//uploader.set("enabled", false);
			Y.one("#uploadFilesButton").addClass("yui3-button-disabled");
			Y.one("#uploadFilesButton").setAttribute("disabled", "disabled");
			//Y.one("#uploadFilesButton").detach("click");
			progressUpload=true;
		});
		
		uploader.on("uploadcomplete", function (event) {
			if(jQuery("#" + event.file.get("id") + "_row").length > 0) {
				var fileRow = Y.one("#" + event.file.get("id") + "_row");
					fileRow.one(".percentdone .text").set("text", "Finished!");
					fileRow.one(".percentdone .text").setStyle("color", "inherit");
					fileRow.one(".percentdone .vc_bar").setStyle('display', "none");
			}
		});

		uploader.on("totaluploadprogress", function (event) {
			Y.one("#overallProgress").setHTML("Total uploaded: <strong>" +
													 event.percentLoaded + "%" +
													 "</strong>");
		});
		
		
		uploader.on("alluploadscomplete", function (event) {
			//uploader.set("enabled", true);
			
			//add all files to cart using ajax
			var filename=[];
			var i=0;
			Y.each(uploader.get("fileList"), function (fileInstance) {
				filename[i]=fileInstance.get("name");
				i++;
			});
			jQuery.ajax({
				type:"POST", url: brazil_wp.ajaxurl, dataType: 'JSON',
				data: {
					'action' : 'add_all_stl_files_to_cart',
					'email' : document.getElementById('email').value,
					'unit' : document.getElementById('unit').value,
					'filename' : filename
				},
				success: function(data) { 
					if(data.type == 'zip'){ 
						if(data.contain == false){
							var details_message = jQuery("#details_message");
							details_message.html("<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>&times;</button><strong>Oh snap!</strong> Your zip doesn't contain any STL files. We only accept STL and Zip files had contain STL file, please email orders@3dprint-au.com if you have different files</div>");
						}
					} 
				},
				error: function(errorThrown){ /*error*/ }
			}); 
			
			uploader.set("fileList", []); //clear fileList
			Y.one("#uploadFilesButton").removeClass("yui3-button-disabled");
			Y.one("#uploadFilesButton").removeAttribute("disabled");
			//Y.one("#uploadFilesButton").on("click", function () {
			//	if (!uploadDone && uploader.get("fileList").length > 0) {
			//		uploader.uploadAll();
			//	}
			//});
			Y.one("#overallProgress").set("text", "Uploads complete!");
			uploadDone = true;	
			progressUpload = false;
		}); 
		
		
		Y.one("#uploadFilesButton").on("click", function () {
			var email=document.getElementById('email').value;
			if( this.hasClass('pass')){
				jQuery("#upload-files").submit();
			}
			else if( !uploadDone && !progressUpload ){
				//alert("Please upload STL files before going to the next steps !");
				var details_message = Y.one("#details_message");
				details_message.setHTML("<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>&times;</button><strong>Oh snap!</strong> Please upload STL files or ZIP files had contain STL file before going to the next steps!</div>");
			}
			else if(email==''){
					var details_message = Y.one("#details_message");
					details_message.setHTML("<div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>&times;</button><strong>Oh snap!</strong> You need to enter your email before uploading files.</div>");
			}
			else{
			
				if( uploadDone && !progressUpload ){
					
					jQuery("#upload-files").submit();
					/*
					//setTimeout(function(){document.forms["upload-files"].submit();}, 3000);
					//Loading voi text "Processing files, please wait ..."
					jQuery('body').addClass("loading");
					var arequest=0;
					jQuery.when( jQuery.ajax({
						url:"index.php?email="+email+"&task=stlprocess&unit="+ document.getElementById('unit').value,  cache: false, async: false			    
					})).then(function( data, textStatus, jqXHR ) {
							producturl= data.split("|");
							var totalarequest=producturl.length-1;
						  for (var i = 0; i < producturl.length-1; i++) {
							   jQuery.when(jQuery.ajax({url: "index.php",type:'post',cache: false, async: false, data: jQuery.parseJSON(producturl[i])})).then(function( data, textStatus, jqXHR ) {arequest=arequest+1; if(arequest==totalarequest) {jQuery('body').removeClass("loading"); window.location="?page_id=1024";} ;});
						  }
					});*/
				}
			}
			//alert( 'button cliked' );
		});
		
		//uploader.set("fileFilters", [{description:"Images", extensions:"*.stl"}]);
		var fileFilters = new Array({description:"Images", extensions:"*.stl"}); 
 
		uploader.set("fileFilters", fileFilters);
		
	} else {
		Y.one("#uploaderContainer").set("text", "We are sorry, but to use the uploader, you either need a browser that support HTML5 or have the Flash player installed on your computer.");
	}


});
function number_format(number, decimals, dec_point, thousands_sep) {
	number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
	var n = !isFinite(+number) ? 0 : +number,
    prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
    sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
    dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
    s = '',
    toFixedFix = function(n, prec) {
      var k = Math.pow(10, prec);
      return '' + (Math.round(n * k) / k)
        .toFixed(prec);
    };
	// Fix for IE parseFloat(0.55).toFixed(0) = 0;
	s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
	if (s[0].length > 3) {
		s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
	}
	if ((s[1] || '').length < prec) {
		s[1] = s[1] || '';
		s[1] += new Array(prec - s[1].length + 1).join('0');
  }
  return s.join(dec);
}
function numberWithCommas(x) {
	//return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
	if( (x/(1024*1024)) >= 1 ){
		x = number_format((x / (1024*1024)),1);
		x = x.toString() + ' Mb';
	}
	else if( x/1024 >= 1 ){
		x = number_format((x / 1024),1);
		x = x.toString() + ' Kb';
	}
	else{
		x = x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
		x = x.toString() + ' Bytes';
	}
	return x;
}
/*validation email*/
function valid_email_address(email)
{
	var pattern = new RegExp(/^[+a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/i);
	return pattern.test(email);
}
</script>
<?php endif; ?>

</div>

</section>
<section class="blox  dark  " style=" padding-top:65px; padding-bottom:53px;  min-height:px; "><div class="max-overlay" style="opacity:1.0;background-color:"></div><div class="wpb_row vc_row-fluid full-row"><div class="container">
	<div class="vc_span12 wpb_column column_container">
		<div class="wpb_wrapper">
			<hr class="vertical-space1"><section class="wpb_row vc_row-fluid">
	<div class="vc_span6 wpb_column column_container">
		<div class="wpb_wrapper">
			<article class="icon-box"><i class="icomoon-thumbs-up" style=" color:#ffffff;"></i><h4><strong>Pricing</strong></h4><p>Our pricing couldn&#8217;t be any easier to work out. We charge by the bounding box of the shape, not by how much material is used. Or send us any quote and we&#8217;ll beat it with our Economy pricing. <em>&#8220;It&#8217;s like buying an esky and getting the beers for free.&#8221;</em></p></article><hr class="vertical-space2"><article class="icon-box"><i class="icomoon-factory" style=" color:#ffffff;"></i><h4><strong>Production Runs</strong></h4><p>The benefit of printing with SLS offers the ability to rapidly manufacture a volume of products without changing tools for every design interaction. 3D Printing one or a thousand parts will cost you the same for each part. That&#8217;s transparent pricing.</p></article>
		</div> 
	</div> 

	<div class="vc_span6 wpb_column column_container">
		<div class="wpb_wrapper">
			<article class="icon-box"><i class="icomoon-shield" style=" color:#ffffff;"></i><h4><strong>Benefits of SLS Nylon</strong></h4><p>Our industrial Elite Selective Laser Sintering machine makes functional parts that are durable, heat and chemical resistant with an excellent surface quality. Not only that, they are tough like a $2 steak!</p></article><hr class="vertical-space2"><article class="icon-box"><i class="icomoon-lock-2" style=" color:#ffffff;"></i><h4><strong>Secret Squirrel</strong></h4><p>When you upload your models to us, you enter into an NDA (Non Disclosure Agreement) with 3DPrint-AU. We take your IP (Intellectual Property) very seriously and will not share your designs with any third parties. <em>&#8220;Just don&#8217;t ask us to 3d print guns&#8221;</em></p></article>
		</div> 
	</div> 
</section><hr class="vertical-space1">
		</div> 
	</div> 
</div></div></section><section class="container"><div class="row-wrapper-x">

<div style="display: block !important; margin:0 !important; padding: 0 !important" id="wpp_popup_post_end_element"></div></div>
</section>

<?php get_footer(); ?>