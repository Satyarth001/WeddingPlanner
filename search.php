<?php
include 'config.php';

if (isset($_POST['search_query'])) {
    $search_query = mysqli_real_escape_string($conn, $_POST['search_query']);

    $query = "
        (SELECT id, category_name AS name, 'vendor_category' AS type FROM vendor_category WHERE category_name LIKE '%$search_query%')
        UNION
        (SELECT id, venue_name AS name, 'venue' AS type FROM venues WHERE venue_name LIKE '%$search_query%')
        UNION
        (SELECT id, tool_name AS name, 'tool' AS type FROM planning_tools WHERE tool_name LIKE '%$search_query%')
        LIMIT 10
    ";

    $result = mysqli_query($conn, $query);

    // Debugging: Check for query errors
    if (!$result) {
        die("SQL Error: " . mysqli_error($conn)); // Show SQL error for debugging
    }

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $link = '';
            if ($row['type'] === 'vendor_category') {
                $link = 'vendor-list.php?id=' . $row['id']; // Assuming a vendor listing page
            } elseif ($row['type'] === 'venue') {
                $link = 'venue-details.php?id=' . $row['id'];
            } elseif ($row['type'] === 'tool') {
                $link = 'tool-details.php?id=' . $row['id'];
            }
            echo '<a href="' . $link . '">' . ucfirst(str_replace('_', ' ', $row['type'])) . ': ' . $row['name'] . '</a>';
        }
    } else {
        echo '<a>No results found</a>';
    }
}
?>
