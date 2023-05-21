<?php
	$title = 'Quản lý người dùng';
	$baseUrl = '../';
	require_once($baseUrl.'layouts/header.php');

	$sql = "SELECT stt from orders";
	$data = executeResult($sql);
	$list_order = [];
	foreach($data as $item) {
		if(in_array($item, $list_order)){
	
		}
		else{
			array_unshift($list_order, $item);
		}
	};
	

    if(!empty($_POST)) {
		$value_thanh_toan = getPost('thanhtoan');
		$stt = getPost('id');
		$sql2 = "SELECT * FROM orders WHERE stt='$stt'";
    	$data2= executeResult($sql2);
		foreach($data2 as $a) {
			// var_dump($a);
			$sql = "UPDATE orders SET status='$value_thanh_toan' WHERE stt='$stt'";
			execute($sql);
		}
		// header("Location:./detail.php?id=$id&stt=$stt");
	}





?>
<style> 
	.nav-item:nth-child(3) {
		background-color: #c1c1c1;
	}
</style>
<div class="row">
	<div class="col-md-12 table-responsive" style="margin-top: 30px;">
		<h3>Quản lý đơn hàng</h3>
		<table class="table table-bordered table-hover" style="margin-top: 15px;">
			<!-- <thead> -->
				<tr>
					<th>STT</th>
					<th>Mã đơn hàng</th>
					<th>Người đặt</th>
					<th>Thanh toán</th>
					<th>Địa chỉ</th>
					<th>Thời gian đặt</th>
					<th>Tổng tiền</th>
					<th>Trạng thái</th>
					<th>Thao tác</th>
					<th style="width: 50px;">Đơn hàng</th>
				</tr>
			<!-- </thead> -->
			<!-- <tbody> -->
				<?php
				$index = 0;
				foreach($list_order as $item) {
					$stt = $item['stt'];
					$sql = "SELECT * FROM orders WHERE stt = '$stt' AND NOT status='Đã hủy'";
					// echo $sql;
					$name = executeResult($sql,true);
					$fullname = $name['user_name1'];
					$sql = "SELECT id FROM user WHERE fullname='$fullname'";
					$data = executeResult($sql,true);
					$id = $data['id'];
					$thanh_toan = $name['status'];
					$list_thanh_toan = ['Đang xử lý','Đã xác nhận','Đang giao','Đã giao','Đã hủy'];
					echo '
						<tr>
						<th>'.(++$index).'</th>
						<td>'.$name['masp'].'</td>
						<td>'.$name['user_name1'].'</td>
						<td>'.$name['phuong_thuc'].'</td>
                        <td>'.$name['address'].'</td>
						<td>'.$name['created_at'].'</td>
						<td>'.$name['total'].'</td>
						<form method="post" action="" enctype="multipart/form-data">
							<input name="id" hidden value="'.$item['stt'].'" />
                            <td>
							<select style="cursor: pointer;" name="thanhtoan" id="category_id" class="form-control">
						';
						foreach ($list_thanh_toan as $a) {
							if ($a == $thanh_toan) {
								echo '<option selected value="'.$thanh_toan.'">'.$thanh_toan.'</option>';
							} 
							else {
								echo '<option  value="'.$a.'">'.$a.'</option>';
							}
						}



						echo'
						<th style="width: 40px; height:40px;" >
								<a href="delete.php?id='.$item['id'].'"><button class="btn btn-success">Lưu</button></a>
							</th>
						
						
						</form>
						<th style="width: 40px; height:40px;" >
							<a href="detail.php?id='.$id.'&stt='.$stt.'"><button class="btn btn-warning">Xem</button></a>
						</th>
					';
				}
				?>
			<!-- </tbody> -->
		</table>
	</div>
</div>

<?php
	require_once($baseUrl.'layouts/footer.php');
?>