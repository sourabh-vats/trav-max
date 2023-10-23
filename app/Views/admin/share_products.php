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
        padding: 20px 30px;
        z-index: 1000;
        width: 90%;
        max-width: 400px;
        text-align: left;
    }

    .popup-body>a {
        color: #000;
        margin-bottom: 20px;
        display: flex;

    }

    .close-popup {
        font-size: 25px;
        cursor: pointer;
    }

    .popup-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .popup-body {
        margin-top: 10px;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .icon {
        border: 1px solid gray;
        border-radius: 25px;
        width: 30px;
        height: 30px;
        display: flex;
        justify-content: center;
        align-items: center;

    }

    .icon>img {
        height: 15px;
        width: 15px;

    }
</style>
<div class="overlay" id="overlay">
    <div class="popup" id="popup">
        <div class="popup-header">

            <h3>Share Via</h3>
            <span class="close-popup" id="close-popup">&times;</span>
        </div>
        <div class="popup-body">
            <a href="#" onclick="shareOnWhatsApp()">
                <div style="display: flex; align-items:center">
                    <div class="icon"><img src="/images/whatsapp.png" /></div>
                    <div style="margin-left: 10px; ">WhatsApp</div>
                </div>
            </a>
            <a href="#" onclick="shareOnInstagram()">
                <div style="display: flex; align-items:center">
                    <div class="icon"><img src="/images/instagram.png" /></div>
                    <div style="margin-left: 10px;">Instagram </div>
                </div>
            </a>
            <a href="#" onclick="shareOnFacebook()">
                <div style="display: flex; align-items:center">
                    <div class="icon"><img src="/images/facebook.png" /></div>
                    <div style="margin-left: 10px;">Facebook </div>
                </div>
            </a>
            <a href="#" onclick="shareOnTwitter()">
                <div style="display: flex; align-items:center">
                    <div class="icon"><img src="/images/twitter.png" /></div>
                    <div style="margin-left: 10px;">Twitter </div>
                </div>
            </a>
            <a href="#" onclick="copyLink()" style="padding-bottom: 0px;">
                <div style="display: flex; align-items:center">
                    <div class="icon"><img src="/images/chain.png" /></div>
                    <div style="margin-left: 10px;"> Copy Link</div>
                </div>
            </a>
        </div>
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
    <?php

    use App\Controllers\Profile;

    foreach ($products as $product) : ?>
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
        var shareURL = '<?php echo base_url() ?>signup?refer_id=<?php echo $profile[0]['customer_id']; ?>';
        var imageURL = 'http://localhost:8080/images/addidas.png';

        var whatsappURL = 'https://api.whatsapp.com/send?' +
            'text=' + encodeURIComponent(shareURL) +
            '&media=' + encodeURIComponent(imageURL);

        window.open(whatsappURL, '_blank');
    }

    function shareOnInstagram() {
        var shareURL = '<?php echo base_url() ?>signup?refer_id=<?php echo $profile[0]['customer_id']; ?>';
        var instagramURL = 'https://www.instagram.com/create/story/' +
            '?url=' + encodeURIComponent(shareURL);
        window.open(instagramURL, '_blank');
    }

    function copyLink() {
        var shareURL = '<?php echo base_url() ?>signup?refer_id=<?php echo $profile[0]['customer_id']; ?>';
        var input = document.createElement('input');
        input.value = shareURL;
        document.body.appendChild(input);
        input.select();
        document.execCommand('copy');
        document.body.removeChild(input);
        alert('Link copied to clipboard');
    }
</script>