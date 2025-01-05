<?php
include_once __DIR__.'/../traits/SQLGetterSetter.trait.php';
class Post{
    use SQLGetterSetter;
    public static function registerpost($text,$image_temp){
        if(isset($_FILES['post_image'])){
            $author = Session::getUser()->getEmail();
            $image_name = md5($author . time()) . ".jpg";
            $image_path = get_config('upload_path') . $image_name;
            if(move_uploaded_file($image_temp, $image_path)){
                $insert_command = "INSERT INTO `posts` (`post_text`, `image_uri`, `like_count`, `uploaded_time`, `owner`)
                VALUES ('$text', 'https://git.selfmade.ninja/uploads/-/system/user/avatar/6326/avatar.png', '0', now(), '$author');(0.007 s)";
                $db = Database::getConnection();
                if($db->query($insert_command)){
                    $id =  msqli_insert_id($db);
                    return new Post($id);
                }
                else{
                    return false;
                }
            }

        }
        else{
            $e =  new Exception("Image not found");
            throw $e;
        }
        
    }
    public function __construct($id)
    {
        $this->id = $id;
        $this->conn = Database::getConnection();
        $this->table = "posts";
    }
    
    

}