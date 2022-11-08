$(function() {

    
    $('.tombolTambahData').on('click', function(){
        $('#formMahasiswaModalLabel').html('Tambah Data Mahasiswa');
        $('.modal-footer button[type=submit]').html('Tambah Data');
    }); 
    $('.tampilModalUbah').on('click', function(){
        $('#formMahasiswaModalLabel').html('Ubah Data Mahasiswa');
        $('.modal-footer button[type=submit]').html('Ubah Data');
        $('.modal-body form').attr('action', 'http://localhost:8888/phpcrud/public/mahasiswa/ubah');

        const id = $(this).data('id');
        // console.log(id);

        $.ajax({
            url: 'http://localhost:8888/phpcrud/public/mahasiswa/getubah',
            data: {id: id},
            method: 'post',
            dataType: 'json',
            success: function(data){
                $('#nama').val(data.nama);
                $('#nrp').val(data.nrp );
                $('#email').val(data.email);
                $('#jurusan').val(data.jurusan);
                $('#id').val(data.id);
            }
        });
    }); 

});