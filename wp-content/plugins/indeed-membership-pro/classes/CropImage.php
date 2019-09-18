<?php
namespace Indeed\Ihc;

class CropImage
{
    private $response = array(
                "status"  => 'error',
                "message" => 'Error'
    );
    private $userMetaName = 'ihc_user_custom_banner_src';
    private $userId = 0;
    private $saveUserMeta = true;

    public function __construct()
    {
        global $current_user;
        $this->userId = empty($current_user->ID) ? 0 : $current_user->ID;
        require_once ABSPATH . 'wp-admin/includes/image.php';
        require_once ABSPATH . 'wp-admin/includes/file.php';
        require_once ABSPATH . 'wp-admin/includes/media.php';
    }

    public function setSaveUserMeta( $inputValue=true )
    {
        $this->saveUserMeta = $inputValue;
        return $this;
    }

    public function saveImage($filesData=array())
    {
        /*
        if (empty($this->userId)){
            $this->response = array(
                        "status"  => 'error',
                        "message" => 'User is not logged'
            );
            return $this;
        }
        */
        $inputName = 'img'; /// ihc_upload_image_top_banner

      	$allowedExts = array("gif", "jpeg", "jpg", "png", "GIF", "JPEG", "JPG", "PNG");
      	$temp = explode(".", $filesData[$inputName]["name"]);
      	$extension = end($temp);

        if ($filesData[$inputName]["error"] > 0){
          $this->response = array(
            "status"    => 'error',
            "message"   => 'ERROR Return Code: ' . $filesData[$inputName]["error"]
          );
          return $this;
        }
      	if (!in_array($extension, $allowedExts)){
          $this->response = array(
            "status"    => 'error',
            "message"   => 'Something went wrong. Try again!',
          );
          return $this;
      	}
        $filename = $filesData[$inputName]["tmp_name"];
        list($width, $height) = getimagesize( $filename );
        $uploadId = media_handle_upload($inputName, 0);

        if (!$uploadId){
          $this->response = array(
            "status"    => 'error',
            "message"   => 'Error - on save file',
          );
          return $this;
        }

		$fileUrl = wp_get_attachment_url( $uploadId );

        $this->response = array(
          "status"    => 'success',
          "url"       => $fileUrl,
          "width"     => $width,
          "height"    => $height,
          "uploadId"  => $uploadId,
        );
        return $this;
    }

    public function cropImage($postData=array())
    {

          $imgUrl = $postData['imgUrl'];
          // original sizes
          $imgInitW = $postData['imgInitW'];
          $imgInitH = $postData['imgInitH'];
          // resized sizes
          $imgW = $postData['imgW'];
          $imgH = $postData['imgH'];
          // offsets
          $imgY1 = $postData['imgY1'];
          $imgX1 = $postData['imgX1'];
          // crop box
          $cropW = $postData['cropW'];
          $cropH = $postData['cropH'];
          // rotation angle
          $angle = $postData['rotation'];
          //$output_filename = IHC_PATH . "croppedImg_" . time() . '_' . rand(1, 10000);

          // uncomment line below to save the cropped image in the same location as the original image.
          $uploadDirData = wp_upload_dir(date('Y/m'));
          $fileName = basename($imgUrl);
          $fileNameWithoutType = explode('.', $fileName);
          $fileNameWithoutTypeStr = isset($fileNameWithoutType[0]) ? $fileNameWithoutType[0] : $fileName;
          $output_filename = $uploadDirData['path'] . '/' . $fileNameWithoutTypeStr;
          $urlPath = $uploadDirData['url'];

          $what = getimagesize($imgUrl);

          switch(strtolower($what['mime'])){
              case 'image/png':
                  $img_r = imagecreatefrompng($imgUrl);
              		$source_image = imagecreatefrompng($imgUrl);
              		$type = '.png';
                  break;
              case 'image/jpeg':
                  $img_r = imagecreatefromjpeg($imgUrl);
              		$source_image = imagecreatefromjpeg($imgUrl);
              		$type = '.jpeg';
                  /// check if really is jpeg
                  $pieces = explode('.', $imgUrl);
                  end($pieces);
                  if ( current($pieces)=='jpg' ){
                      $type = '.jpg';
                  }
                  break;
              case 'image/gif':
                  $img_r = imagecreatefromgif($imgUrl);
              		$source_image = imagecreatefromgif($imgUrl);
              		$type = '.gif';
                  break;
              default:
                $this->response = array(
                            "status"  => 'error',
                            "message" => 'Image type not supported'
                );
                return $this;
          }


            // resize the original image to size of editor
            $resizedImage = imagecreatetruecolor($imgW, $imgH);
        	imagecopyresampled($resizedImage, $source_image, 0, 0, 0, 0, $imgW, $imgH, $imgInitW, $imgInitH);
            // rotate the rezized image
            $rotated_image = imagerotate($resizedImage, -$angle, 0);
            // find new width & height of rotated image
            $rotated_width = imagesx($rotated_image);
            $rotated_height = imagesy($rotated_image);
            // diff between rotated & original sizes
            $dx = $rotated_width - $imgW;
            $dy = $rotated_height - $imgH;
            // crop rotated image to fit into original rezized rectangle
        	$cropped_rotated_image = imagecreatetruecolor($imgW, $imgH);
        	imagecolortransparent($cropped_rotated_image, imagecolorallocate($cropped_rotated_image, 0, 0, 0));
        	imagecopyresampled($cropped_rotated_image, $rotated_image, 0, 0, $dx / 2, $dy / 2, $imgW, $imgH, $imgW, $imgH);
        	// crop image into selected area
        	$final_image = imagecreatetruecolor($cropW, $cropH);
        	imagecolortransparent($final_image, imagecolorallocate($final_image, 0, 0, 0));
        	imagecopyresampled($final_image, $cropped_rotated_image, 0, 0, $imgX1, $imgY1, $cropW, $cropH, $cropW, $cropH);
        	// finally output png image
        	//imagepng($final_image, $output_filename.$type, $png_quality);

           $rand = rand(1, 10000);
           $temporaryFileName = $output_filename . $rand . $type;
        	 imagejpeg( $final_image, $temporaryFileName, 100 );
          // $fileUrl = $urlPath . '/' . $fileNameWithoutTypeStr . $rand . $type;
          // $oldFileUrl = $urlPath . '/' . $fileNameWithoutTypeStr . $type;

          $filetype = wp_check_filetype( basename( $temporaryFileName ), null );
          $attachment = array(
          	'post_mime_type' => $filetype['type'],
          	'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $temporaryFileName ) ),
          	'post_content'   => '',
          	'post_status'    => 'inherit'
          );
          $uploadId = wp_insert_attachment( $attachment, $temporaryFileName, 0 );

          if ( !$uploadId ){
              $this->response = array(
          			"status"    => 'error',
                      "message"   => 'Error - on save file',
              );
              return $this;
          }
          $fileUrl = wp_get_attachment_url( $uploadId );
          require_once( ABSPATH . 'wp-admin/includes/image.php' );
          $attach_data = wp_generate_attachment_metadata( $uploadId, $temporaryFileName );
          wp_update_attachment_metadata( $uploadId, $attach_data );
          set_post_thumbnail( 0, $uploadId );

          /// remove old uncropped file
          if ( isset( $postData['uploadId'] ) ){
              wp_delete_attachment( $postData['uploadId'], true );
          }

          if ( $this->saveUserMeta ){
              update_user_meta( $this->userId, $this->userMetaName, $fileUrl );
          }

        	$this->response = array(
        	    "status"       => 'success',
        	    "url"          => $fileUrl,
              "uploadId"     => $uploadId,
          );

        return $this;
    }

    public function getResponse($asJson=true)
    {
        if ($asJson)
            return json_encode($this->response);
        else
            return $this->response;
    }

}
