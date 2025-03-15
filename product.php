<!DOCTYPE html>
<html lang="en">
<?php
session_start();
include "connection.php";
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="styleproduct.css">
</head>

<body>

    <?php include "header.php"; ?>

    <section id="products" class="container mt-5">
        <div class="container text-center mt-4 pt-4">
            <h2 class="form-weight-bold">Our Products</h2>
            <hr class="mx-auto">
        </div>

        <div class="prod-cat text-center">
            <?php
            $category = isset($_GET['category']) ? $_GET['category'] : 'All';
            ?>
            <a href="?category=All" class="category <?php echo ($category === 'All') ? 'active' : ''; ?>">All</a>
            <a href="?category=Cases" class="category <?php echo ($category === 'Cases') ? 'active' : ''; ?>">Phone Cases</a>
            <a href="?category=Airpods" class="category <?php echo ($category === 'Airpods') ? 'active' : ''; ?>">Airpods</a>
            <a href="?category=Accessories" class="category <?php echo ($category === 'Accessories') ? 'active' : ''; ?>">Accessories</a>
        </div>

        <hr>

        <div class="all-prod">
            <?php
            $limit = 6;
            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            $offset = ($page - 1) * $limit;

            $sql = "SELECT * FROM products";
            if ($category !== 'All') {
                $sql .= " WHERE category = ?";
            }
            $sql .= " LIMIT ? OFFSET ?";

            $stmt = $conn->prepare($sql);
            if ($category !== 'All') {
                $stmt->bind_param("sii", $category, $limit, $offset);
            } else {
                $stmt->bind_param("ii", $limit, $offset);
            }

            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="prod">';
                    $image_path = !empty($row['image']) ? "uploads/" . basename($row['image']) : "uploads/default.jpg";
                    echo '<img src="' . htmlspecialchars($image_path) . '" alt="' . htmlspecialchars($row['product_name']) . '">';
                    echo '<div class="prod-info">';
                    echo '<h4 class="prod-title">' . htmlspecialchars($row['model']) . '</h4>';
                    echo '<p class="prod-price">₱ ' . number_format($row['price'], 2) . '</p>';

                    if (!isset($row['stock']) || $row['stock'] <= 0) {
                        echo '<p class="sold-out">Sold Out</p>';
                    } else {
                        echo '<a href="singleproduct.php?id=' . $row['id'] . '" class="prod-btn">Add To Cart</a>';
                    }

                    echo '</div></div>';
                }
            } else {
                echo "<p>No products found.</p>";
            }
            ?>
        </div>

        <div class="pagination">
            <?php
            $count_sql = "SELECT COUNT(*) AS total FROM products";
            if ($category !== 'All') {
                $count_sql .= " WHERE category = ?";
            }

            $count_stmt = $conn->prepare($count_sql);
            if ($category !== 'All') {
                $count_stmt->bind_param("s", $category);
            }

            $count_stmt->execute();
            $count_result = $count_stmt->get_result();
            $total_products = $count_result->fetch_assoc()['total'];
            $total_pages = ceil($total_products / $limit);
            ?>

            <?php if ($page > 1): ?>
                <a href="?category=<?php echo urlencode($category); ?>&page=<?php echo $page - 1; ?>">&laquo; Prev</a>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <a href="?category=<?php echo urlencode($category); ?>&page=<?php echo $i; ?>" class="<?php echo ($page == $i) ? 'active' : ''; ?>">
                    <?php echo $i; ?>
                </a>
            <?php endfor; ?>

            <?php if ($page < $total_pages): ?>
                <a href="?category=<?php echo urlencode($category); ?>&page=<?php echo $page + 1; ?>">Next &raquo;</a>
            <?php endif; ?>
        </div>

    </section>

    <section id="banner">
        <div>

        </div>
    </section>

</body>

</html>