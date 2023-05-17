<?php 

    date_default_timezone_set("Asia/Tokyo");
    $comment_array = array();
    $error_messages = array();

    try{
        $pdo = new PDO('mysql:host=localhost;dbname=php_tutorial', "root", "root");
        } catch(PDOException $e){
            echo $e->getMessage();
        }

    try{
        if(!empty($_POST["submitButton"])){

            if(empty($_POST['username'])){
                echo "enter the name";
                $error_messages['username'] = "enter the name";
            }

            if(empty($_POST['comment'])){
                echo "enter the comment";
                $error_messages['comment'] = "enter the name";
            }

            if(empty($error_messages)){
                $postdate = date("Y-m-d H:i:s");
    
                $stmt = $pdo->prepare("INSERT INTO `php_tutorial_table` (`username`, `comment`, `postDate`) VALUES (:username, :comment, :postDate)");
                $stmt->bindParam(':username', $_POST['username'], PDO::PARAM_STR);
                $stmt->bindParam(':comment',$_POST['comment'], PDO::PARAM_STR);
                $stmt->bindParam(':postDate',$postdate, PDO::PARAM_STR);
        
                $stmt->execute();
            }
           
    
        }
    }catch (PDOException $e){
        echo $e->getMessage();
    }
    
    
    $sql = "SELECT `id`, `username`, `comment`, `postDate` FROM `php_tutorial_table`";
    $comment_array = $pdo->query($sql);

    $pdo = null;

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PHP掲示板</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1 class="title">PHPで掲示板アプリ</h1>
    <hr>
    <div class="boardWrapper">
        <section>
            <?php foreach ($comment_array as $comment) : ?>
                <article>
                    <div class="wrapper">
                        <div class="nameArea">
                            <span>名前：</span>
                            <p class="username"><?php echo $comment["username"]; ?></p>
                            <time>:<?php echo $comment["postDate"]; ?></time>
                        </div>
                        <p class="comment"><?php echo $comment["comment"]; ?></p>
                    </div>
                </article>
            <?php endforeach; ?>
        </section>
        <form method="POST" action="" class="formWrapper">
            <div>
                <input type="submit" value="書き込む" name="submitButton">
                <label for="usernameLabel">名前：</label>
                <input type="text" name="username">
            </div>
            <div>
                <textarea name="comment" class="commentTextArea"></textarea>
            </div>
        </form>
    </div>

</body>
</html>