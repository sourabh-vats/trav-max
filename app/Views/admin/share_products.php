<style>
    .overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.7);
        z-index: 1030;
    }

    .popup {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background: white;
        padding: 20px;
        text-align: center;
        z-index: 1000;
    }
</style>
<div class="overlay" id="overlay">
    <div class="popup" id="popup">
        <h3>Share This</h3>

        <a href="#" onclick="shareOnWhatsApp()" class="bi-whatsapp"> WhatsApp </a>
        <a href="#" onclick="shareOnInstagram()" class="bi-instagram"> Instagram </a>
        <a href="#" onclick="copyLink()" class="bi-link-45deg"> Copy Link</a>
        <br><br>
        <button id="close-popup">Close</button>
    </div>
</div>

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
    <?php foreach ($products as $product) : ?>
        <div class="col-md-4 mb-4">
            <div class="card">
                <img src="<?= $product['photo'] ?>" class="card-img-top" alt="<?= $product['name'] ?>">
                <div class="card-body">
                    <h5 class="card-title"><?= $product['name'] ?></h5>
                    <p class="card-text"><?= $product['description'] ?></p>
                    <p class="card-text">Price: $<?= $product['price'] ?></p>
                    <a href="#" class="share-button btn btn-primary">Share</a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<script>
    $(document).ready(function() {
        $(".share-button").click(function() {
            $("#overlay").fadeIn();
        });

        $("#close-popup").click(function() {
            $("#overlay").fadeOut();
        });
    });

    function shareOnWhatsApp() {
        var shareURL = 'yourShareURL';
        var imageURL = 'http://localhost:8080/images/addidas.png';

        var whatsappURL = 'https://api.whatsapp.com/send?' +
            'text=' + encodeURIComponent(shareURL) +
            '&media=' + encodeURIComponent(imageURL);

        window.open(whatsappURL, '_blank');
    }

    function shareOnInstagram() {
        var shareURL = 'yourShareURL';
        var instagramURL = 'https://www.instagram.com/create/story/' +
            '?url=' + encodeURIComponent(shareURL);
        window.open(instagramURL, '_blank');
    }

    function copyLink() {
        var shareURL = 'yourShareURL';
        var input = document.createElement('input');
        input.value = shareURL;
        document.body.appendChild(input);
        input.select();
        document.execCommand('copy');
        document.body.removeChild(input);
        alert('Link copied to clipboard');
    }
</script>