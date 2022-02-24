<?php
session_start();
error_reporting(0);
include('includes/config.php');
if (strlen($_SESSION['alogin']) == 0) {
	header('location:index.php');
} else {
	if (isset($_GET['del']) && isset($_GET['name'])) {
		$id = $_GET['del'];
		$name = $_GET['name'];

		$sql = "delete from users WHERE id=:id";
		$query = $dbh->prepare($sql);
		$query->bindParam(':id', $id, PDO::PARAM_STR);
		$query->execute();

		$sql2 = "insert into deleteduser (email) values (:name)";
		$query2 = $dbh->prepare($sql2);
		$query2->bindParam(':name', $name, PDO::PARAM_STR);
		$query2->execute();

		$msg = "Data Deleted successfully";
	}

	if (isset($_REQUEST['unconfirm'])) {
		$aeid = intval($_GET['unconfirm']);
		$memstatus = 1;
		$sql = "UPDATE users SET status=:status WHERE  id=:aeid";
		$query = $dbh->prepare($sql);
		$query->bindParam(':status', $memstatus, PDO::PARAM_STR);
		$query->bindParam(':aeid', $aeid, PDO::PARAM_STR);
		$query->execute();
		$msg = "Changes Sucessfully";
	}

	if (isset($_REQUEST['confirm'])) {
		$aeid = intval($_GET['confirm']);
		$memstatus = 0;
		$sql = "UPDATE users SET status=:status WHERE  id=:aeid";
		$query = $dbh->prepare($sql);
		$query->bindParam(':status', $memstatus, PDO::PARAM_STR);
		$query->bindParam(':aeid', $aeid, PDO::PARAM_STR);
		$query->execute();
		$msg = "Changes Sucessfully";
	}





?>

	<!doctype html>
	<html lang="en" class="no-js">

	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
		<meta name="description" content="">
		<meta name="author" content="">
		<meta name="theme-color" content="#3e454c">

		<title>Manage Users</title>

		<!-- Font awesome -->
		<link rel="stylesheet" href="css/font-awesome.min.css">
		<!-- Sandstone Bootstrap CSS -->
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<!-- Bootstrap Datatables -->
		<link rel="stylesheet" href="css/dataTables.bootstrap.min.css">
		<!-- Bootstrap social button library -->
		<link rel="stylesheet" href="css/bootstrap-social.css">
		<!-- Bootstrap select -->
		<link rel="stylesheet" href="css/bootstrap-select.css">
		<!-- Bootstrap file input -->
		<link rel="stylesheet" href="css/fileinput.min.css">
		<!-- Awesome Bootstrap checkbox -->
		<link rel="stylesheet" href="css/awesome-bootstrap-checkbox.css">
		<!-- Admin Stye -->
		<link rel="stylesheet" href="css/style.css">
		<style>
			.errorWrap {
				padding: 10px;
				margin: 0 0 20px 0;
				background: #dd3d36;
				color: #fff;
				-webkit-box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
				box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
			}

			.succWrap {
				padding: 10px;
				margin: 0 0 20px 0;
				background: #5cb85c;
				color: #fff;
				-webkit-box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
				box-shadow: 0 1px 1px 0 rgba(0, 0, 0, .1);
			}
		</style>

	</head>

	<body>
		<?php include('includes/header.php'); ?>

		<div class="ts-main-content">
			<?php include('includes/leftbar.php'); ?>
			<div class="content-wrapper">
				<div class="container-fluid">
					<div class="row">
						<div class="col-md-12">
							<h2 class="page-title">Buy and Sell Order-<?php echo date("l jS \of F Y") ?></h2>
							<!-- Zero Configuration Table -->
							<div class="row">
								<div class="col-md-7 panel panel-default">
									<div class="row panel-heading">
										<div class="col-md-2 ">Buy Order</div>
										<div class="col-md-10 ">
											<form action="" class="form-horizontal" id="order_Form">
												<div class="form-group">
													<div class="col-sm-3">
														<input type="hidden" id="id">
														<input type="hidden" name="user_name" id="user_name" class="form-control" required value="<?php $user_name = $_SESSION['alogin'];
																																					echo htmlentities($user_name); ?>">
														<input type="text" name="usdt_rate" id="usdt_rate" class="form-control" placeholder="USDT_Rate" autocomplete="off" data-type="currency" required>
													</div>
													<div class="col-sm-3">
														<input type="text" name="usdt_total" id="usdt_total" class="form-control" placeholder="USDT_Total" autocomplete="off" data-type="currency" required>
													</div>
													<div class="col-sm-3">
														<input type="text" name="inr_total" id="inr_total" class="form-control" placeholder="INR_Total" autocomplete="off" data-type="currency" required>
													</div>
													<div class="col-sm-3">
														<button class="btn btn-primary btn-sm" name="submit" id="btnAdd" type="submit">Buy Order</button>
													</div>
												</div>
											</form>
										</div>
									</div>


									<div class="panel-body">
										<?php if ($error) { ?><div class="errorWrap" id="msgshow"><?php echo htmlentities($error); ?> </div><?php } else if ($msg) { ?><div class="succWrap" id="msgshow"><?php echo htmlentities($msg); ?> </div><?php } ?>
										<table id="zctb" class="display table table-striped table-bordered table-hover text-center" cellspacing="0" width="100%">
											<thead>
												<tr>
													<th>#</th>
													<th>USDT_Rate</th>
													<th>USDT_Total</th>
													<th>INR_Total</th>
													<th>Action</th>
												</tr>
											</thead>

											<tbody>
												<?php $sql = "SELECT * from  orders ";
												$query = $dbh->prepare($sql);
												$query->execute();
												$results = $query->fetchAll(PDO::FETCH_OBJ);
												$cnt = 1;
												if ($query->rowCount() > 0) {
													foreach ($results as $result) {				?>
														<tr>
															<td><?php echo htmlentities($cnt); ?></td>
															<td><?php echo htmlentities($result->usdt_rate); ?></td>
															<td><?php echo htmlentities($result->usdt_total); ?></td>
															<td><?php echo htmlentities($result->inr_total); ?></td>
															<td>
																<a href="edit-user.php?edit=<?php echo $result->id; ?>" onclick="return confirm('Do you want to Edit');" disabled>&nbsp; <i class="fa fa-pencil"></i> Edit</a>&nbsp;&nbsp;
																<!-- <a href="userlist.php?del=<?php echo $result->id; ?>&name=<?php echo htmlentities($result->email); ?>" onclick="return confirm('Do you want to Delete');" disabled><i class="fa fa-trash" style="color:red"></i></a>&nbsp;&nbsp; -->
															</td>
														</tr>
												<?php $cnt = $cnt + 1;
													}
												} ?>

											</tbody>
											<tr>
												<?php
												$total_usdt = $dbh->query("SELECT SUM(usdt_total) AS total FROM orders where user_name = '$user_name';")->fetchColumn();
												$total_inr = $dbh->query("SELECT SUM(inr_total) AS total FROM orders where user_name = '$user_name';")->fetchColumn();
												$total_inr_sell = $dbh->query("SELECT SUM(inr_total) AS total FROM sell where user_name = '$user_name';")->fetchColumn();
												$remaining = $total_inr - $total_inr_sell;
												?>
												<th colspan="2" class="text-center">Total</th>
												<td>$ <?php echo number_format($total_usdt); ?></td>
												<td>₹ <?php echo  number_format($total_inr); ?></td>
												<td></td>
											</tr>
											<tr>

												<th colspan="2" class="text-center">Remaing Balance</th>
												<td colspan="2"> <?php $fmt = new NumberFormatter('en_IN', NumberFormatter::CURRENCY);
																	echo $fmt->formatCurrency($remaining, "INR "); ?></td>
												<td></td>
											</tr>
										</table>
									</div>
								</div>
								<!-- Zero Configuration Table -->
								<div class=" col-md-5 panel panel-default">
									<div class="row panel-heading">
										<div class="col-md-2">Sell Order</div>
										<div class="col-md-10 ">
											<form action="" class="form-horizontal" id="sell_Form">
												<div class="col-sm-5">
													<input type="hidden" id="id">
													<input type="hidden" name="user_name" id="user_name" class="form-control" required value="<?php $user_name = $_SESSION['alogin'];
																																				echo htmlentities($user_name); ?>">
													<input type="text" name="inr_total1" id="inr_total1" class="form-control" placeholder="TRF_Amount" autocomplete="off" required>
												</div>
												<div class="col-sm-5">
													<input type="text" name="utr" id="utr" class="form-control" placeholder="UTR No." autocomplete="off" required>
												</div>
												<div class="col-sm-2">
													<button class="btn btn-primary btn-sm" name="submit" id="sellAdd" type="submit">Sell Order</button>
												</div>
											</form>
										</div>
									</div>
									<div class="panel-body">
										<?php if ($error) { ?><div class="errorWrap" id="msgshow"><?php echo htmlentities($error); ?> </div><?php } else if ($msg) { ?><div class="succWrap" id="msgshow"><?php echo htmlentities($msg); ?> </div><?php } ?>
										<table id="zctb_sell" class="display table table-striped table-bordered table-hover text-center" cellspacing="0" width="100%">
											<thead>
												<tr>
													<th>#</th>
													<th>INR_Total</th>
													<th>UTR</th>
													<th>Action</th>
												</tr>
											</thead>

											<tbody>

												<?php $sql = "SELECT * from  sell ";
												$query = $dbh->prepare($sql);
												$query->execute();
												$results = $query->fetchAll(PDO::FETCH_OBJ);
												$cnt = 1;
												if ($query->rowCount() > 0) {
													foreach ($results as $result) {				?>
														<tr>
															<td><?php echo htmlentities($cnt); ?></td>
															<td><?php echo htmlentities($result->inr_total); ?></td>
															<td><?php echo htmlentities($result->utr); ?></td>
															<td>
																<a href="edit-user.php?edit=<?php echo $result->id; ?>" onclick="return confirm('Do you want to Edit');" disabled>&nbsp; <i class="fa fa-pencil"></i> Edit</a>&nbsp;&nbsp;
																<!-- <a href="userlist.php?del=<?php echo $result->id; ?>&name=<?php echo htmlentities($result->email); ?>" onclick="return confirm('Do you want to Delete');" disabled><i class="fa fa-trash" style="color:red"></i></a>&nbsp;&nbsp; -->
															</td>
														</tr>
												<?php $cnt = $cnt + 1;
													}
												} ?>

											</tbody>
											<tr>
												<?php
												$total_inr_sell = $dbh->query("SELECT SUM(inr_total) AS total FROM sell where user_name = '$user_name' and  DATE(sell_date) = CURDATE();")->fetchColumn();
												?>
												<th class="text-center">Total TRF Amount</th>
												<td colspan="3"><?php $fmt = new NumberFormatter('en_IN', NumberFormatter::CURRENCY);
																echo $fmt->formatCurrency($total_inr_sell, "INR "); ?></td>
											</tr>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>

				</div>
			</div>
		</div>

		<!-- Loading Scripts -->
		<script src="js/jquery.min.js"></script>
		<script src="js/bootstrap-select.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="js/jquery.dataTables.min.js"></script>
		<script src="js/dataTables.bootstrap.min.js"></script>
		<script src="js/Chart.min.js"></script>
		<script src="js/fileinput.js"></script>
		<script src="js/chartData.js"></script>
		<script src="js/main.js"></script>
		<script src="js/jqajax.js"></script>
		<script src="js/jqajax_sell.js"></script>
		<script type="text/javascript">
			$(document).ready(function() {
				setTimeout(function() {
					$('.succWrap').slideUp("slow");
				}, 3000);
			});
			// for multiply usdxrate	
			$('#usdt_rate, #usdt_total').on('input', function() {
				var usdt_rate = parseFloat($('#usdt_rate').val()) || 0;
				var usdt_total = parseFloat($('#usdt_total').val()) || 0;
				$('#inr_total').val(usdt_rate * usdt_total);
			});
		</script>

	</body>

	</html>
<?php } ?>