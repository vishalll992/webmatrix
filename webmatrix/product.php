<div class="breadcrumb">
  <div class="container">
    <a href="index.php">Home</a> <i class="fas fa-chevron-right"></i>
    <a href="services.php">Services</a> <i class="fas fa-chevron-right"></i>
    <span>Web Design</span>
  </div>
</div>



<?php
include 'header.php';
include 'db.php';

$sql = "SELECT id, image, description, price FROM products ORDER BY id ASC";
$result = $conn->query($sql);

echo '
<style>
.product-grid {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 30px;
}
.product-card {
    background: #fff;
    border-radius: 20px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.12);
    width: 320px;
    padding: 22px;
    margin-bottom: 25px;
    display: flex;
    flex-direction: column;
    align-items: center;
    transition: box-shadow 0.2s, transform 0.2s;
    position: relative;
}
.product-card:hover {
    box-shadow: 0 8px 24px rgba(0,0,0,0.18);
    transform: scale(1.04);
}
.product-image {
    width: 180px;
    height: 180px;
    border-radius: 14px;
    object-fit: cover;
    margin-bottom: 16px;
    display: block;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
}
.product-desc {
    text-align: center;
    margin-bottom: 8px;
    font-size: 16px;
}
.product-price {
    font-weight: bold;
    margin-bottom: 18px;
    color: #0a9d5f;
    font-size: 18px;
}
.more-btn {
    border: none;
    background: #e3e3e3;
    color: #333;
    border-radius: 8px;
    padding: 5px 12px;
    margin-top: 5px;
    cursor: pointer;
}
</style>

<div class="product-grid">
';

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        // Truncate description for preview.
        $shortDesc = mb_substr($row['description'], 0, 60);
        // Unique ID for JS
        $cardId = 'desc_' . $row['id'];
        echo '
        <div class="product-card">
            <img class="product-image" src="' . $row['image'] . '" alt="Product Image" />
            <div class="product-desc" id="' . $cardId . '_short">' . htmlspecialchars($shortDesc) . (strlen($row['description']) > 60 ? '...' : '') . '</div>
            <div class="product-desc" id="' . $cardId . '_full" style="display:none;">' . htmlspecialchars($row['description']) . '</div>
            <button class="more-btn" onclick="
            var full = document.getElementById(\'' . $cardId . '_full\');
            var short = document.getElementById(\'' . $cardId . '_short\');
            if(full.style.display === \'none\'){full.style.display=\'block\';short.style.display=\'none\';this.textContent=\'Less\';}else{full.style.display=\'none\';short.style.display=\'block\';this.textContent=\'More\';}
            ">More</button>
            <div class="product-price">&#8377; ' . $row['price'] . '</div>
        </div>
        ';
    }
} else {
    echo 'No products found.';
}

echo '
</div>
';

$conn->close();
include 'footer.php';
?>
