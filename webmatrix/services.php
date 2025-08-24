<?php
include 'header.php';
include 'db.php';

// Fetch services from DB
$sql = "SELECT * FROM services LIMIT 6"; // Get 6 services
$result = $conn->query($sql);

$services = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $services[] = $row;
    }
}
?>
<div class="breadcrumb">
  <div class="container">
    <a href="index.php">Home</a> <i class="fas fa-chevron-right"></i>
    <a href="services.php">Services</a> <i class="fas fa-chevron-right"></i>
    <span>Web Design</span>
  </div>
</div>

<section class="services">
  <div class="container">
    <h2 class="section-title">Our Services</h2>
<div class="services-grid">
<?php
foreach ($services as $service) {
  $descId = 'service_desc_' . $service['id'];
  $shortDesc = mb_substr($service['description'], 0, 80);
?>
  <div class="service-card">
    <div class="service-icon">
      <img src="<?php echo htmlspecialchars($service['image']); ?>" alt="<?php echo htmlspecialchars($service['title']); ?>">
    </div>
    <h3><?php echo htmlspecialchars($service['title']); ?></h3>
    <div class="service-desc" id="<?php echo $descId; ?>_short">
      <?php echo htmlspecialchars($shortDesc); ?><?php echo strlen($service['description']) > 80 ? '...' : ''; ?>
    </div>
    <div class="service-desc" id="<?php echo $descId; ?>_full" style="display:none;">
      <?php echo htmlspecialchars($service['description']); ?>
    </div>
    <?php if (strlen($service['description']) > 80): ?>
      
    <?php endif; ?>
    <a class="know-more-btn" href="service_details.php?id=<?php echo $service['id']; ?>">Know More</a>
  </div>
<?php } ?>
</div>
<?php include 'footer.php';?>