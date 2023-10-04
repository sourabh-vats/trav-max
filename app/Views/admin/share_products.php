
<form action="/admin/share_products" method="POST">
    <div class="row">
        <div class="col-md-12 mb-3">
            <label for="categorySelect" class="form-label">Select a Category:</label>
            <select class="form-select" id="categorySelect" name="selected_category">
                <option value="all">All</option>
                <option value="Most Trending">Most Trending</option>
                <option value="Travel & Earn">Travel & Earn</option>
                <option value="Holiday Package">Holiday Package</option>
                <option value="Air Ticket">Air Ticket</option>
                <option value="Visas">Visas</option>
                <option value="Study Abroad">Study Abroad</option>
            </select>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 mb-3">
            <button type="submit" class="btn btn-primary">Filter</button>
        </div>
    </div>
</form>

<div class="row">
    <?php foreach ($products as $product): ?>
    <div class="col-md-4 mb-4">
        <div class="card">
            <img src="<?= $product['photo'] ?>" class="card-img-top" alt="<?= $product['name'] ?>">
            <div class="card-body">
                <h5 class="card-title"><?= $product['name'] ?></h5>
                <p class="card-text"><?= $product['description'] ?></p>
                <p class="card-text">Price: $<?= $product['price'] ?></p>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>



