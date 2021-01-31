<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/styles.css">
    <title>BooksHaven</title>
  </head>
  <body>

    <h1>Admin</h1>

    <table>
      <tr>
        <th>Id</th>
        <th>Name</th>
        <th>E-mail</th>
        <th>Password</th>
      </tr>

      <?php
      $msg = "";

      // if upload button is pressed
  if (isset($_POST['upload'])) {

        // the path to store the uploaded image
        $target = "../images/".basename($_FILES['book_image']['name']);

        // connect to the database...
        $db = mysqli_connect("localhost", "root", "", "bookshaven");

        // get all the submitted data from the form
        $book_title = $_POST['book_title'];
        $book_qty = $_POST['book_qty'];
        $book_price = $_POST['book_price'];
        $book_desc = $_POST['book_desc'];
        $book_image = $_FILES['book_image']['name'];



        $sql = "INSERT INTO books (book_title, book_qty, book_price, book_desc, book_image) VALUES ('$book_title', '$book_qty', '$book_price', '$book_desc', '$book_image')";
        mysqli_query($db, $sql); //stores the submitted data into the database table: books

        //MOVE THE UPLOADED IMAGE INTO FOLDER
        if (move_uploaded_file($_FILES['book_image']['tmp_name'], $target)) {
          $msg = "Image uploades successfully";
        } else {
          $msg = "There was a problem uploading image";
        }


      }
      // DISPLAY USERS
      $conn = mysqli_connect("localhost", "root", "", "bookshaven");
      if ($conn-> connect_error){
        die("Connection failed:". $conn-> connect_error);
      }

      $sql = "SELECT id, name, email, password from admin";
      $result = $conn-> query($sql);

      if ($result-> num_rows > 0) {
        while ($row = $result-> fetch_assoc()) {
          echo "<tr><td>". $row["id"] ."</td><td>". $row["name"] ."</td><td>". $row["email"] ."</td><td>". $row["password"] ."</td></tr>";
        }
        echo "</table>";
      }
      else {
        echo "0 result";
      }

      $conn-> close();
       ?>
   </table>

   <?php
    // display data
   $db = mysqli_connect("localhost", "root", "", "bookshaven");
   $sql = "SELECT * FROM books";
   $result = mysqli_query($db, $sql);
   while ($row = mysqli_fetch_array($result)) {
     echo "<div id='img_div'>";
      echo "<img src='../images/".$row['book_image']."'>";
      echo "<p>".$row['book_title']."</p>";
      echo "<p>".$row['book_desc']."</p>";
      echo "<p>".$row['book_price']."</p>";
      echo "<p>".$row['book_qty']."</p>";
     echo "</div>";
     // code...
   }

    ?>


    <div id="content">
      <form method="post" action="index.php" enctype="multipart/form-data">
        <input type="hidden" name="size" value="1000000">
        <div>
          <input type="file" name="book_image">
        </div>
        <div>
          <textarea name="book_desc" cols="40" rows="4" placeholder="Say something about the book.."></textarea>
        </div>
        <div>
          <textarea name="book_title" cols="40" rows="4" placeholder="Title of the book..."></textarea>
        </div>
        <div>
          <textarea name="book_price" cols="40" rows="4" placeholder="Price of the book.."></textarea>
        </div>
        <div>
          <textarea name="book_qty" cols="40" rows="4" placeholder="Quantity of the book.."></textarea>
        </div>

        <div>
          <input type="submit" name="upload" value="Upload Book">

        </div>

      </form>

    </div>

  </body>
</html>
