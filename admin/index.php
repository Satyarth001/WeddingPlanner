<?php
session_start();
include 'config.php';
include 'header.php';
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit();
}

$admin_id = $_SESSION['admin'];
$admin_query = $conn->query("SELECT username FROM admin WHERE id = $admin_id");

if (!$admin_query) {
    die("Admin Query Error: " . $conn->error);
}

$admin = $admin_query->fetch_assoc();

// Fetch next wedding date
$wedding_query = $conn->query("SELECT wedding_date FROM users ORDER BY wedding_date ASC LIMIT 1");
$wedding = $wedding_query ? $wedding_query->fetch_assoc() : null;
$wedding_date = $wedding ? $wedding['wedding_date'] : null;

$progress = 60; // Example progress percentage
?>

    
    <main>
        <h3>Let's plan some amazing weddings!</h3>
        
        <section class="countdown">
            <h4>Next Wedding Countdown</h4>
            <p id="countdown">Calculating...</p>
        </section>
        
        <section class="progress-bar">
            <h4>Overall Planning Progress</h4>
            <div class="bar">
                <div class="fill" style="width: <?php echo $progress; ?>%;"> <?php echo $progress; ?>% </div>
            </div>
        </section>
    </main>
    
<?php  include 'footer.php' ;?>
    
    <script>
        function updateCountdown() {
            const weddingDateStr = "<?php echo $wedding_date ? date('Y-m-d', strtotime($wedding_date)) : ''; ?>";
            if (!weddingDateStr) {
                document.getElementById("countdown").innerText = "No upcoming weddings";
                return;
            }
            
            const weddingDate = new Date(weddingDateStr).getTime();
            const now = new Date().getTime();
            const distance = weddingDate - now;
            
            if (distance < 0) {
                document.getElementById("countdown").innerText = "Wedding is today!";
            } else {
                const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                document.getElementById("countdown").innerText = `${days} days left`;
            }
        }
        
        updateCountdown();
    </script>
</body>
</html>
