<?php
$pageTitle = 'View Applications';
include __DIR__ . '/includes/header.php';
include_once 'csv_handler.php';

$file = __DIR__ . '/applications.csv';
$search = trim($_GET['search'] ?? '');
?>

<div class="container" style="padding: 20px;">
    <h2>Internship Applications List</h2>

    <!-- Search Form -->
    <form method="GET" style="margin-bottom: 20px;">
        <input type="text" name="search" value="<?php echo htmlspecialchars($search); ?>" placeholder="Search by Company Name..." style="padding: 6px; width: 250px;">
        <button type="submit" style="padding: 6px 12px; cursor: pointer;">Search</button>
        <?php if (!empty($search)): ?>
            <a href="view_application.php" style="margin-left: 10px; text-decoration: none;">Reset</a>
        <?php endif; ?>
    </form>

    <!-- Data Display Table -->
    <table border="1" cellpadding="10" cellspacing="0" style="width:100%; border-collapse: collapse; background: #fff;">
        <tr style="background: #f2f2f2; text-align: left;">
            <th>ID</th>
            <th>Company Name</th>
            <th>Email</th>
            <th>Industry</th>
            <th>Status</th>
            <th>Date</th>
        </tr>

        <?php
        if (file_exists($file)) {
            $fp = fopen($file, 'r');
            $row_count = 0;
            $hasData = false;

            while (($data = fgetcsv($fp)) !== FALSE) {
                
                if ($row_count == 0) {
                    $row_count++;
                    continue;
                }

            
                if (!empty($search)) {
                    if (stripos($data[1], $search) === FALSE) {
                        continue;
                    }
                }

                $hasData = true;
                echo "<tr>";
                foreach ($data as $cell) {
                    echo "<td>" . htmlspecialchars($cell) . "</td>";
                }
                echo "</tr>";
            }
            fclose($fp);

            if (!$hasData) {
                echo "<tr><td colspan='6' style='text-align: center;'>No applications found.</td></tr>";
            }
        } else {
            echo "<tr><td colspan='6' style='text-align: center;'>No records file found!</td></tr>";
        }
        ?>
    </table>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
