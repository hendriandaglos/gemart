<?php include 'session_login.php';

                              
                              //memasukkan file session login, header, navbar, db
                              include 'header.php';
                              include 'navbar.php';
                              include 'db.php';
                              include 'sanitasi.php';

                              $session_id = session_id();
                              
//menampilkan seluruh data yang ada pada tabel pembelian
$perintah = $db->query("SELECT * FROM item_masuk");
                              


?>
                              
                              <!--membuat tampilan form agar terlihat rapih dalam satu tempat-->
                              <div class="container">
                              
                              
                              <!--membuat agar tabel berada dalam baris tertentu-->
                              <div class="row">
                              <!--membuat tampilan halaman menjadi 8 bagian-->
                              <div class="col-sm-8">
                              
                              <!-- membuat form menjadi beberpa bagian -->
                              <form enctype="multipart/form-data" role="form" action="form_item_masuk.php" method="post ">
                              
                              <!-- membuat teks dengan ukuran h3 -->
                              <h3> <u>FORM ITEM MASUK</u> </h3><br> 
                              
                              <!-- membuat agar teks tidak bisa di ubah, dan hanya bisa dibaca -->
                              <input type="hidden" name="session_id" id="session_id" class="form-control" readonly="" value="<?php echo $session_id; ?>" required="" >
                              
                              </form>
                              
                              
                              <!-- membuat tombol agar menampilkan modal -->
                              <button type="button" class="btn btn-info" id="cari_item_masuk" data-toggle="modal" data-target="#myModal"> <i class='fa fa-search'> </i> Cari</button>
                              <br><br>
                              <!-- Tampilan Modal -->
                              <div id="myModal" class="modal fade" role="dialog">
                              <div class="modal-dialog">
                              
                              <!-- Isi Modal-->
                              <div class="modal-content">
                              <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                              <h4 class="modal-title">Data Barang</h4>
                              </div>
                              <div class="modal-body"> <!--membuat kerangka untuk tempat tabel -->
                              
                              <span class="modal_baru">
 
  <div class="table-responsive">                             <!-- membuat agar ada garis pada tabel, disetiap kolom-->
 <table id="tableuser" class="table table-bordered">

        <thead> <!-- untuk memberikan nama pada kolom tabel -->
        
        <th> Kode Barang </th>
            <th> Nama Barang </th>
            <th> Harga Beli </th>
            <th> Harga Jual Level 1</th>
            <th> Harga Jual Level 2</th>
            <th> Harga Jual Level 3</th>
            <th> Jumlah Barang </th>
            <th> Satuan </th>
            <th> Kategori </th>
            <th> Status </th>
            <th> Suplier </th>
            <th> Foto </th>
        
        </thead> <!-- tag penutup tabel -->
        
        <tbody> <!-- tag pembuka tbody, yang digunakan untuk menampilkan data yang ada di database --> 
<?php


        
        $perintah = $db->query("SELECT * FROM barang WHERE berkaitan_dgn_stok = 'Barang' || berkaitan_dgn_stok = ''");
        
        //menyimpan data sementara yang ada pada $perintah
        while ($data1 = mysqli_fetch_array($perintah))
        {
        
        // menampilkan data
        echo "<tr class='pilih' data-kode='". $data1['kode_barang'] ."' nama-barang='". $data1['nama_barang'] ."'
        satuan='". $data1['satuan'] ."' harga='". $data1['harga_beli'] ."' jumlah-barang='". $data1['stok_barang'] ."'>
        
            <td>". $data1['kode_barang'] ."</td>
            <td>". $data1['nama_barang'] ."</td>
            <td>". rp($data1['harga_beli']) ."</td>
            <td>". rp($data1['harga_jual']) ."</td>
            <td>". rp($data1['harga_jual2']) ."</td>
            <td>". rp($data1['harga_jual3']) ."</td>";
            
            
// mencari jumlah Barang
            $query0 = $db->query("SELECT SUM(jumlah_barang) AS jumlah_pembelian FROM detail_pembelian WHERE kode_barang = '$data1[kode_barang]'");
            $cek0 = mysqli_fetch_array($query0);
            $jumlah_pembelian = $cek0['jumlah_pembelian'];

            $query1 = $db->query("SELECT SUM(jumlah) AS jumlah_item_masuk FROM detail_item_masuk WHERE kode_barang = '$data1[kode_barang]'");
            $cek1 = mysqli_fetch_array($query1);
            $jumlah_item_masuk = $cek1['jumlah_item_masuk'];

            $query2 = $db->query("SELECT SUM(jumlah_retur) AS jumlah_retur_penjualan FROM detail_retur_penjualan WHERE kode_barang = '$data1[kode_barang]'");
            $cek2 = mysqli_fetch_array($query2);
            $jumlah_retur_penjualan = $cek2['jumlah_retur_penjualan'];

            $query20 = $db->query("SELECT SUM(jumlah_awal) AS jumlah_stok_awal FROM stok_awal WHERE kode_barang = '$data1[kode_barang]'");
            $cek20 = mysqli_fetch_array($query20);
            $jumlah_stok_awal = $cek20['jumlah_stok_awal'];

            $query200 = $db->query("SELECT SUM(selisih_fisik) AS jumlah_fisik FROM detail_stok_opname WHERE kode_barang = '$data1[kode_barang]'");
            $cek200 = mysqli_fetch_array($query200);
            $jumlah_fisik = $cek200['jumlah_fisik'];
//total barang 1
            $total_1 = $jumlah_pembelian + $jumlah_item_masuk + $jumlah_retur_penjualan + $jumlah_stok_awal + $jumlah_fisik;


 

            $query3 = $db->query("SELECT SUM(jumlah_barang) AS jumlah_penjualan FROM detail_penjualan WHERE kode_barang = '$data1[kode_barang]'");
            $cek3 = mysqli_fetch_array($query3);
            $jumlah_penjualan = $cek3['jumlah_penjualan'];


            $query4 = $db->query("SELECT SUM(jumlah) AS jumlah_item_keluar FROM detail_item_keluar WHERE kode_barang = '$data1[kode_barang]'");
            $cek4 = mysqli_fetch_array($query4);
            $jumlah_item_keluar = $cek4['jumlah_item_keluar'];

            $query5 = $db->query("SELECT SUM(jumlah_retur) AS jumlah_retur_pembelian FROM detail_retur_pembelian WHERE kode_barang = '$data1[kode_barang]'");
            $cek5 = mysqli_fetch_array($query5);
            $jumlah_retur_pembelian = $cek5['jumlah_retur_pembelian'];


 



//total barang 2
            $total_2 = $jumlah_penjualan + $jumlah_item_keluar + $jumlah_retur_pembelian;

            $stok_barang = $total_1 - $total_2;
            
            
            
            
            
            echo "<td>". $stok_barang ."</td>
            <td>". $data1['satuan'] ."</td>
            <td>". $data1['kategori'] ."</td>
            <td>". $data1['status'] ."</td>
            <td>". $data1['suplier'] ."</td>
            
            <td><img src='save_picture/". $data1['foto'] ."' height='20px' width='40px' ></td>
            </tr>";
      
         }

?>
    
        </tbody> <!--tag penutup tbody-->
        
        </table> <!-- tag penutup table-->
        </div>
                              </span>
                              
                              </div> <!-- tag penutup modal body -->
                              
                              
                              <!-- tag pembuka modal footer -->
                              <div class="modal-footer">
                              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                              </div> <!--tag penutup moal footer -->
                              </div>
                              
                              </div>
                              </div>
                              
                              
                              <!-- membuat form -->
                              <form class="form-inline" action="proses_tbs_item_masuk.php" role="form" id="formtambahproduk">
                              
                              
                              <!-- agar tampilan berada pada satu group -->
                              <!-- memasukan teks pada kolom kode barang -->
                              <div class="form-group">
                              <input type="text" class="form-control" name="kode_barang" id="kode_barang" placeholder="Kode Produk" autocomplete="off">
                              </div>

                              <div class="form-group">
                              <input type="text" class="form-control" name="nama_barang" id="nama_barang" placeholder="Nama Barang" readonly="">
                              </div>
                              

                              
                              <div class="form-group">
                              <input type="text" class="form-control" name="jumlah_barang" id="jumlah_barang" placeholder="Jumlah Barang" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);">
                              </div>
                              
                              <br><br>
                              <div class="form-group">
                              <input type="text" class="form-control" name="hpp_item_masuk" id="hpp_item_masuk" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" placeholder="Hpp Item Masuk" autocomplete="off">
                              </div>
                              
                              
                              <!-- memasukan teks pada kolom satuan, harga, dan nomor faktur namun disembunyikan -->
                              <input type="hidden" id="satuan_produk" name="satuan" class="form-control" value="" required="">
                              <input type="hidden" id="harga_produk" name="harga" class="form-control" value="" required="">
                              <input type="hidden" name="session_id" id="session_id" class="form-control" value="<?php echo $session_id; ?>" required="" >
                              
                              <!-- membuat tombol submit-->
                              <button type="submit" id="submit_produk" class="btn btn-success"> <i class='fa fa-plus'> </i> Tambah Produk</button>
                              </form>
                              
                              
                              </div><!-- end of col sm 8 --> <!--tag penutup col sm 8-->

                              
                              <br><br><br>
                              <div class="col-sm-4" id="col_sm_4"> <!--tag pembuka col sm 4-->
                              
                              <form action="proses_bayar_item_masuk.php" id="form_item_masuk" method="POST"><!--tag pembuka form-->
                              
                              <label> Total </label><br>
                              <!--readonly = agar tek yang ada kolom total tidak bisa diubah hanya bisa dibaca-->
                              <input type="text" name="total" id="total_item_masuk" class="form-control" data-total="" placeholder="Total" readonly=""  >
                              
                              
                              <label> Keterangan </label><br>
                              <textarea name="keterangan" id="keterangan" class="form-control" ></textarea> 
                              
                              
                              <br>
                              
                              <input type="hidden" name="session_id" id="nomorfaktur" class="form-control" value="<?php echo $session_id; ?>">


                              <a class="btn btn-primary" href="form_item_masuk.php" id="transaksi_baru" style="display: none"> <span class='glyphicon glyphicon-repeat'> </span> Transaksi Baru</a>
                              <!--membuat tombol submit bayar & Hutang-->
                              <button type="submit" id="pembayaran_item_masuk" class="btn btn-info"> <i class='fa fa-send'> </i> Selesai </a> </button>
                              
                              
                              <!--membuaat link pada tombol batal-->
                              <a href='batal_item_masuk.php?session_id=<?php echo $session_id;?>' id='batal' class='btn btn-danger'><i class='fa fa-close'></i> Batal </a>
                              
                              
                              </form><!--tag penutup form-->
                              
                              <div class="alert alert-success" id="alert_berhasil" style="display:none">
                              <strong>Success!</strong> Data Item Masuk Berhasil
                              </div>
                              </div><!-- end of col sm 4 -->
                              </div><!-- end of row -->
                              
<!-- Modal Hapus data -->
<div id="modal_hapus" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Konfirmasi Hapus Data Item Masuk</h4>
      </div>

      <div class="modal-body">
   
   <p>Apakah Anda yakin Ingin Menghapus Data ini ?</p>
   <form >
    <div class="form-group">
    <label> Nama Barang :</label>
     <input type="text" id="hapus_nama" class="form-control" readonly=""> 
     <input type="hidden" id="id_hapus" class="form-control" > 
    </div>
   
   </form>
   
  <div class="alert alert-success" style="display:none">
   <strong>Berhasil!</strong> Data berhasil Di Edit
  </div>
 

     </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-info" id="btn_jadi_hapus"> <span class='glyphicon glyphicon-ok-sign'> </span> Ya</button>
        <button type="button" class="btn btn-warning" data-dismiss="modal"> <span class='glyphicon glyphicon-remove-sign'> </span> Batal</button>
      </div>
    </div>

  </div>
</div><!-- end of modal hapus data  -->

<!-- Modal edit data -->
<div id="modal_edit" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Edit Data Item Masuk</h4>
      </div>
      <div class="modal-body">
  <form role="form">
   <div class="form-group">
                  <label> Jumlah Barang Baru </label> <br>
                  <input type="text" name="jumlah_baru" id="edit_jumlah" class="form-control" autocomplete="off" required="" >

                  <input type="hidden" name="jumlah_lama" id="edit_jumlah_lama" readonly="">

                  <input type="hidden" name="harga" id="edit_harga">

                  <input type="hidden" class="form-control" id="id_edit">
                              
   </div>
   
   
   <button type="submit" id="submit_edit" class="btn btn-success">Submit</button>
  </form>
  <div class="alert alert-success" style="display:none">
   <strong>Berhasil!</strong> Data Berhasil Di Edit
  </div>

</div>

      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>

</div>

  </div>
</div><!-- end of modal edit data  -->

                              
                              
                              <!--untuk mendefinisikan sebuah bagian dalam dokumen-->  
                              <span id="result">  
                              
                              <div class="table-responsive">
                              <!--tag untuk membuat garis pada tabel-->     
                              <table id="tableuser" class="table table-bordered">
                              <thead>
                              <th> Kode Barang </th>
                              <th> Nama Barang </th>
                              <th> Jumlah </th>
                              <th> Satuan </th>
                              <th> Harga </th>
                              <th> Subtotal </th>
                              
                              <th> Hapus </th>
                              
                              </thead>
                              
                              <tbody>

                              <?php
                              
                              //menampilkan semua data yang ada pada tabel tbs penjualan dalam DB
                              $perintah = $db->query("SELECT * FROM tbs_item_masuk
                              WHERE session_id = '$session_id'");
                              
                              //menyimpan data sementara yang ada pada $perintah
                              
                              while ($data1 = mysqli_fetch_array($perintah))
                              {
                              //menampilkan data
                              echo "<tr class='tr-id-".$data1['id']."'>
                              <td>". $data1['kode_barang'] ."</td>
                              <td>". $data1['nama_barang'] ."</td>

                             <td class='edit-jumlah' data-id='".$data1['id']."'><span id='text-jumlah-".$data1['id']."'>". $data1['jumlah'] ."</span> <input type='hidden' id='input-jumlah-".$data1['id']."' value='".$data1['jumlah']."' class='input_jumlah' data-id='".$data1['id']."' autofocus='' data-subtotal='".$data1['subtotal']."' data-harga='".$data1['harga']."' data-faktur='".$data1['no_faktur']."' data-kode='".$data1['kode_barang']."' > </td>
                             

                              <td>". $data1['satuan'] ."</td>
                              <td>". rp($data1['harga']) ."</td>
                              <td><span id='text-subtotal-".$data1['id']."'>". rp($data1['subtotal']) ."</span></td>
                              
                              <td> <button class='btn btn-danger btn-hapus' id='btn-hapus-".$data1['id']."' data-id='". $data1['id'] ."' data-nama-barang='". $data1['nama_barang'] ."' data-subtotal='". $data1['subtotal'] ."' > <span class='glyphicon glyphicon-trash'> </span> Hapus </button> </td> 
                              </tr>";
                              }


                              //Untuk Memutuskan Koneksi Ke Database
                              
                              mysqli_close($db); 
                              ?>

                              </tbody>
                              
                              </table>
                              </div>
                              </span>
                              
                              
                              <span id="demo"> </span>

                              
                              </div><!-- end of container -->
                              
                              
                              <script>
                              //untuk menampilkan data tabel
                              $(document).ready(function(){
                              $('.table').dataTable();
                              });
                              
                              </script>
                              
                              <!--untuk memasukkan perintah java script-->
                              <script type="text/javascript">
                              
                              // jika dipilih, nim akan masuk ke input dan modal di tutup
                              $(document).on('click', '.pilih', function (e) {
                              document.getElementById("kode_barang").value = $(this).attr('data-kode');
                              document.getElementById("nama_barang").value = $(this).attr('nama-barang');
                              document.getElementById("satuan_produk").value = $(this).attr('satuan');
                              document.getElementById("harga_produk").value = $(this).attr('harga');
                              
                              
                              
                              $('#myModal').modal('hide');
                              });
                              
 
                              
                              
                              </script>
                              
                              
                              <script>
                              //untuk menampilkan data yang diambil pada form tbs penjualan berdasarkan id=formtambahproduk
                              $("#submit_produk").click(function(){

                                    var kode_barang = $("#kode_barang").val();
                                    var satuan = $("#satuan_produk").val();
                                    var nama_barang = $("#nama_barang").val();
                                    var harga = $("#harga_produk").val();
                                    var session_id = $("#session_id").val();
                                    var jumlah_barang = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#jumlah_barang").val()))));
                                    var hpp_item_masuk = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#hpp_item_masuk").val()))));
                                    var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total_item_masuk").val()))));
                              
                                        
                                        if (total == '') 
                                        {
                                        total = 0;
                                        }
                                        
                                        if (hpp_item_masuk == "") {
                                          harga = harga;
                                        }
                                        else{
                                          harga = hpp_item_masuk;
                                        }


                                        

                                        var sub_tbs = parseInt(harga,10) * parseInt(jumlah_barang,10);
                                        
                                        var subtotal = parseInt(total,10) + parseInt(sub_tbs,10);
                                        
                                        
                                        $("#kode_barang").val('');
                                        $("#nama_barang").val('');
                                        $("#jumlah_barang").val('');
                                        $("#hpp_item_masuk").val('');
                                        
                                    if (jumlah_barang == ""){
                                    alert("Jumlah Barang Harus Diisi");
                                    }
                                    else if (kode_barang == ""){
                                    alert("Kode Harus Diisi");
                                    }
                                    
                                    else
                                    {

                                      
                                      $("#total_item_masuk").val(tandaPemisahTitik(subtotal));

                                      
                                      $.post("proses_tbs_item_masuk.php",{hpp_item_masuk:hpp_item_masuk,session_id:session_id,kode_barang:kode_barang,jumlah_barang:jumlah_barang,satuan:satuan,nama_barang:nama_barang,harga:harga},function(info) {
                                      

                                      $("#result").load("tabel_item_masuk.php");
                                      $("#hpp_item_masuk").val('');
                                      $("#kode_barang").val('');
                                      $("#nama_barang").val('');
                                      $("#jumlah_barang").val('');
                                      
                                      });

                                    }
                              
                                      $("form").submit(function(){
                                      return false;
                                      });
                              
                              
                              
                                  });
                              
                                      //menampilkan no urut faktur setelah tombol click di pilih
                                      $("#cari_item_masuk").click(function() {
                                      $.get('no_faktur_IM.php', function(data) {
                                      /*optional stuff to do after getScript */ 
                                      $("#nomorfaktur").val(data);
                                      $("#nomorfaktur1").val(data);
                                      });
                                      //menyembunyikan notif berhasil
                                      $("#alert_berhasil").hide();
                                      /* Act on the event */
                                      
                                      $.get('modal_item_masuk_baru.php', function(data) {
                                      
                                      $(".modal_baru").html(data);
                                      
                                      
                                      });
                                      
                                      });
                                      
                                      
                              </script>
                              
                              <script>
                              
                              
                              //perintah javascript yang diambil dari form proses_bayar_beli.php dengan id=form_beli
                              $("#pembayaran_item_masuk").click(function(){
                              
                                    var total = $("#total_item_masuk").val();
                                    var keterangan = $("#keterangan").val();
                                    var session_id = $("#session_id").val();

                                    $("#keterangan").val('');
                                    $("#total_item_masuk").val('');
                              

                                    if (total == ""){
                                    alert("Tidak Ada Total Item Masuk");
                                    }

                                   
                                    else
                                    {

                                      $("#pembayaran_item_masuk").hide();
                                      $("#batal").hide();
                                      $("#transaksi_baru").show();


                              
                              $.post("proses_bayar_item_masuk.php",{session_id:session_id,total:total,keterangan:keterangan},function(info) {
                              
                              $("#demo").html(info);       
                              $("#result").load("tabel_item_masuk.php");
                              $("#alert_berhasil").show();
                              $("#total_item_masuk").val('');
                              $("#keterangan").val('');
                              
                              
                              
                              
                              });

                                }
                              
                              // #result didapat dari tag span id=result
                              
                              //mengambil no_faktur pembelian agar berurutan
                              
                              $("#form_item_masuk").submit(function(){
                              return false;
                              });
                              });
                              
                              
                              
                              </script>
                              
                              
                              <script>
                              
                              $(document).ready(function(){

                                var session_id = $("#session_id").val();

                              $.post("cek_total_item_masuk.php",
                              {
                              session_id: session_id 
                              },
                              function(data){
                              $("#total_item_masuk").val(data);
                              });
                              
                              });
                              
                              </script>
                              
                              
                              
          <script type="text/javascript">
            $(document).ready(function(){


//fungsi hapus data 
            $(document).on('click', '.btn-hapus', function (e) {
            var id = $(this).attr("data-id");
            var sub_total = $(this).attr("data-subtotal");
            var total = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total_item_masuk").val()))));

            if (total == '') 
              {
                total = 0;
              }
                                        
            else if (sub_total == '') {
                sub_total = 0;
              }


            
            var total_akhir = parseInt(total,10) - parseInt(sub_total,10);

            $("#total_item_masuk").val(tandaPemisahTitik(total_akhir));


            $.post("hapus_tbs_item_masuk.php",{id:id},function(data){
            if (data != "") {
            
            $(".tr-id-"+id).remove();
            
            }
            
            });
            });

            $('form').submit(function(){
            
            return false;
            });
            
            });
            

        </script>

   <script type="text/javascript">
  
        $(document).ready(function(){
        $("#kode_barang").blur(function(){

          var kode_barang = $(this).val();
          var session_id = $("#session_id").val();
          
          $.post('cek_kode_barang_tbs_item_masuk.php',{kode_barang:kode_barang,session_id:session_id}, function(data){
          
          if(data == 1){
          alert("Anda Tidak Bisa Menambahkan Barang Yang Sudah Ada, Silakan Edit atau Pilih Barang Yang Lain !");
          $("#kode_barang").val('');
          $("#nama_barang").val('');
          }//penutup if
          
          });////penutup function(data)        

      $.getJSON('lihat_item_masuk.php',{kode_barang:$(this).val()}, function(json){
      
      if (json == null)
      {
        
        $('#nama_barang').val('');
        $('#satuan_produk').val('');
        $('#harga_produk').val('');
      }

      else 
      {
        $('#nama_barang').val(json.nama_barang);
        $('#satuan_produk').val(json.satuan);
        $('#harga_produk').val(json.harga_jual);
      }
                                              
        });
        
        });
        });

      
      
</script>

                                    <script type="text/javascript">
                                    
                                    $(".edit-jumlah").dblclick(function(){
                                    
                                    var id = $(this).attr("data-id");
                                    
                                    $("#text-jumlah-"+id+"").hide();
                                    
                                    $("#input-jumlah-"+id+"").attr("type", "text");
                                    
                                    });
                                    
                                    
                                    $(".input_jumlah").blur(function(){
                                    
                                    var id = $(this).attr("data-id");
                                    var jumlah_baru = $(this).val();
                                    var harga = $(this).attr("data-harga");
                                    var subtotal_lama = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($(this).attr("data-subtotal")))));
                                    var subtotal = harga * jumlah_baru;
                                    var subtotal_penjualan = bersihPemisah(bersihPemisah(bersihPemisah(bersihPemisah($("#total_item_masuk").val()))));
                                    
                                    var total_akhir = parseInt(subtotal_penjualan) - parseInt(subtotal_lama) + parseInt(subtotal);
                                    
                                    $("#total_item_masuk").val(tandaPemisahTitik(total_akhir));
                                    $("#input-jumlah-"+id).attr("data-subtotal", subtotal);
                                    $("#btn-hapus-"+id).attr("data-subtotal", subtotal);
                                    
                                    $.post("update_jumlah_barang_tbs_item_masuk.php",{id:id,jumlah_baru:jumlah_baru,subtotal:subtotal},function(info){
                                    

                                    
                                    $("#text-jumlah-"+id+"").show();
                                    $("#text-jumlah-"+id+"").text(jumlah_baru);
                                    $("#text-subtotal-"+id+"").text(tandaPemisahTitik(subtotal));
                                    $("#input-jumlah-"+id+"").attr("type", "hidden"); 
                                    
                                    
                                    });
                                    
                                    $("#kode_barang").focus();
                                    
                                    });
                                    
                                    </script>    


                              
  <script type="text/javascript">
//berfunsi untuk mencekal username ganda
 $(document).ready(function(){
  $(document).on('click', '.pilih', function (e) {
    var session_id = $("#session_id").val();
    var kode_barang = $("#kode_barang").val();

 $.post('cek_kode_barang_tbs_item_masuk.php',{kode_barang:kode_barang,session_id:session_id}, function(data){
  
  if(data == 1){
    alert("Anda Tidak Bisa Menambahkan Barang Yang Sudah Ada, Silakan Edit atau Pilih Barang Yang Lain !");
    $("#kode_barang").val('');
    $("#nama_barang").val('');
   }//penutup if

    });
    //penutup function(data)

    });//penutup click(function()
  });//penutup ready(function()
</script>                              
                              <!-- memasukan file footer.php -->
 <?php include 'footer.php'; ?>