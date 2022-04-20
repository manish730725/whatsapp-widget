<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
require_once '../../../../wp-load.php';
global $wpdb;
$table_prefix = $wpdb->prefix;
$table_name = $table_prefix."whatsapp_widget";
$db = new mysqli("localhost",DB_USER,DB_PASSWORD,DB_NAME);

if($_POST['action'] == "create_data")
{   
    if(isset($_POST['show_off_on']))
    {
        $whatsapp_status = "active";
    }
    else{
        $whatsapp_status = "inactive";
    }
    $company_name = $_POST['company_name'];
    $phone_number = $_POST['phone_number'];


    $std_code = $_POST['std-code'];
    $country_short = $_POST['country-short'];
    $phone_code = array($country_short, $std_code);
    $phone_code = json_encode($phone_code);
    $logo_path =  logoUpload($_FILES['logo_path']);
    $sql = "INSERT INTO $table_name(`company_name`, `phone_number`,`phone_code`, `logo_path`,`whatsapp_status`) VALUES ('$company_name', '$phone_number','$phone_code', '$logo_path','$whatsapp_status')";
    if($db->query($sql) == true)
    {
        $_SESSION['success'] = "Whatsapp widget data inserted successfully";
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }
    else{
        $_SESSION['error'] = "Something went wrong !".$db->error;
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }
}


if($_POST['action'] == "update_data")
{   
    if(isset($_POST['show_off_on']))
    {
        $whatsapp_status = "active";
    }
    else{
        $whatsapp_status = "inactive";
    }
   
    $id = $_POST['post_id'];
    $company_name = $_POST['company_name'];
    $phone_number = $_POST['phone_number'];

    $std_code = $_POST['std-code'];
    $country_short = $_POST['country-short'];
    $phone_code = array($country_short, $std_code);
    $phone_code = json_encode($phone_code);
    
    $date = date('Y-m-d H:i:s');
    if(!empty($_FILES['logo_path']['name'])){
        $logo_path =  logoUpload($_FILES['logo_path']);
    }else{
        $logo_path = $_POST['old_image_path'];
    }
    $sql = "UPDATE $table_name SET `company_name`='$company_name',`phone_number`='$phone_number',`phone_code`='$phone_code',`logo_path`='$logo_path',`whatsapp_status`='$whatsapp_status',`updated_at`='$date' WHERE id='$id'";
    if($db->query($sql) == true)
    {
        $_SESSION['success'] = "Whatsapp widget data updated successfully";
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }
    else{
        $_SESSION['error'] = "Something went wrong !".$db->error;
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }
    
}

function logoUpload($path){
    $pluginFolderName = "whatsapp-widget";
    $uploads = wp_upload_dir();
    $upload_path = "../../../uploads/".$pluginFolderName;
    $imagename = uniqid();
    $ext = pathinfo($path['name'],PATHINFO_EXTENSION);
    $imagename = $imagename.".".$ext;
    if(file_exists($upload_path))
    {
      if(move_uploaded_file($path["tmp_name"], $upload_path."/".$imagename)) 
      {
         return $imagename;
      }
      else{
        $_SESSION['error'] = "Something went wrong !".$db->error;
        header('Location: ' . $_SERVER['HTTP_REFERER']);
      }
        
    }
    else{
        if(mkdir($upload_path, 0777, true))
        {
            if(move_uploaded_file($path["tmp_name"], $upload_path."/".$imagename)) 
            {
                return $imagename;
            }
            else{
                $_SESSION['error'] = "Something went wrong !".$db->error;
                header('Location: ' . $_SERVER['HTTP_REFERER']);
            }
        }
        else{
            $_SESSION['error'] = "Something went wrong !".$db->error;
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        }
    }
}


?>