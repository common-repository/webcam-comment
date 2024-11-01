<?php
/*
Plugin Name: CamComment
Description: Lets the user attach webcam images to comments
Author: Gerhard
Version: 0.2
*/


//Global variables (for easier editing)
$thumbWidth = 48;
$thumbHeight = 36;
$filePath = "wp-content/plugins/webcam-comment/camcommentimages/";  //This is where images will be stored


//All actions and filters
add_action('comment_form', 'AddCamInterface');
add_action('comment_post', 'SaveImage');
add_action('delete_comment', 'DeleteImage');
add_filter('get_avatar', 'AddImageToCurrentComment');


//Saves the image and a thumbnail
function SaveImage($commentID)
{

	if($_POST['pixels'] != null)
	{
	
		//Get globals
		global $thumbWidth, $thumbHeight, $filePath;
	
		//Gets the imagedata
		$pixels = explode(",", $_POST['pixels']);
		$width = $_POST['width'];
		$height = $_POST['height'];
		
		//Loops through the imagedata and creates an image
		$image = @imagecreatetruecolor( $width ,$height );
		$index = 0;
		for($x=0; $x<=$width; $x++)
		{
			for($y=0; $y<=$height; $y++)
			{
				$r = hexdec("0x".substr( $pixels[$index] , 2 , 2 ));
				$g = hexdec("0x".substr( $pixels[$index] , 4 , 2 ));
				$b = hexdec("0x".substr( $pixels[$index] , 6 , 2 ));
				$color = imagecolorallocate($image, $r, $g, $b);
				
				imagesetpixel ($image,$x,$y,$color);
				
				$index++;
			}
	
		}
	
		//Saves the jpeg
		imagejpeg($image, $filePath . $commentID . ".jpg");
		
		
		//Makes a thumbnail
		$thumbnail=imagecreatetruecolor($thumbWidth,$thumbHeight);
		imagecopyresampled($thumbnail,$image,0,0,0,0,$thumbWidth,$thumbHeight,$width,$height);
	
		//Saves the thumbnail
		imagejpeg($thumbnail, $filePath. "thumbs/" . $commentID . ".jpg");
		
		//removes temporary images
		imagedestroy($image);
		imagedestroy($thumbnail);

	
	}
}



function DeleteImage($commentID)
{
	global $filePath;

	$filepathImage = "../". $filePath . $commentID . ".jpg";
	$filepathThumb = "../" . $filePath. "thumbs/" . $commentID . ".jpg";

	if(file_exists($filepathImage))
	{	
		unlink($filepathImage);
		unlink($filepathThumb);
	}	
}





//Adds the interface for the webcam

function AddCamInterface()
{

?>


	<div id="CamInterface" style="margin-top: 5px; margin-bottom: 5px;">
	<label
	style="background-color: #f8f8f8;
	border-top: 1px solid #ddd;
	border-bottom: 1px solid #ddd;;
	padding-right: 10px;
	padding-left: 3px;
	font-size: 10px;
	color: gray;
	width: 200px;
	margin-bottom: 1px;
	" onclick="ShowAndHideWebCamObject()" for="CamGrabber">Click to attach webcam image &gt;&gt; </label>
		 <object style="display:none;" classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000'
				id='CamGrabber' width='340' height='300'
				codebase='http://fpdownload.macromedia.com/get/flashplayer/current/swflash.cab'>
				<param name='movie' value='wp-content/plugins/webcam-comment/CamGrabber.swf' />
				<param name='quality' value='high' />
				<param name='bgcolor' value='#bbbbbb' />
				<param name='allowScriptAccess' value='sameDomain' />
				<embed src='wp-content/plugins/webcam-comment/CamGrabber.swf' quality='high' bgcolor='#bbbbbb'
					width='340' height='300' name='CamGrabber' align='middle'
					play='true'
					loop='false'
					quality='high'
					allowScriptAccess='sameDomain'
					type='application/x-shockwave-flash'
					pluginspage='http://www.adobe.com/go/getflashplayer'>
				</embed>
		</object>
		
		<input name='pixels' id='pixels' value='' type='hidden'>
		<input name='height' id='height' value='' type='hidden'>
		<input name='width' id='width' value='' type='hidden'>
	</div>
	
	
	<script language="javascript">
		
		/* This function is called by the ActionScript, do not edit! */
		function AppendImageData(pixels, height, width)
		{	
			document.getElementById("pixels").value = pixels;
			document.getElementById("height").value = height;
			document.getElementById("width").value = width;
			
			return "true";
	
		}
		function RemoveImageData()
		{	

	     	document.getElementById("pixels").value = "";
	     	document.getElementById("height").value = "";
	     	document.getElementById("width").value = "";

		}
		
		
		function ShowAndHideWebCamObject() {
		
			if(document.getElementById("CamGrabber").style.display == "block")
			{
				document.getElementById("CamGrabber").style.display = "none";
			}
			else
			{
				document.getElementById("CamGrabber").style.display = "block"
			}
			
			
		}
		
		
		/* These are needed to position the cam interface. Change the position by changing "document.getElementById("comment");" */
		var elementAfterCamInterface = document.getElementById("comment");
		var elementBeforeCamInterfaceParent = elementAfterCamInterface.parentNode;
		var camInterface = document.getElementById("CamInterface");
		elementBeforeCamInterfaceParent.insertBefore(camInterface, elementAfterCamInterface);
		
	
	</script>
<?php


}


//If there is a webcam image it will override the default image
function AddImageToCurrentComment($avatar)
{
	global $filePath;


	$filepathImage = $filePath . get_comment_ID() . ".jpg";
	$filepathThumb = $filePath . "/thumbs/" . get_comment_ID() . ".jpg";

	if(file_exists($filepathImage))
	{	
		$avatar = "<a href=". $filepathImage ." rel='lightbox[". get_comment_ID() . "]'><img alt='' src='" . $filepathThumb . "' class='avatar'></a>";
	}	
	return $avatar;
	
	


}




?>