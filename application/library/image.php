<?php

/** 
* Library Datatables 
*
* Library criada para não usar o código PHP do slim ou outros
* Author: Vlad
* 
**/

namespace Fyre\Library;

class Image {
    
    public function upload($file, $directory = ROOT . "public/static/images/", $new_path = null) {

        $allowedExts    = array("jpg", "jpeg", "gif", "png", "stl", "mp4");
        $extension      = explode(".", $file["name"]);
        $extension      = end($extension);

        if ($extension == "blob") {

            $extension = "png";
        }

        if (strpos($new_path, ".php") !== false) {

            return false;
        }

        if ($file["size"] < 10000000 && in_array($extension, $allowedExts)) {

            if ($file["error"] > 0) {
                
                return false;
    
            } else {

                if (!file_exists($directory)) {

                    // Criar a pasta se não existir
                    mkdir($directory, 0777, true);
                }

                if ($new_path === null) {

                    // Caminho final
                    $new_path = $directory . str_replace("/", "", md5(time() . rand(0, 100000)) . "." . strtolower($extension));                    
                
                } else {

                    $new_path = ROOT . "public" . $new_path;
                }

                // Upload do ficheiro
                move_uploaded_file($file["tmp_name"], $new_path);

                return $new_path;
            }
    
        } else {

            return false;
        }
    }

    
    function delete_file($s3, $path) {

        global $app;

        // Vereficar se temos um ficheiro no S3 ou no server local
        if (strpos($path, 'amazonaws.com') !== false) {

            // Definir a configuração no model S3 AWS
            $s3->_set($app->config);

            // Eliminar o ficheiro
            $s3->delete($path);

        } else {

            if (file_exists(ROOT . "public" . $path)) {

                unlink(ROOT . "public" . $path);
            }
        }
    }

    function scale_image($x, $y, $cx, $cy) {
    
        //Set the default NEW values to be the old, in case it doesn't even need scaling
        list($nx, $ny) = array($x, $y);
        
        //If image is generally smaller, don't even bother
        if ($x >= $cx || $y >= $cx) {
                
            //Work out ratios
            if ($x > 0) $rx = $cx / $x;
            if ($y > 0) $ry = $cy / $y;
            
            //Use the lowest ratio, to ensure we don't go over the wanted image size
            if ($rx > $ry) {
                
                $r = $ry;
                
            } else { 
                
                $r = $rx;
            }
            
            //Calculate the new size based on the chosen ratio
            $nx = intval($x * $r);
            $ny = intval($y * $r);
        }    
        
        //Return the results
        return array($nx, $ny);
    }

    function compress_image($path, $new_path, $new_width = 1500, $new_height = 1000) {

        $mime = getimagesize($path);
        if ($mime['mime'] == 'image/gif')   { return true; }
        if ($mime['mime'] == 'image/png')   { $src_img = imagecreatefrompng($path);  }
        if ($mime['mime'] == 'image/jpg')   { $src_img = imagecreatefromjpeg($path); }
        if ($mime['mime'] == 'image/jpeg')  { $src_img = imagecreatefromjpeg($path); }
        if ($mime['mime'] == 'image/pjpeg') { $src_img = imagecreatefromjpeg($path); }

        $old_x = imageSX($src_img);
        $old_y = imageSY($src_img);

        $size       = $this->scale_image($old_x, $old_y, 1920, 1080);
        $thumb_w    = $size[0];
        $thumb_h    = $size[1];

        $dst_img    =   ImageCreateTrueColor($thumb_w, $thumb_h);

        imagecolortransparent($dst_img, imagecolorallocate($dst_img, 0, 0, 0));
        imagealphablending( $dst_img, false );
        imagesavealpha( $dst_img, true );

        imagecopyresampled($dst_img, $src_img, 0, 0, 0, 0, $thumb_w, $thumb_h, $old_x, $old_y);


        if ($mime['mime'] == 'image/png')  { 

            if (!$this->hasTransparency($dst_img)) {

                $result = imagejpeg($dst_img, $new_path, 90);
                
            } else {

                $result = imagepng($dst_img,  $new_path, 9);  
            }
        }

        if ($mime['mime'] == 'image/jpg')  { $result = imagejpeg($dst_img, $new_path, 90); }
        if ($mime['mime'] == 'image/jpeg') { $result = imagejpeg($dst_img, $new_path, 90); }
        if ($mime['mime'] == 'image/pjpeg'){ $result = imagejpeg($dst_img, $new_path, 90); }

        imagedestroy($dst_img);
        imagedestroy($src_img);

        return $result;
    }

    function hasTransparency ($image) {

        if (!is_resource($image)) {
            throw new \InvalidArgumentException("Image resource expected. Got: " . gettype($image));
        }
        
        $shrinkFactor      = 64.0;
        $minSquareToShrink = 64.0 * 64.0;
        
        $width  = imagesx($image);
        $height = imagesy($image);
        $square = $width * $height;
        
        if ($square <= $minSquareToShrink) {
            [$thumb, $thumbWidth, $thumbHeight] = [$image, $width, $height];
        } else {
            $thumbSquare = $square / $shrinkFactor;
            $thumbWidth  = (int) round($width / sqrt($shrinkFactor));
            $thumbWidth < 1 and $thumbWidth = 1;
            $thumbHeight = (int) round($thumbSquare / $thumbWidth);
            $thumb       = imagecreatetruecolor($thumbWidth, $thumbHeight);
            imagealphablending($thumb, false);
            imagecopyresized($thumb, $image, 0, 0, 0, 0, $thumbWidth, $thumbHeight, $width, $height);
        }
        
        for ($i = 0; $i < $thumbWidth; $i++) { 
            for ($j = 0; $j < $thumbHeight; $j++) {
            if (imagecolorat($thumb, $i, $j) & 0x7F000000) {
                return true;
            }
            }
        }
        
        return false;
    }
}