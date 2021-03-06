<?php 
    session_start(); 
require_once('src/arsip.php');
$arsip = new Arsip($_REQUEST);


if(!$_SESSION['user_auth']) header('location:login.php');   
if($_SERVER['REQUEST_METHOD'] === 'POST'){
//	var_dump($_POST); die();
	if(isset($_POST['Tambah'])){
		$arsip->add();
	}else if (isset($_POST['Simpan'])){
		$arsip->update();
	}
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>Dashboard</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/dashboard.css" rel="stylesheet">
  </head>

  <body>
    <nav class="navbar navbar-toggleable-md navbar-inverse fixed-top bg-inverse">
      <button class="navbar-toggler navbar-toggler-right hidden-lg-up" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <a class="navbar-brand" href="#">Dashboard</a>

      <div class="collapse navbar-collapse" id="navbarsExampleDefault">
        <ul class="navbar-nav mr-auto">
            <a class="nav-link" href="#">Help</a>
        </ul>
        <form class="form-inline mt-2 mt-md-0 right" method="POST">
          <!-- <input class="form-control mr-sm-2" type="text" placeholder="Search"> -->
          <input type="hidden" value="logout" name="logout">
          <button class="btn btn-outline-danger my-2 my-sm-0" type="submit">Logout</button>
        </form>
      </div>
    </nav>

    <div class="container-fluid">
      <div class="row">
        <nav class="col-sm-3 col-md-2 hidden-xs-down bg-faded sidebar">
          <ul class="nav nav-pills flex-column">
            <li class="nav-item">
              <a class="nav-link active" href="#">Berkas <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="?page=tambah">Tambah Arsip</a>
            </li>
            <li class="nav-item" style="display:none">
              <a class="nav-link" href="?page=import"> Pengaturan </a>
            </li>
          </ul>
        </nav>

        <main class="col-sm-9 offset-sm-3 col-md-10 offset-md-2 pt-3">
          <h2>Daftar Berkas</h2>
          <hr>
<?php if ($_REQUEST['edit']) {
              $val = $arsip->first($_REQUEST['edit']);
          } ?>
          <?php if ($_GET['page']  === 'tambah' OR $_REQUEST['edit']): ?>
          <form class="col-md-6" method="post">
      			<div class="form-group">
					<label class="form-label"> Nama </label>
					<input type="text" name="nama" value="<?= $val->nama ?>" placeholder="Nama" class="form-control" />
				</div> 
      			<div class="form-group">
					<label class="form-label"> NIP </label>
					<input type="text" name="nip"  value="<?= $val->nip ?>" placeholder="Nomor Induk Pegawai" value="" class="form-control" />
				</div> 
      			<div class="form-group">
					<label class="form-label"> Golongan/Pangkat </label>
					<input type="text" name="pangkat" placeholder="Golongan" value="<?= $val->pangkat ?>"  class="form-control" />
				</div> 
      			<div class="form-group">
					<label class="form-label"> No.Telepon </label>
					<input type="text" name="phone" placeholder="+62810000000"  value="<?= $val->phone ?>" class="form-control" />
				</div> 
				<input type="hidden" value="<?= $val->id ?>" name="oldid" /> 
            <input type="submit" class="btn btn-success" name="<?= $_REQUEST['edit'] ? 'Simpan' : 'Tambah' ?>" >
          </form>
        <?php endif ?>
          <?php if($_GET['page'] === 'import'): ?>
          
<form  method="post" class="form-inline" method="post" enctype="multipart/form-data">
    <input type="file" class="form-control" name="excelfile" >
    <input type="submit" value="Import" class="btn btn-warning">
</form>

          <?php endif ?>
          <hr>
          <div class="table-responsive">
<table class="table table-striped">
    <thead>
        <th> NIP </th>
        <th> NAMA </th>
        <th> Golongan/Pangkat </th>
        <th> No Telepon </th>
		<th> Status </th>
        <th class="text-center"> * </th>
    </thead>

    <tbody>
        <?php 
			  $data = $arsip->getAll();
			if(!is_null($data)){
            foreach($data as $d) {
         ?>    
        <tr> 
            <td><?= $d->nip ?></td>
            <td><?= $d->nama ?></td>
            <td><?= $d->pangkat ?></td>
			<td><?= $d->phone ?></td>
			<td><?= $d->status ?></td>
            <td class="text-center class="form-inline"">
              
              <form method="post">
              <input type="hidden" value="<?= $d->id ?>" name="delete">
              <button class="btn btn-danger btn-sm">Hapus</button> 
              <!-- <button class="btn btn-warning btn-sm">Edit</button> -->
              </form>

              <form method="post">
              <input type="hidden" value="<?= $d->id ?>" name="edit">
              <button class="btn btn-warning btn-sm">Edit</button> 
              <!-- <button class="btn btn-warning btn-sm">Edit</button> -->
              </form>
            </td>
        </tr>

        <?php  }} else {  ?>
          <tr class="text-center">
            <td colspan="5">
              <form>
                <input type="hidden" value="tambah" name="page">
                <label for="">
                Belum Ada Data, Silahkan 
                <input type="submit" class="btn btn-primary btn-sm" value="Tambah"> 
                Data
                </label>
              </form>
            </td>
		  </tr>
	<?php } ?>
    </tbody>
</table>
</div>

        </main>
      </div>
    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="js/jquery-slim.min.js" ></script>
    <script>window.jQuery || document.write('<script src="js/jquery.min.js"><\/script>')</script>
    <script src="js/tether.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>

