<?php
session_start();
include "connection.php";

$error = "";
$redirect_url = "";
$product = null;

if (!isset($_SESSION['user_email'])) {
    $error = "You need to log in first!";
    $redirect_url = "login.php";
} elseif (!isset($_GET['id']) || empty($_GET['id'])) {
    $error = "Invalid product ID!";
    $redirect_url = "product.php";
} else {
    $product_id = intval($_GET['id']);
    $sql = "SELECT * FROM products WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        $error = "Product not found!";
        $redirect_url = "product.php";
    } else {
        $product = $result->fetch_assoc();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $product ? htmlspecialchars($product['product_name']) : "Product Not Found"; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php include "header.php"; ?>

    <script>
        <?php if (!empty($error)): ?>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '<?php echo $error; ?>',
                confirmButtonColor: '#d33',
                background: '#f8f9fa',
                backdrop: `
                rgba(0, 0, 0, 0.4)
                url('uploads/background.jpg') 
                center / cover no-repeat
            `
            }).then(() => {
                window.location.href = '<?php echo $redirect_url; ?>';
            });
        <?php endif; ?>
    </script>

    <?php if ($product): ?>
        <section id="single-product" class="container my-5 pt-5">
            <div class="row mt-5">
                <div class="col-lg-5 col-md-6 col-sm-12">
                    <?php
                    $image_path = !empty($product['image']) ? "uploads/" . basename($product['image']) : "uploads/default.jpg";
                    ?>
                    <img class="img-fluid w-70 pb-1"
                        src="<?php echo htmlspecialchars($image_path); ?>"
                        alt="<?php echo htmlspecialchars($product['product_name']); ?>">
                </div>

                <div class="col-lg-6 col-md-12 col-12 pt-5">
                    <h3><?php echo htmlspecialchars($product['product_name']); ?></h3>
                    <h6><?php echo htmlspecialchars($product['category']); ?></h6>
                    <h6 class="py-4"><?php echo htmlspecialchars($product['brand']); ?> <?php echo htmlspecialchars($product['model']); ?></h6>
                    <h2>₱ <?php echo number_format($product['price'], 2); ?></h2>

                    <?php if ($product['stock'] > 0): ?>
                        <h6>Quantity</h6>
                        <div class="d-flex mb-3" style="justify-content: center;">
                            <button class="btn btn-outline-secondary" onclick="changeQty(-1)">-</button>
                            <input type="number" name="qty" id="qty" class="form-control mx-2" value="1" min="1" max="<?php echo intval($product['stock']); ?>" style="width: 80px;">
                            <button class="btn btn-outline-secondary" onclick="changeQty(1)">+</button>
                        </div>
                        <button class="btn btn-stock" onclick="addToCart(<?php echo $product['id']; ?>)">Add To Cart</button>
                    <?php else: ?>
                        <h5 class="text-danger mt-3">Out of Stock</h5>
                    <?php endif; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <section id="banner">
        <div>
            <!--  -->
        </div>
    </section>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="js/singleproduct.js"></script>

</body>

</html>