<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="styles.css">
    <title>BooksHaven</title>
  </head>
  <body>

    <h1>Admin</h1>

    <table>
      <tr>
        <th>Id</th>
        <th>Username</th>
        <th>Password</th>
      </tr>

      <?php
      $msg = "";

      // if upload button is pressed
  if (isset($_POST['upload'])) {

        // the path to store the uploaded image
        $target = "images/".basename($_FILES['image']['name']);

        // connect to the database...

        $db = mysqli_connect("localhost", "root", "", "books");

        // get all the submitted data from the form
        $image = $_FILES['image']['name'];
        $description = $_POST['description'];

        $sql = "INSERT INTO books (image, description) VALUES ('$image', '$description')";
        mysqli_query($db, $sql); //stores the submitted data into the database table: books

        //MOVE THE UPLOADED IMAGE INTO FOLDER
        if (move_uploaded_file($_FILES['tmp_name']['name'], $target )) {
          $msg = "Image uploades successfully";
        } else {
          $msg = "There was a problem uploading image";
        }


      }





      $conn = mysqli_connect("localhost", "root", "", "admin_users");
      if ($conn-> connect_error){
        die("Connection failed:". $conn-> connect_error);
      }

      $sql = "SELECT id, username, password from admin_users";
      $result = $conn-> query($sql);

      if ($result-> num_rows > 0) {
        while ($row = $result-> fetch_assoc()) {
          echo "<tr><td>". $row["id"] ."</td><td>". $row["username"] ."</td><td>". $row["password"] ."</td></tr>";
        }
        echo "</table>";
      }
      else {
        echo "0 result";
      }

      $conn-> close();
       ?>
    </table>


    <div id="content">
      <form class="" action="index.html" method="post" enctype="multipart/form-data">
        <input type="hidden" name="size" value="1000000">
        <div>
          <input type="file" name="image">
        </div>
        <div>
          <textarea name="description" rows="4" cols="40" placeholder="Say something.."></textarea>
        </div>
        <div>
          <input type="submit" name="upload" value="Upload book">

        </div>

      </form>

    </div>

  </body>
</html>
