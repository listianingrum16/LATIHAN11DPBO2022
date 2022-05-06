<?php

include("conf.php");
include("includes/Template.class.php");
include("includes/DB.class.php");
include("includes/Member.class.php");

$member = new Member($db_host, $db_user, $db_pass, $db_name);
$member->open();
$member->getMember();

if(isset($_POST['add'])) {
    //memanggil add
    $member->add($_POST);
    header("location:member.php");
}

//mengecek apakah ada id_hapus, jika ada maka memanggil fungsi delete
if (!empty($_GET['id_hapus'])) {
    //memanggil add
    $id = $_GET['id_hapus'];
    $member->delete($id);
    header("location:member.php");
}

$form_add =
    '<div class="col-lg-3 col-md-3 col-sm-12 col-12 mx-auto my-5">
        <h1 class="text-center pt-3">Input Member</h1>
        <form action="member.php" method="POST">
            <div class="form-row">
                <div class="form-group mt-3">
                    <label for="tnim">NIM</label>
                    <div class="d-flex">
                        <input type="text" class="form-control" name="tnim" required />
                    </div>
                    <label for="tnama">Nama</label>
                    <div class="d-flex">
                        <input type="text" class="form-control" name="tnama" required />
                    </div>
                    <label for="tjurusan">Jurusan</label>
                    <div class="d-flex">
                        <input type="text" class="form-control" name="tjurusan" required />
                        <button type="submit" name="add" class="btn btn-primary" style="margin-left: 20px;">Add</button>
                    </div>
                </div>
            </div>
        </form>
    </div>';

$data = null;
$no = 1;
    
while (list($nim, $nama, $jurusan) = $member->getResult()) {
    $data .= "<tr>
        <td>" . $no++ . "</td>
        <td>" . $nim . "</td>
        <td>" . $nama . "</td>
        <td>" . $jurusan . "</td>
        <td>
        <a href='member.php?id_edit=" . $nim .  "' class='btn btn-warning''>Edit</a>
        <a href='member.php?id_hapus=" . $nim . "' class='btn btn-danger''>Hapus</a>
        </td>
    </tr>";
}

$member->close();
$tpl = new Template("templates/member.html");
$tpl->replace("DATA_TABEL", $data);


if (isset($_GET['id_edit'])) {
    $temp_member = new Member($db_host, $db_user, $db_pass, $db_name);
    $temp_member->open();
    $temp_member->getMember();
    $update = $temp_member->getResult();

    $id = $_GET['id_edit'];

    //$nim = $update['nim'];
    $nama = $update['nama'];
    $jurusan = $update['jurusan'];

    $form_update =
    '<div class="col-lg-3 col-md-3 col-sm-12 col-12 mx-auto my-5">
        <h1 class="text-center pt-3">Update Member</h1>
        <form action="member.php" method="POST">
            <div class="form-row">
                <div class="form-group mt-3">
                    <label for="tnim">NIM</label>
                    <div class="d-flex">
                        <input type="text" class="form-control" name="tnim" required />
                    </div>
                    <label for="tnama">Nama</label>
                    <div class="d-flex">
                        <input type="text" class="form-control" name="tnama" required />
                    </div>
                    <label for="tjurusan">Jurusan</label>
                    <div class="d-flex">
                        <input type="text" class="form-control" name="tjurusan" required />
                        <button type="submit" name="update" class="btn btn-primary" style="margin-left: 20px;">Update</button>
                    </div>
                </div>
            </div>
        </form>
    </div>';

    if(isset($_GET['update'])){
        $temp_member->update($_POST, $id);
        $temp_member->close();
        header("location:member.php");
    }
    $tpl->replace("FORM", $form_update);
}
else{
    $tpl->replace("FORM", $form_add);
}
$tpl->write();
