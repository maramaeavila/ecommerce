<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="css/styleadmin.css">
</head>

<body>
    <nav class="sidebar">
        <h2>Admin Panel</h2>
        <ul>
            <li><a href="#dashboard">Dashboard</a></li>
            <li><a href="#products">Manage Products</a></li>
            <li><a href="#inventory">Inventory</a></li>
            <li><a href="#orders">Order Tracking</a></li>
            <li><a href="#users">User Management</a></li>
            <li><a href="#reports">Reports</a></li>
            <li><a href="#settings">Settings</a></li>
            <li><a href="#logout">Logout</a></li>
        </ul>
    </nav>
    <main class="content">
        <section id="dashboard">
            <h1>Dashboard</h1>
            <p>Overview of sales, inventory, and orders.</p>
        </section>
        <section id="products">
            <h1>Manage Products</h1>
            <button>Add New Product</button>
            <table>
                <tr>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Actions</th>
                </tr>
                <!-- Product rows here -->
            </table>
        </section>
        <section id="inventory">
            <h1>Inventory Management</h1>
            <p>Track product stock and restock alerts.</p>
        </section>
        <section id="orders">
            <h1>Order Tracking</h1>
            <p>Manage and track customer orders.</p>
        </section>
        <section id="users">
            <h1>User Management</h1>
            <p>Manage customer and staff accounts.</p>
        </section>
        <section id="reports">
            <h1>Reports</h1>
            <p>View sales, revenue, and analytics.</p>
        </section>
        <section id="settings">
            <h1>Settings</h1>
            <p>Adjust website and admin settings.</p>
        </section>
    </main>
</body>

</html>