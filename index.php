<?php
$insert=false;
$update=false;
$delete=false;
$servername="localhost:3306";
$username="root";
$password="";
$database="note";

$conn=mysqli_connect($servername,$username,$password,$database);

if(!$conn){
    die ("Database Connection is NOt Successfully Because-->".mysqli_connect_error());
}

if(isset($_GET['delete'])){
  $sno=$_GET['delete'];
  $delete=true;
  $sql="DELETE FROM `note1` WHERE `sno`=$sno";
  $result=mysqli_query($conn,$sql);

}
if($_SERVER['REQUEST_METHOD']=='POST'){
  if(isset($_POST['snoEdit'])){
//update the Record
      $sno=$_POST["snoEdit"];
      $title=$_POST["titleedit"];
      $description=$_POST["descriptionedit"];
      
      $sql="UPDATE `note1` SET `title` = '$title', `description` = '$description' WHERE `note1`.`sno` = $sno";
      $result=mysqli_query($conn,$sql);
      if($result){
        $update=true;
      }
      else {
        echo "not sucessfull";
      }
  }
  else {
    $title=$_POST["title"];
    $description=$_POST["description"];

  $sql="INSERT INTO `note1` ( `title`, `description`) VALUES ('$title', '$description')";
$result=mysqli_query($conn,$sql);
  }
if($result){
    //echo "The record has been inserted successfully! <br>";
    $insert=true;
}
else {
    echo "The record was not inserted successfully! because--->".mysqli_error($conn);
}
}
?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
    <title>iNotes - Notes taking made easy</title>
  
  </head>
  <body>
 <!-- Button trigger modal
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal">
Edit Modal
</button> -->

<!-- Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editModalLabel">Edit Note</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="/CRUD/index.php" method="POST">
      <div class="modal-body">
      <input type="hidden" name="snoEdit" id="snoEdit">
  <div class="mb-3">
    <label for="title" class="form-label"><h5>Note Title</h5></label>
    <input type="text" class="form-control" id="titleedit" name="titleedit" aria-describedby="emailHelp">
  </div>

  <div class="mb-3">
  <label for="description" class="form-label"><h5>Text Description</h5></label>
  <textarea class="form-control" id="descriptionedit" name="descriptionedit" rows="3"></textarea>
</div>
      </div>
      <div class="modal-footer d-block mr-auto" >
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="Submit" class="btn btn-primary">Save changes</button>
      </div>
      </form>
    </div>
  </div>
</div>

  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="#"><img src ="php_logo.png" alt="logo" height="39px"></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">

      <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">Home</a>
        </li>

        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">About </a>
        </li>
      
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">Contact Us </a>
        </li>

      <form class="d-flex">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Search</button>
      </form>
    </div>
  </div>
</nav>

<?php
if($insert)
echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
<strong>Success!</strong> Your note has been inserted Successfully.
<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
</div>";
?>
<?php
if($update)
echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
<strong>Success!</strong> Your note has been updated Successfully.
<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
</div>";
?>
<?php
if($delete)
echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>
<strong>Success!</strong> Your note has been deleted  Successfully.
<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
</div>";
?>

 <div class="container my-3">
   <ul><h2>Add a note</h2></ul>
 <form action="/CRUD/index.php" method="POST">
  <div class="mb-3">
    <label for="title" class="form-label"><h5>Note Title</h5></label>
    <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp">
  </div>

  <div class="mb-3">
  <label for="description" class="form-label"><h5>Text Description</h5></label>
  <textarea class="form-control" id="description" name="description" rows="3"></textarea>
</div>

  <button type="submit" class="btn btn-primary">Add Note</button>
</form>
 </div>

 <div class="contianer my-4">
  
  <table class="table" id="myTable">
  <thead>
    <tr>
      <th scope="col">S.No</th>
      <th scope="col">title</th>
      <th scope="col">Description</th>
      <th scope="col">Actions</th>
    </tr>
  </thead>
  <tbody>

  <?php
    $sql="SELECT * FROM `note1`";
    $result=mysqli_query($conn,$sql);
    $sno=0;
        while ($row=mysqli_fetch_assoc($result)) { 
      $sno=$sno+1;
      echo "<tr>
      <th scope='row'>".$sno. " </th>
      <td>".$row['title']. "</td>
      <td>".$row['description']. "</td>
      <td> <button class='edit btn btn-sm btn-primay' id =".$row['Sno'].
      ">Edit</button> <button class='delete btn btn-sm btn-primay' id =d".$row['Sno'].
      ">Delete</button></td>
      </tr>"; 
    }
    ?>
    
  </tbody>
</table>
 </div>
  <hr>
    
    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.js"integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
      crossorigin="anonymous"> </script>
    <script src="//cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>       
    <script>
    $(document).ready( function () {
    $('#myTable').DataTable();
    });
    </script>

<script>
      edits=document.getElementsByClassName('edit');
      Array.from(edits).forEach((element) => {
        element.addEventListener("click",(e) => {
          console.log("edit",); 
         tr = e.target.parentNode.parentNode;
         title=tr.getElementsByTagName("td")[0].innerText;
         description=tr.getElementsByTagName("td")[1].innerText;
        console.log(title,description);
        titleedit.value=title;
        descriptionedit.value=description;     
        snoEdit.value= e.target.id;
        console.log(e.target.id);
        $('#editModal').modal('toggle');
                })
                // $sql="INSERT INTO `note1` ( `title`, `description`) VALUES ('$title', '$description')";
      })

      deletes=document.getElementsByClassName('delete');
      Array.from(deletes).forEach((element) => {
        element.addEventListener("click",(e) => {
          console.log("edit",); 
         
        sno=e.target.id.substr(1,);
        if(confirm("Are you Sure you want to delete this Note!!")){
          console.log("yes");
          window.location=`/CRUD/index.php?delete=${sno}`;
          //TODO:  create a form post request to submit a form


        }
        else{
          console.log("No");
        }
                })
      })
    </script>
  </body>
</html>