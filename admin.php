<?php
include "connection.php";
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

$admin_email = $_SESSION['user_email'];

// User Pagination
$user_limit = 10;
$user_page = isset($_GET['user_page']) ? (int)$_GET['user_page'] : 1;
$user_offset = ($user_page - 1) * $user_limit;

$user_total_query = "SELECT COUNT(*) as total FROM users";
$user_total_result = $conn->query($user_total_query);
$user_total_row = $user_total_result->fetch_assoc();
$total_users = $user_total_row['total'];
$total_user_pages = ceil($total_users / $user_limit);

$user_sql = "SELECT id, name, email, role FROM users LIMIT $user_limit OFFSET $user_offset";
$user_result = $conn->query($user_sql);

// Product Pagination
$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$total_query = "SELECT COUNT(*) as total FROM products";
$total_result = $conn->query($total_query);
$total_row = $total_result->fetch_assoc();
$total_products = $total_row['total'];
$total_pages = ceil($total_products / $limit);

$product_query = "SELECT * FROM products LIMIT $limit OFFSET $offset";
$product_result = $conn->query($product_query);

// Stock Pagination
$stock_limit = 10;
$stock_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$stock_offset = ($stock_page - 1) * $stock_limit;

$stock_query = "SELECT COUNT(*) as total FROM products";
$stock_result = $conn->query($stock_query);
$stock_row = $stock_result->fetch_assoc();
$stock_products = $stock_row['total'];
$stock_page = ceil($stock_products / $stock_limit);

$stock_query = "SELECT * FROM products LIMIT $limit OFFSET $offset";
$stock_result = $conn->query($product_query);

$product_query = "SELECT * FROM products";
$product_result = $conn->query($product_query);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="styleadmin.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
</head>

<body>
    <nav class="sidebar">
        <ul>
            <li>
                <div class="mt-5">
                    <img src="./imgs/CasetifyLogo.png"><br>
                </div>
            </li>
            <li><a href="#products"><i class="fa-solid fa-list-check"></i>Manage Products</a></li>
            <li><a href="#orders"><i class="fa-solid fa-list"></i>Orders List</a></li>
            <li><a href="#addstock"><i class="fa-solid fa-boxes-stacked"></i>Add Stock</a></li>
            <li><a href="#users"><i class="fa-solid fa-users"></i>User Management</a></li>
            <li><a href="#pendings"><i class="fa-solid fa-hourglass-half"></i>Pending Orders</a></li>
            <li><a href="#complete"><i class="fa-solid fa-clipboard-list"></i>Complete Orders</a></li>
        </ul>
        <div class="p-5 mt-5">
            <a href="logout.php">
                <i class="fa-solid fa-right-from-bracket logout"></i><span class="fs-5 ms-2 d-none d-sm-inline logout">Logout</span>
            </a>
        </div>
    </nav>

    <main class="content">
        <section id="products">
            <h1>Manage Products</h1>
            <button type="button" class="submitbtn" data-bs-toggle="modal" data-bs-target="#addModal">ADD PRODUCT</button>
            <div style="max-height: 500px; overflow-y: auto;">
                <table>
                    <thead>
                        <tr>
                            <th>Product ID</th>
                            <th>Product Name</th>
                            <th>Category</th>
                            <th>Brand</th>
                            <th>Model</th>
                            <th>Price</th>
                            <th>Image</th>
                            <th>Description</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $product_result->fetch_assoc()) { ?>
                            <tr>
                                <td><?= $row['id'] ?></td>
                                <td><?= $row['product_name'] ?></td>
                                <td><?= $row['category'] ?></td>
                                <td><?= $row['brand'] ?></td>
                                <td><?= $row['model'] ?></td>
                                <td><?= number_format($row['price'], 2) ?></td>
                                <td><img src="<?= $row['image'] ?>" width="50" height="50"></td>
                                <td><?= $row['proddescription'] ?></td>
                                <td>
                                    <button class="btn btn-warning btn-sm">Edit</button>
                                    <button class="btn btn-danger btn-sm">Delete</button>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

            <div class="pagination">
                <?php if ($page > 1) { ?>
                    <a href="?page=<?= $page - 1 ?>">&laquo; Prev</a>
                <?php } ?>

                <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
                    <a href="?page=<?= $i ?>" class="<?= ($i == $page) ? 'active' : '' ?>"><?= $i ?></a>
                <?php } ?>

                <?php if ($page < $total_pages) { ?>
                    <a href="?page=<?= $page + 1 ?>">Next &raquo;</a>
                <?php } ?>
            </div>
        </section>

        <section id="orders">
            <h1>Orders</h1>
            <table>
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Username</th>
                        <th>Product ID</th>
                        <th>Product Name</th>
                        <th>Category</th>
                        <th>Brand</th>
                        <th>Model</th>
                        <th>Product Price</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </section>
        </section>

        <section id="addstock">
            <h1>Update Stock</h1>
            <p>Track product stock and restock alerts.</p>

            <div style="max-height: 500px; overflow-y: auto;">
                <table>
                    <thead>
                        <tr>
                            <th>Product ID</th>
                            <th>Product Name</th>
                            <th>Current Stock</th>
                            <th>Stock Status</th>
                            <th>Update Stock</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $limit = 5;
                        $stock_page = isset($_GET['stock_page']) ? (int)$_GET['stock_page'] : 1;
                        $offset = ($stock_page - 1) * $limit;

                        $sql = "SELECT id, product_name, stock FROM products ORDER BY stock ASC LIMIT ? OFFSET ?";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("ii", $limit, $offset);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $stock_status = ($row['stock'] > 5) ? '<span class="badge bg-success">In Stock</span>' : '<span class="badge bg-danger">Low Stock</span>';

                                echo '<tr>';
                                echo '<td>' . $row['id'] . '</td>';
                                echo '<td>' . htmlspecialchars($row['product_name']) . '</td>';
                                echo '<td>' . $row['stock'] . '</td>';
                                echo '<td>' . $stock_status . '</td>';
                                echo '<td>';
                                echo '<form action="updatestock.php" method="POST" class="d-flex">';
                                echo '<input type="hidden" name="product_id" value="' . $row['id'] . '">';
                                echo '<input type="number" name="new_stock" style="width:100px" class="form-control me-2" min="1" required>';
                                echo '<button type="submit" class="btn btn-stock">Add Stock</button>';
                                echo '</form>';
                                echo '</td>';
                                echo '</tr>';
                            }
                        } else {
                            echo '<tr><td colspan="5" class="text-center">No products found.</td></tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <div class="pagination">
                <?php
                $count_sql = "SELECT COUNT(*) AS total FROM products";
                $count_result = $conn->query($count_sql);
                $total_stock = $count_result->fetch_assoc()['total'];
                $total_stock_pages = ceil($total_stock / $limit);
                ?>

                <?php if ($stock_page > 1): ?>
                    <a href="?stock_page=<?= $stock_page - 1 ?>">&laquo; Prev</a>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $total_stock_pages; $i++): ?>
                    <a href="?stock_page=<?= $i ?>" class="<?= ($i == $stock_page) ? 'active' : '' ?>"><?= $i ?></a>
                <?php endfor; ?>

                <?php if ($stock_page < $total_stock_pages): ?>
                    <a href="?stock_page=<?= $stock_page + 1 ?>">Next &raquo;</a>
                <?php endif; ?>
            </div>
        </section>


        <section id="users">
            <h1>User Management</h1>
            <p>Manage customer and staff accounts.</p>

            <table>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Action</th>
                </tr>
                <?php while ($row = $user_result->fetch_assoc()) { ?>
                    <tr>
                        <td><?= htmlspecialchars($row['name']) ?></td>
                        <td><?= htmlspecialchars($row['email']) ?></td>
                        <td><?= ucfirst($row['role']) ?></td>
                        <td>
                            <?php if ($row['role'] == 'user') { ?>
                                <form id="makeAdminForm-<?= $row['id'] ?>" method="POST">
                                    <input type="hidden" name="user_id" value="<?= $row['id'] ?>">
                                    <button type="button" onclick="confirmAdminUpgrade(event, '<?= htmlspecialchars($row['name']) ?>', <?= $row['id'] ?>)">
                                        Make Admin
                                    </button>
                                </form>
                            <?php } ?>
                        </td>
                    </tr>
                <?php } ?>
            </table>

            <div class="pagination">
                <?php if ($user_page > 1) { ?>
                    <a href="?user_page=<?= $user_page - 1 ?>">&laquo; Prev</a>
                <?php } ?>

                <?php for ($i = 1; $i <= $total_user_pages; $i++) { ?>
                    <a href="?user_page=<?= $i ?>" class="<?= ($i == $user_page) ? 'active' : '' ?>"><?= $i ?></a>
                <?php } ?>

                <?php if ($user_page < $total_user_pages) { ?>
                    <a href="?user_page=<?= $user_page + 1 ?>">Next &raquo;</a>
                <?php } ?>
            </div>
        </section>

        <section id="pendings">
            <h1>Pending Order</h1>
            <p>For Monitoring and Update.</p>
        </section>

        <section id="complete">
            <h1>Complete Order</h1>
            <p>Transaction Complete.</p>
        </section>
    </main>

    <!-- Modal -->
    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="addproduct.php" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label>Product Name</label>
                            <input type="text" name="productname" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Category</label>
                            <select class="form-select" name="category" required>
                                <option value="Cases">Phone Cases</option>
                                <option value="Airpods">Airpods</option>
                                <option value="Accessories">Accessories</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label>Brand</label>
                            <input type="text" name="brand" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Model</label>
                            <input type="text" name="model" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Price</label>
                            <input type="number" name="productprice" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Description</label>
                            <textarea name="proddescription" class="form-control" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label>Image</label>
                            <input type="file" name="productimage" class="form-control" accept=".jpg, .png, .jpeg" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="addProduct" class="submitbtn">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editproduct" tabindex="-1" aria-labelledby="editProductLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editProductLabel">Edit Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editProductForm">
                        <input type="hidden" id="xproductid" name="xproductid">
                        <div class="mb-3">
                            <label for="xproductname" class="form-label">Product Name</label>
                            <input type="text" class="form-control" id="xproductname" name="xproductname" required>
                        </div>
                        <div class="mb-3">
                            <label for="xcategory" class="form-label">Category</label>
                            <input type="text" class="form-control" id="xcategory" name="xcategory" required>
                        </div>
                        <div class="mb-3">
                            <label for="xbrand" class="form-label">Brand</label>
                            <input type="text" class="form-control" id="xbrand" name="xbrand" required>
                        </div>
                        <div class="mb-3">
                            <label for="xmodel" class="form-label">Model</label>
                            <input type="text" class="form-control" id="xmodel" name="xmodel" required>
                        </div>
                        <div class="mb-3">
                            <label for="xprice" class="form-label">Price</label>
                            <input type="number" class="form-control" id="xprice" name="xprice" required>
                        </div>
                        <div class="mb-3">
                            <label for="xdescription" class="form-label">Description</label>
                            <textarea class="form-control" id="xproddescription" name="xproddescription"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="xproductimage" class="form-label">Product Image</label>
                            <input type="file" class="form-control" id="xproductimage" name="xproductimage">
                            <br>
                            <img id="xproductimage_preview" src="" width="100">
                        </div>
                        <button type="submitbtn" class="btn btn-primary">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="deleteproduct" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Delete Product</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="deleteproduct.php" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="text" name="xproductidx" id="xproductidx" class="form-control">
                            <label>Are you sure you want to delete this product?<span id="productName"></span></label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" name="registerbtn" class="btn btn-dark">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/admin.js"></script>
    <script src="js/manageprod.js"></script>

</body>

</html>