<?php
$servername="localhost";
$username="root";
$password="";
$database="crud";
$connect=mysqli_connect($servername,$username,$password,$database);
if(!$connect){
    die("error connecting page due to ").mysqli_connect_error();
}

if($_SERVER['REQUEST_METHOD']=='GET'){
  if(isset($_GET['doneEdit'])){
    $titleEdit=$_GET['titleEdit'];
    $descriptionEdit=$_GET['descriptionEdit'];
    $sno=$_GET['snoEdit'];
    $mysql="UPDATE `notes` SET `Title`='$titleEdit',`Description`='$descriptionEdit' WHERE `S.NO`= $sno";
    $result=mysqli_query($connect,$mysql);
    header('location:crud.php');
  }
}


else if($_SERVER['REQUEST_METHOD']=='POST'){
  if(isset($_POST['done'])){
    if($_SERVER['REQUEST_METHOD']=='POST'){
      $title=$_POST['title'];
      $description=$_POST['description'];
      $mysql="INSERT INTO `notes`(`Title`, `Description`) VALUES ('$title','$description')";
      $result=mysqli_query($connect,$mysql);
      if(!$result){
        echo("error inserting data <br>").mysqli_erro($connect);
      }
   }
  }
}
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
  <link rel="stylesheet" href="//cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">

  <style>
    #editButton,
    #deleteButton {
      text-decoration: none;
      background-color: #0d6efd;
      border-radius: 3px;
      text-align: center;
      color: white;
      padding: 5px;
    }
  </style>
  <title>MyNotes</title>
</head>

<body>
  <!-- Modal -->
  <div class="modal fade" id="Modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="/crud/crud.php" method="GET">
            <div class="mb-3">
              <label for="titleEdit" class="form-label">Title</label>
              <input type="text" class="form-control" name="titleEdit" id="titleEdit" aria-describedby="emailHelp">
            </div>
            <div class="mb-3">
              <label for="descriptionEdit" class="form-label">Descripiton</label>
              <textarea name="descriptionEdit" class="form-control" id="descriptionEdit" cols="30" rows="3"></textarea>
              <input type="number" id="snoEdit" name="snoEdit" style="margin-top:5px;border-radius:3px; border:1px solid black;" readonly>
            </div>
            <button type="submit" class="btn btn-primary" id="doneEdit" name="doneEdit">Update</button>
          </form>
        </div>
      </div>
    </div>
  </div>








  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
      <h3 class="navbar-brand" style="font-size: 35px; font-weight: 200;">MyNotes</h3>
    </div>
  </nav>

  <div class="container">
    <h2 style="font-weight: 300;margin-top: 20px;">Add Your Notes</h2>
    <form action="/crud/crud.php" method="POST">
      <div class="mb-3">
        <label for="title" class="form-label">Title</label>
        <input type="text" class="form-control" name="title" id="title" aria-describedby="emailHelp">
      </div>
      <div class="mb-3">
        <label for="description" class="form-label">Descripiton</label>
        <textarea name="description" class="form-control" id="description" cols="30" rows="5"></textarea>
      </div>
      <button type="submit" class="btn btn-primary" name="done">Submit</button>
    </form>
  </div>
  <div class="container" style="margin-top:20px;">
    <table class="table" id="table">
      <thead>
        <tr>
          <th scope="col">S.NO</th>
          <th scope="col">TITLE</th>
          <th scope="col">DESCRIPTION</th>
          <th scope="col">ACTIONS</th>
        </tr>
      </thead>
      <tbody>
        <?php
      $mysql="SELECT * FROM `notes`";
      $result=mysqli_query($connect,$mysql);
      $i=1;
      while($rows=mysqli_fetch_assoc($result)){
          echo("<tr>
          <th scope='row'>".$i."</th>
          <td>".$rows['Title']."</td>
          <td>".$rows['Description']."</td>
          <td><a id='deleteButton' href='delete.php?id=".$rows['S.NO']."'>Delete</a><a id=".$rows['S.NO']." href='#'  onclick='edit(this)'  style='text-decoration: none;background-color: #0d6efd;border-radius: 3px;text-align: center;margin-left:2px;color: white;padding: 5px;'>Edit</a> </td>
        </tr>");
        $i+=1;
      }
      ?>
      </tbody>
    </table>
    <br>
    <hr>
  </div>
  <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
    integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js"
    integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT"
    crossorigin="anonymous"></script>
  <script src="//cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
  <script>
    $(document).ready(function () {
      $('#table').DataTable();
    });


    function edit(x){

      var title=x.parentNode.parentNode.cells[1].innerHTML;
      var description=x.parentNode.parentNode.cells[2].innerHTML;
      document.getElementById('titleEdit').value=title;
      document.getElementById('descriptionEdit').value=description;
      document.getElementById('snoEdit').value=x.id;
      console.log(x.id);
      $('#Modal').modal('toggle');
    }

  </script>
</body>

</html>