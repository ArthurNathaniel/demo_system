<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page
    header("Location: login.php");
    exit();
}

// Proceed with displaying the page content since the user is logged in
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Invoice</title>
    <?php include 'cdn.php' ?>
    <link rel="stylesheet" href="./css/base.css">
</head>

<body>
    <?php include 'sidebar.php'; ?>

    <div class="create_invoice_all">
        <h2>Create Invoice</h2>
        <form action="save_invoice.php" method="post">
            <div class="forms">
                <label>Billed to:</label>
                <input type="text" name="billed_to" required>
            </div>
            <div class="forms">
                <label>Contact Number:</label>
                <input type="text" name="contact_number" required>
            </div>

            <table border="1" class="invoice_table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Service</th>
                        <th>Day</th>
                        <th>Price</th>
                        <th>Amount</th>
                        <th>Actions</th>
                        <th><button type="button" onclick="addRow()">Add Row</button></th><!-- Add this column for delete button -->
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td><input type="text" name="service[]" required></td>
                        <td><input type="number" name="day[]" required></td>
                        <td><input type="number" name="price[]" required></td>
                        <td><input type="number" name="amount[]" required></td>
                        <td>
                            <button type="button" onclick="removeRow(this)">Remove</button>
                        </td> <!-- Add delete button -->
                    </tr>
                </tbody>
            </table>

            <div class="forms">
                <label>Subtotal:</label>
                <input type="number" name="subtotal" required>
            </div>
            <div class="forms">
                <label>VAT Tax:</label>
                <input type="number" name="vat_tax" required> <!-- Add VAT Tax input field -->
            </div>
            <div class="forms">
                <label>Total:</label>
                <input type="number" name="total" required>
            </div>

            <div class="forms">
                <button type="submit">Save Invoice</button>
            </div>
        </form>
    </div>

    <script>
        var rowNumber = 2; // Counter for row numbers

        function addRow() {
            var table = document.querySelector("table tbody");
            var newRow = table.insertRow();
            newRow.innerHTML = `
                <td>${rowNumber}</td>
                <td><input type="text" name="service[]"></td>
                <td><input type="number" name="day[]"></td>
                <td><input type="number" name="price[]"></td>
                <td><input type="number" name="amount[]"></td>
                <td><button type="button" onclick="removeRow(this)">Remove</button></td>
            `;
            rowNumber++; // Increment row number
        }

        function removeRow(button) {
            var row = button.parentNode.parentNode;
            row.parentNode.removeChild(row);
            updateRowNumbers(); // Update row numbers after deletion
        }

        function updateRowNumbers() {
            var table = document.querySelector("table tbody");
            var rows = table.querySelectorAll("tr");
            rowNumber = 1; // Reset row number counter
            rows.forEach(function(row, index) {
                row.cells[0].textContent = rowNumber++; // Update row number cell
            });
        }
    </script>
    <script src="../js/sidebar.js"></script>

</body>

</html>