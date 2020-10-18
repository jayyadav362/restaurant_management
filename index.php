<?php include("dbconfig.php");?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Foodie | taste the better</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="d-print-none">
<nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-primary">
    <ul class="navbar-nav mr-auto">
        <li class="nav-item"><a href="" class="nav-link">Keyboard</a></li>
        <li class="nav-item"><a href="" class="nav-link">Take Away</a></li>
        <li class="nav-item"><a href="" class="nav-link">Delivery</a></li>
        <li class="nav-item"><a href="" class="nav-link">Home</a></li>
    </ul>
    <a href="" class="navbar-brand mx-auto">Foodie</a>

    <ul class="navbar-nav ml-auto">
        <li class="nav-item"><a href="" class="nav-link">Sales Return</a></li>
        <li class="nav-item"><a href="#rock" data-toggle="modal" class="nav-link">New</a></li>
        <li class="nav-item"><a href="" class="nav-link">Hold</a></li>
        <li class="nav-item"><a href="" class="nav-link">Unhold</a></li>
        <li class="nav-item"><a href="" class="nav-link">Logout</a></li>
    </ul>
</nav>
<br>
<br>
<!--containing-->
<div class="modal fade" id="rock">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="">Title</label>
                        <input type="text" name="title" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="">price</label>
                        <input type="number" name="price" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="">category</label>
                        <select name="category" class="form-control">
                        <?php 
                    $calling = calling("category");
                    foreach($calling as $cat):
                ?>
                <option value="<?= $cat['id'];?>"><?= $cat['cat_title'];?></option>
                    <?php  endforeach; ?>    
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">image</label>
                        <input type="file" name="image" class="form-control">
                    </div>
                    <div class="form-group">
                        <input type="submit" name="send" class="btn btn-success btn-block">
                    </div>
                </form>


            </div>
        </div>
    </div>

</div>
<div class="container-fluid px-0 mt-2">
    <div class="row no-gutters">
        <div class="col-lg-2 scrollable left">
            <div class="list-group">
                <a href="index.php" class="list-group-item list-group-item-action text-center">View All</a>
                <?php 
                    $calling = calling("category");
                    foreach($calling as $cat):
                ?>
                <a href="index.php?cat_id=<?= $cat['id'];?>" class="list-group-item list-group-item-action"><?= $cat['cat_title'];?></a>
                    <?php  endforeach; ?>    
            </div>
        </div>
        <div class="col-lg-6 scrollable left">

            <div class="card-group">
                <?php 
                $count = 1;
                if(isset($_GET['cat_id'])){
                    $id = $_GET['cat_id'];
                    $calling = calling("products"," category='$id'");
                
                }
                else{
                    $calling = calling("products");
                
                }

                if(!empty($calling)):

                foreach($calling as $pro):?>
                <div class="card">
                    <a href="index.php?order&pro_id=<?= $pro['id'];?>" class="stretched-link">
                        <img src="image/<?= $pro['image'];?>" alt="" class="card-img">
                    </a>
                    <div class="card-body">
                        <h2 class="small"><?= $pro['title'];?></h2>
                        <h6>Rs. <?= $pro['price'];?>/-</h6>
                    </div>
                </div>
                    <?php if($count%5 == 0): ?>
                    </div>
                            <div class="card-group">
                    <?php endif;?> 
                <?php $count++; endforeach;
                
                
                    else: ?>

                    <div class="card text-center">
                        <div class="card-body">
                                <h2 class="lead">Sorry not found any recipe</h2>
                        </div>
                    </div>

                    <?php endif;?>
            </div>

    
        </div>
        <div class="col-lg-4 ">
            <div class="scrollable right">
            <table class="table  table-sm">
                <tr>
                    <th>Product Name</th>
                    <th>Unit Price</th>
                    <th>Qty</th>
                    <th>Total</th>
                    <th>Delete</th>
                </tr>

                <?php 
                    $calling = mysqli_query($connect,"SELECT * from orders JOIN products ON orders.pro_id=products.id");
                    $total = 0;
                    foreach($calling as $o):
                ?>
                <tr>
                    <td><?= $o['title'];?></td>
                    <td><?= $o['amount'];?></td>
                    <td>
                    <a href="index.php?minus&pro_id=<?= $o['id'];?>" class="btn btn-sm btn-danger">-</a>        
                   <span><?= $o['qty'];?> </span>
                        <a href="index.php?order&pro_id=<?= $o['id'];?>" class="btn btn-success btn-sm">+</a>
                </td>
                 <td><?= $o['amount'] * $o['qty'];?></td>
                   
                    <td><a href="index.php?delete_order=<?= $o['order_id'];?>" class="btn btn-danger btn-sm">X</a></td>
                </tr>
                    <?php 
                    $total += $o['amount'] * $o['qty'];
                endforeach;?>
              
            </table>
            </div>
            <h1 class="h2">Rs. <?= $total;?>/-</h1>
              <div class="row w-100 no-gutters">
                  <div class="col-lg-6">
                      <a href="#cod" data-toggle="modal" class="btn btn-success btn-block rounded-0">Fast Cash</a>
                  </div>
                  <div class="col-lg-6">
                        <a href="" class="btn btn-primary btn-block rounded-0">Checkout</a>
                  </div>
              </div>         
        </div>
    </div>
</div>
            </div>
<div class="modal fade d-print-block" id="cod" >
    <div class="modal-dialog">
        <div class="modal-content">
            
            <div class="modal-body">
            <h2>Foodie</h2>
                    <table class="table  table-sm">
                <tr>
                    <th>Product Name</th>
                    <th>Unit Price</th>
                    <th>Qty</th>
                    <th>Total</th>
                </tr>

                <?php 
                    $calling = mysqli_query($connect,"SELECT * from orders JOIN products ON orders.pro_id=products.id");
                    $total = 0;
                    foreach($calling as $o):
                ?>
                <tr>
                    <td><?= $o['title'];?></td>
                    <td>₹<?= $o['amount'];?></td>
                    <td>
                  <span><?= $o['qty'];?> </span>
                </td>
                 <td>₹<?= $o['amount'] * $o['qty'];?></td>
                 </tr>
                    <?php 
                    $total += $o['amount'] * $o['qty'];
                endforeach;?>
                
                <tr>
                    <th colspan="3">Total Amount</th>
                    <td>₹<?= $total;?></td>
                </tr>
                <tr>
                    <th colspan="3">Tax</th>
                    <td>₹<?= $tax = $total*0.18;?></td>
                </tr>
                <tr>
                    <th colspan="3">Total Payable Amount</th>
                    <td class="text-success font-weight-bolder"><h4>₹<?= $total + $tax;?></h4></td>
                </tr>
            </table>
            <a href="" onclick="window.print();" class="d-print-none btn btn-info">Print Invoice</a>
            </div>
        </div>
    </div>
</div>


<?php 


if(isset($_POST['send'])){
    $image = $_FILES['image']['name'];

    $tmp_image = $_FILES['image']['tmp_name'];

    move_uploaded_file($tmp_image,"image/$image");
    $data = [
        'title' => $_POST['title'],
        'image' => $image,
        'price' => $_POST['price'],
        'category' => $_POST['category'],
    ];
    insert("products",$data);
    redirect("index");
}


if(isset($_GET['order']) && isset($_GET['pro_id'])){
    // echo "<script>alert('hello baba')</script>";
    $pro_id = $_GET['pro_id'];

    if(check_data('products'," id='$pro_id'")){
        $product = get_rows("products"," id='$pro_id'");

        if(check_data("orders"," pro_id='$pro_id'")){
            //update qty
            $order = get_rows("orders","pro_id='$pro_id'");
            $qty = $order['qty'] += 1;
            $order = update("orders","qty='$qty'"," pro_id='$pro_id'");
            redirect('index');
        }
        else{
            //insert
            $data = [
                'pro_id' => $pro_id,
                'user_id' => 1,
                'qty' => 1,
                'amount' => $product['price']
            ];

            insert("orders",$data);
            redirect('index');
        }
    }

}


if(isset($_GET['minus']) && isset($_GET['pro_id'])){
    // echo "<script>alert('hello baba')</script>";
    $pro_id = $_GET['pro_id'];

    if(check_data('products'," id='$pro_id'")){
        $product = get_rows("products"," id='$pro_id'");

        if(check_data("orders"," pro_id='$pro_id'")){
            //update qty
            $order = get_rows("orders","pro_id='$pro_id'");
            if($order['qty'] > 1){       
                $qty = $order['qty'] -= 1;
                $order = update("orders","qty='$qty'"," pro_id='$pro_id'");
                redirect('index');
            }
            else{
                $order_id = $order['order_id'];
                delete_data('orders'," order_id='$order_id'");
                redirect('index');
            }
        }
    }

}


if(isset($_GET['delete_order'])){
    $id = $_GET['delete_order'];
    delete_data('orders'," order_id='$id'");
   redirect('index');
}
?>


<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
</body>
</html>