<?php
    $title = "Đặt hàng";
    $baseUrl = '../';
    include_once ($baseUrl.'layouts/header.php');
    include_once ('./render-ma.php');
    if(!empty($_POST)) {
        $fullname_order = getPost('name');
        $phone_number = getPost('phone');
        $email = getPost('email');
        $matinh_tp =  getPost('matp');
        $maquan_huyen = getPost('maqh');
        $phuong_thuc = getPost('radio');
        $total= getPost('total');
        if($matinh_tp != "#") {
            $sql = "SELECT name FROM devvn_tinhthanhpho WHERE matp='$matinh_tp'";
            $data = executeResult($sql,true);
            $tinh_tp = $data['name'];
        }   
        if($maquan_huyen != "#") {
            $sql = "SELECT name FROM devvn_quanhuyen WHERE maqh='$maquan_huyen'";
            $data = executeResult($sql,true);
            $quan_huyen = $data['name'];
        }
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $xa_phuong = getPost('maphuongxa');
        $address = $xa_phuong.','.$quan_huyen.','.$tinh_tp;
        $created_at = date('d-m-y H:i:s');
        $sql = "SELECT product_id,num FROM cart WHERE user_name = '$user_name'";
        $data = executeResult($sql);
        $sql2 = "SELECT MAX(stt) as max_stt
        FROM orders";

        $data2 = executeResult($sql2,true);
        $max_stt = $data2['max_stt'] + 1;

        $masp = strtoupper(unique_id(8));
        foreach($data as $item) {
            $product_id = $item['product_id'];
            $num = $item['num'];
            if($address != null) {
                $sql = "INSERT INTO  orders (total,masp,stt,user_name,user_name1,phone_number,email,address,created_at,product_id,num,status,phuong_thuc) VALUES 
                ('$total','$masp','$max_stt','$fullname_order','$user_name','$phone_number','$email','$address','$created_at','$product_id','$num','Đang xử lý','$phuong_thuc')";
                execute($sql);
                $sql = "DELETE FROM cart WHERE product_id = '$product_id' AND user_name = '$user_name'";
                
                execute($sql);
                header("Location: ../success");
            } else {
                echo 'VUI LÒNG ĐIỀN ĐẦY ĐỦ THÔNG TIN';
            }
        }
    }
?>
<link rel="stylesheet" href="<?=$baseUrl?>assets/css/checkouts.css">
<link rel="stylesheet" href="<?=$baseUrl?>assets/css/checkouts_product.css">




<style>
    .phuong-thuc-pay-items input {
    margin-top: 5px;
    }
    .phuong-thuc-pay-items span {
    font-size: 18px;
    margin-left: 10px;
}
</style>
<div class="breadcrumb_bg">
    <div class="breadcrumb-box-img">
        <img src="../assets/img/bg_breadcrumb.png" alt="">
    </div>
    <div class="title-full">
        <div class="container">
            <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@600&display=swap" rel="stylesheet">
            <p class="title-page">Đặt hàng - Oars Organic</p>
        </div>
    </div>
</div>
<div class="checkouts">
    <div class="grid wide">
    <form action="" method="post">
        <div class="row">
            <div class="col l-7 c-12">
                <div class="infor-order">
                    
                        <div style="font-weight: 600;"  class="title-infor">
                            <h2>Thông tin giao hàng</h2>
                        </div>
                        <div class="form-group">
                            <div class="input-item">
                                <input type="text" name="name" placeholder="Họ và tên người nhận hàng" required>
                            </div>
                            <div class="input-item">
                                <input type="email" name="email" placeholder="Email" class="input-email" required>
                                <input type="phone" name="phone" placeholder="Số điện thoại" required>
                            </div>
                            <div class="input-item">
                                <div class="tinh-thanh-pho flex">
                                    <label for="">Tỉnh/thành phố:</label>
                                    <select  name="matp" id="matp" required>
                                        <option value="#">Chọn tỉnh/thành phố</option>
                                        <?php
                                        $sql = "SELECT * FROM devvn_tinhthanhpho";
                                        $data = executeResult($sql);
                                        foreach ($data as $item=>$key) {
                                            echo '<option value="'.$key['matp'].'">'.$key['name'].'</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="input-item">
                                <div class="quan-huyen-main flex">
                                    <label for="">Quận/huyện:</label>
                                    <select  name="maqh" id="maqh" required>
                                        <option value="#">Chọn quận/huyện</option>
                                    </select>
                                </div>
                            </div>
                            <div class="input-item">
                                <div class="xa-phuong flex">
                                    <label for="">Thị trấn/xã/phường:</label>
                                    <select  name="maphuongxa" id="phuongxa" required>
                                    <option value="#">Chọn xã/phường</option>
                                    </select>
                                </div>  
                            </div>
                            <div class="phuong-thuc-pay" style="margin-top:20px;">
                                <div class="phuong-thuc-pay-items-box">
                                    <div class="phuong-thuc-pay-items flex">
                                        <input required="" type="radio" name="radio" value="Thanh toán khi nhận hàng">
                                        <span>Thanh toán khi nhận hàng</span>
                                    </div>
                                </div>
                                <div class="phuong-thuc-pay-items-box">
                                    <div class="phuong-thuc-pay-items flex">
                                        <input required="" type="radio" name="radio" class="input-check1" value="Chuyển khoản">
                                        <span>Chuyển khoản ngân hàng</span>
                                    </div>
                                </div>
                                
                                <div class="phuong-thuc-pay-items-box">
                                    <div class="phuong-thuc-pay-items flex">
                                        <input required="" type="radio" class="input-check2"  name="radio" value="Quét mã MoMo">
                                        <span>Quét mã MoMo</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="infor-order-end">
                            <div class="go-to-cart">
                                <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@600&display=swap" rel="stylesheet">
                                <a href="../cart" class="tag-a">Giỏ hàng</a>
                            </div>
                            <div class="continue-pay">
                                <button type="submit">Hoàn tất đơn hàng</button>
                            </div>
                        </div>
                    
                </div>
            </div>
            <?php
                include_once('../layouts/checkout_product.php');
            ?>
        </div>
        </form>
    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>


	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">

	<link rel="stylesheet" type="text/css" href="<?=$baseUrl?>../assets/css/dashboard.css">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.6.1/font/bootstrap-icons.css">

	<!-- jQuery library -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

	<!-- Popper JS -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

	<!-- Latest compiled JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>


    <!-- thanh toán -->
<form class="" method="POST" target="_blank" enctype="application/x-www-form-urlencoded"
                                    action="init_payment.php">
<div class="model-bank">
        <div class="container-bank">
            <div class="grid wide">
                <div class="row">
                    <?php
                        include_once('../layouts/checkout_product_bank.php');
                    ?>
                    <div class="col l-7 style='position:relative;' ">
                    <div class="wrapper-payment-right">
                        <div class="pr-title">
                            <span class="">Chuyển khoản bằng QR</span>
                            <div class="icon-hide">
                                <i class="fa-regular fa-x"></i>
                            </div>
                        </div>
                        <div class="pr-qr-code">
                            <!-- <div class="pr-img">
                                <img src="https://img.vietqr.io/image/Vietcombank-9353538222-znVvEh.jpg?accountName=Cong%20Ty%20Co%20Phan%20Cong%20Nghe%20Giao%20duc%20F8&amount=1299000&addInfo=F8C1EGPA" alt="" class="">
                            </div> -->
                            <ul class="pr-qr-detail">
                                <li class="tag-li">Bước 1: Mở app ngân hàng hoặc Momo và quét mã QR.</li>
                                <li class="tag-li">Bước 2: Đảm bảo nội dung chuyển khoản là:
                                    <?php 
                                    if(isset($_SESSION['email'])) {
                                        $email = $_SESSION['email'];
                                        $sql = "SELECT id FROM user WHERE email = '$email'";
                                        $data = executeResult($sql,true);
                                        $id = $data['id'];
                                        $id2 = "FA6ORG$id";
                                        echo 
                                            '<span class="ma-kh">'.$id2.'</span>
                                            <input hidden value="'.$id2.'" type="text" name="ma"><br>
                                            '
                                        ;
                                    }
                                    ?>
                                </li>
                                <li class="tag-li">Bước 3: Thực hiện thanh toán.</li>
                                <li class="tag-li">
                                
                                    <button type="submit" class="btn btn-success" style="font-weight: 600;">Thanh toán ngay</button>
                                
                                </li>
                            </ul>
                        </div>
                        <div class="pr-title pr-title-bottom">
                            <span class="">Chuyển khoản thủ công</span>
                        </div>
                        <div class="pr-qr-hand">
                            <div class="pr-qr-box">
                                <div class="pr-qr-item">
                                    <div class="pr-qr-item-tit">
                                        <span class="">Số tài khoản</span>
                                    </div>
                                    <div class="pr-qr-item-content">
                                        <span class="">0372039349</span>
                                    </div>
                                </div>
                                <div class="pr-qr-item">
                                    <div class="pr-qr-item-tit">
                                        <span class="">Tên tài khoản</span>
                                    </div>
                                    <div class="pr-qr-item-content">
                                        <span class="">NGUYỄN THỊ THANH LOAN</span>
                                    </div>
                                </div>
                            </div>
                            <div class="pr-qr-box">
                                <div class="pr-qr-item">
                                    <div class="pr-qr-item-tit">
                                        <span class="">Nội dung</span>
                                    </div>
                                    <div class="pr-qr-item-content">
                                        <span class=""><?=$id2?></span>
                                    </div>
                                </div>
                                <div class="pr-qr-item">
                                    <div class="pr-qr-item-tit">
                                        <span class="">Chi nhánh</span>
                                    </div>
                                    <div class="pr-qr-item-content">
                                        <span class="">MB BANK Hà Nội</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="pay-attention">
                            <h1 class="" style="font-weight: 600;">Lưu ý</h1>
                            <span class="pa1">Tối đa 60 phút sau thời gian chuyển khoản, nếu hệ thống không phản hồi vui lòng liên hệ ngay bộ phận hỗ trợ của ORGANIC.</span>
                        </div>
                        
                    </div>
                    
                </div>
                </div>
            </div>
        </div>             
    </div>
</form>
</div>

<script>
    $(document).ready(function() {
        $('#matp').change(function() {
            var a = $(this).val()
            $.get("a-jax1.php",{a_ajax1:a},function(data) {
                $("#maqh").html(data);
                $('#maqh').change(function() {
                var b = $(this).val()
                $.get("a-jax2.php",{a_ajax2:b},function(data) {
                    $("#phuongxa").html(data);
                })
        })
            })
        })
    })


    const icon = document.querySelector('.icon-hide')
    const modal = document.querySelector('.model-bank')
    icon.onclick = function (){
        modal.classList.remove("flex");
    }
    const input = document.querySelector('.input-check1')
    const input2 = document.querySelector('.input-check2')
    console.log(input)

    input.onclick = function (){
        modal.classList.add("flex");
    }
    input2.onclick = function (){
        modal.classList.add("flex");
    }
    
</script>
<?php
    include_once ($baseUrl.'layouts/footer.php');
?>