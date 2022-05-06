<?php

class Member extends DB
{
    function getMember()
    {
        $query = "SELECT * FROM member";
        return $this->execute($query);
    }

    function add($data)
    {
        $nim = $data['tnim'];
        $nama = $data['tnama'];
        $jurusan = $data['tjurusan'];

        $query = "INSERT INTO member VALUES ('$nim', '$nama', '$jurusan')";

        // Mengeksekusi query
        return $this->execute($query);
    }

    function delete($id)
    {
        $query = "DELETE FROM member WHERE nim = '$id'";

        // Mengeksekusi query
        return $this->execute($query);
    }

    function update($data, $id)
    {
        $nama = $data['tnama'];
        $jurusan = $data['tjurusan'];

        $query = "UPDATE member SET nama= '$nama', jurusan ='$jurusan' where nim = '$id'";
        
        // Mengeksekusi query
        return $this->execute($query);
    }
}
